<?php

namespace Modules\Customer\Http\Controllers;

use Modules\Core\Http\Controllers\Api\BaseApiController;
use Modules\Customer\Repositories\CountryRepository;
use Modules\Customer\Transformers\Countries\CountryTransformer;

class ApiPublicController extends BaseApiController
{
    private $countryRepository;
    public function __construct(
        CountryRepository $countryRepository,

    ) {
        parent::__construct();

        $this->countryRepository = $countryRepository;
    }

    public function listCountry()
    {
        try {
            $countries = $this->countryRepository->all();
            return $this->respondWithData(CountryTransformer::collection($countries));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }
}
