<?php

namespace Modules\Customer\Transformers\Customers;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerKycTransformer extends JsonResource
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
            'pathFileBack' =>   $this->resource->imageBack() ? $this->imageBack()->path_string : "",
            'pathFileFront' =>   $this->imageFront() ? $this->imageFront()->path_string : "",
            'pathFileSelfi' =>   $this->resource->imageSelfie() ? $this->imageSelfie()->path_string : "",
            'country_id' =>   $this->resource->country_id,
            'birthday' =>   $this->resource->birthday,
            'id_type' =>   $this->resource->type,
            'id_number' =>   $this->resource->number,
            'firstname' =>   $this->resource->first_name,
            'lastname' =>   $this->resource->last_name,
        ];
    }
}
