<?php
namespace Modules\Customer\Transformers\PaymentmethodAttrs;

use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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
            'created_at' => $this->resource->created_at->format('d-m-Y H:i:s'),
            'is_show' =>(bool) $this->resource->is_show,
            'type'=>$this->type,
            'urls' => [
                'delete_url' => route('api.customer.paymentmethodattr.destroy', $this->resource->id),
            ],
        ];
    }
}
