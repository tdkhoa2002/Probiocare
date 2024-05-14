<?php
namespace Modules\Customer\Transformers\Paymentmethods;

use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class FullPaymentmethodTransformer extends JsonResource
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
            'status' =>(bool) $this->resource->status,
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
