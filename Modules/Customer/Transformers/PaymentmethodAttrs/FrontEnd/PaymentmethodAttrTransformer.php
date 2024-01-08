<?php
namespace Modules\Customer\Transformers\PaymentmethodAttrs\FrontEnd;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentmethodAttrTransformer extends JsonResource
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
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'is_require' => (bool) $this->resource->is_require,
            'created_at' => $this->resource->created_at->format('d-m-Y H:i:s')
        ];
    }
}
