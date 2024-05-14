<?php
namespace Modules\Customer\Transformers\PaymentmethodAttrs;

use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class FullPaymentmethodAttrTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $paymentmeThod = [
            'id' => $this->resource->id,
            'is_require' =>(bool) $this->resource->is_require,
            'is_show' =>(bool) $this->resource->is_show,
            'type'=>$this->type
        ];
        foreach (LaravelLocalization::getSupportedLocales() as $locale => $supportedLocale) {
            $paymentmeThod[$locale] = [];
            foreach ($this->resource->translatedAttributes as $translatedAttribute) {
                $paymentmeThod[$locale][$translatedAttribute] = $this->resource->translateOrNew($locale)->$translatedAttribute;
            }
        }
        return $paymentmeThod;
    }
}
