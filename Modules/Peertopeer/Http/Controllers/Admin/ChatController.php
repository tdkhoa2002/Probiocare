<?php

namespace Modules\Peertopeer\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Peertopeer\Entities\Chat;
use Modules\Peertopeer\Http\Requests\CreateChatRequest;
use Modules\Peertopeer\Http\Requests\UpdateChatRequest;
use Modules\Peertopeer\Repositories\ChatRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class ChatController extends AdminBaseController
{
    /**
     * @var ChatRepository
     */
    private $chat;

    public function __construct(ChatRepository $chat)
    {
        parent::__construct();

        $this->chat = $chat;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$chats = $this->chat->all();

        return view('peertopeer::admin.chats.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('peertopeer::admin.chats.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateChatRequest $request
     * @return Response
     */
    public function store(CreateChatRequest $request)
    {
        $this->chat->create($request->all());

        return redirect()->route('admin.peertopeer.chat.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('peertopeer::chats.title.chats')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Chat $chat
     * @return Response
     */
    public function edit(Chat $chat)
    {
        return view('peertopeer::admin.chats.edit', compact('chat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Chat $chat
     * @param  UpdateChatRequest $request
     * @return Response
     */
    public function update(Chat $chat, UpdateChatRequest $request)
    {
        $this->chat->update($chat, $request->all());

        return redirect()->route('admin.peertopeer.chat.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('peertopeer::chats.title.chats')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Chat $chat
     * @return Response
     */
    public function destroy(Chat $chat)
    {
        $this->chat->destroy($chat);

        return redirect()->route('admin.peertopeer.chat.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('peertopeer::chats.title.chats')]));
    }
}
