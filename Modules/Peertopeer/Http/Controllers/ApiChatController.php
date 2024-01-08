<?php

namespace Modules\Peertopeer\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Modules\Peertopeer\Events\PeertopeerChat;
use Modules\Peertopeer\Repositories\ChatRepository;
use Modules\Peertopeer\Repositories\OrderRepository;
use Pusher\Pusher;
use Carbon\Carbon;
use Modules\Peertopeer\Transformers\Market\MessageChatTransformer;
use Modules\Media\Services\FileService;
use Modules\Peertopeer\Entities\Chat;

class ApiChatController extends BaseApiController
{
    private $chatRepository;
    private $orderRepository;
    private $fileService;

    public function __construct(
        ChatRepository $chatRepository,
        OrderRepository $orderRepository,
        FileService $fileService
    ) {
        parent::__construct();
        $this->chatRepository = $chatRepository;
        $this->orderRepository = $orderRepository;
        $this->fileService = $fileService;
    }

    public function pusherAuth(Request $request) {
        try {
            $customer = auth()->guard('customer')->user();
            $user = $request->input('orderMySelf'); // get user auth
            $channelName = $request->input('channel_name');
            $socketId = $request->input('socket_id');

            $PUSHER_APP_KEY = config('broadcasting.connections.pusher.key');
            $PUSHER_APP_SECRET = config('broadcasting.connections.pusher.secret');
            $PUSHER_APP_ID = config('broadcasting.connections.pusher.app_id');
            $pusher = new Pusher($PUSHER_APP_KEY, $PUSHER_APP_SECRET, $PUSHER_APP_ID);
            $authData = $pusher->presence_auth($channelName, $socketId, $customer->id, $user);
            return $authData;
        } catch (\Exception $e) {
            \Log::channel('p2p_chat')->error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    public function getHistory(Request $request)
    {
        try {
            $params = $request->all();
            $conversationId = $params["conversation_id"] ?? null;
            $customer = auth()->guard('customer')->user();
            $messages = $this->chatRepository->getByAttributes([
                'order_id' => $conversationId
            ]);
            // dd($messages[139]->attachChat());
            $order = $this->orderRepository->find($conversationId);
            $userA = [
                "user_name" => $order->customer->profile()->first()->fullname,
                "user_id" => $order->customer->id,
                "user_avatar" => $order->customer->profile()->first()->firstname
            ];

            $userB = [
                "user_name" => $order->seller->profile()->first()->fullname,
                "user_id" => $order->seller->id,
                "user_avatar" => $order->seller->profile()->first()->firstname
            ];

            $data = [
                "conversation_id" => $conversationId,
                "members" =>[$userA, $userB],
                "messages" => MessageChatTransformer::collection($messages), // Convert messages to an array
            ];
            return $this->respondWithData($data);
        } catch (\Exception $e) {
            \Log::channel('p2p_chat')->error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    public function pushMessage(Request $request)
    {
        try {
            $customer = auth()->guard('customer')->user();

            $params = $request->only(["user_id", "message", "conversation_id"]);
            $message = [
                "order_id" => $params["conversation_id"] ?? 0,
                "customer_id" => $customer->id,
                "message" => $params["message"] ?? ""
            ];
            
            $newMessage = $this->chatRepository->create($message);

            if ($request->hasFile('attach')) {
                $uploadedFile = $this->fileService->store($request->file('attach'));
                if ($uploadedFile) {
                    $newMessage->files()->attach($uploadedFile->id, ['imageable_type' => Chat::class, 'zone' => 'ATTACH_CHAT']);
                }
            }
            $newMessage = new MessageChatTransformer($newMessage);
            broadcast(new PeertopeerChat($newMessage))->via('pusher');
            return $this->respondWithData($newMessage);
        } catch (\Exception $e) {
            \Log::channel('p2p_chat')->error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }

    }
}
