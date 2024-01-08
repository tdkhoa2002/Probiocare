<?php

namespace Modules\Peertopeer\Transformers\Market;

use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class MessageChatTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->resource->id,
            "sender_id" => $this->resource->customer_id,
            "message" => $this->resource->message,
            "attach" => [
                "link" => $this->attachChat() ? $this->attachChat()->path_string : null,
                "type" => $this->attachChat()? $this->attachChat()->mimetype : null,
            ],
            // "attach" => $this->attachChat() ? $this->attachChat()->path_string : null,
            "order_id" => $this->resource->order_id
        ];
    }
}
