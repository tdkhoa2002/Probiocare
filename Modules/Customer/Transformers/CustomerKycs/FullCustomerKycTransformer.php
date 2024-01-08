<?php

namespace Modules\Customer\Transformers\CustomerKycs;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Customer\Transformers\Countries\CountryTransformer;

class FullCustomerKycTransformer extends JsonResource
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
            'number' => $this->resource->number,
            'type' => $this->resource->type,
            'reason' => $this->resource->reason,
            'country' => new CountryTransformer($this->country),
            'first_name' => $this->resource->first_name,
            'last_name' => $this->resource->last_name,
            'birthday' => $this->resource->birthday,
            'front_image'=>$this->imageFront() ?$this->imageFront()->path_string:null,
            'back_image'=>$this->imageBack() ?$this->imageBack()->path_string:null,
            'selfi_image'=>$this->imageSelfie() ?$this->imageSelfie()->path_string:null,
            'created_at' => $this->resource->created_at->format('d-m-Y H:i:s'),
        ];
    }
}
