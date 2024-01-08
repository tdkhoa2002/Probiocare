<?php

namespace Modules\Customer\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Modules\Customer\Entities\CustomerKyc;
use Modules\Customer\Http\Requests\FrontEnd\RequestKycRequest;
use Modules\Customer\Http\Requests\FrontEnd\UpdateKycRequest;
use Modules\Customer\Repositories\CountryRepository;
use Modules\Customer\Repositories\CustomerRepository;
use Modules\Customer\Repositories\CustomerCodeRepository;
use Modules\Customer\Repositories\CustomerKycRepository;
use Modules\Customer\Transformers\Customers\CustomerKycTransformer;
use Modules\Media\Services\FileService;

class KycApiController extends BaseApiController
{
    /**
     * @var Application
     */
    private $app;
    private $countryRepository;
    private $customerRepository;
    private $customerCodeRepository;
    private $customerKycRepository;
    private $fileService;


    public function __construct(
        Application $app,
        CountryRepository $countryRepository,
        CustomerRepository $customerRepository,
        CustomerCodeRepository $customerCodeRepository,
        CustomerKycRepository $customerKycRepository,
        FileService $fileService
    ) {
        parent::__construct();
        $this->app = $app;
        $this->countryRepository = $countryRepository;
        $this->customerRepository = $customerRepository;
        $this->customerCodeRepository = $customerCodeRepository;
        $this->customerKycRepository = $customerKycRepository;
        $this->fileService = $fileService;
    }

    public function requestKyc(RequestKycRequest $request)
    {
        try {
            $customer = auth()->guard('customer')->user();
            if ($customer->status_kyc == 0) {
                $checkKyc = $this->customerKycRepository->findByAttributes(['customer_id' => $customer->id]);
                if ($checkKyc) {
                    return $this->respondWithError(trans('customer::customerkycs.messages.cant_request_kyc'));
                } else {
                    $dataCreate = [
                        'customer_id' => $customer->id,
                        'number' => $request->get('id_number'),
                        'type' => $request->get('id_type'),
                        'reason' => null,
                        'country_id' => $request->get('country_id'),
                        'first_name' => $request->get('firstname'),
                        'last_name' => $request->get('lastname'),
                        'birthday' => $request->get('birthday'),
                    ];
                    $kyc = $this->customerKycRepository->create($dataCreate);
                    if ($kyc) {
                        if ($request->hasFile('back_image')) {
                            $uploadedFile = $this->fileService->store($request->file('back_image'));
                            if ($uploadedFile) {
                                $kyc->files()->attach($uploadedFile->id, ['imageable_type' => CustomerKyc::class, 'zone' => 'CUSTOMER_KYC_BACK']);
                            }
                        }
                        if ($request->hasFile('front_image')) {
                            $uploadedFile = $this->fileService->store($request->file('front_image'));
                            if ($uploadedFile) {
                                $kyc->files()->attach($uploadedFile->id, ['imageable_type' => CustomerKyc::class, 'zone' => 'CUSTOMER_KYC_FRONT']);
                            }
                        }
                        if ($request->hasFile('selfi_image')) {
                            $uploadedFile = $this->fileService->store($request->file('selfi_image'));
                            if ($uploadedFile) {
                                $kyc->files()->attach($uploadedFile->id, ['imageable_type' => CustomerKyc::class, 'zone' => 'CUSTOMER_KYC_SELFIE']);
                            }
                        }

                        $this->customerRepository->update($customer, ['status_kyc' => 1]);
                        return $this->respondWithSuccess(['message' => trans('customer::customerkycs.messages.request_kyc_success'), 'url' => route('fe.customer.customer.setting')]);
                    } else {
                        return $this->respondWithError(trans('customer::customerkycs.messages.request_kyc_error'));
                    }
                }
            } else {
                return $this->respondWithError(trans('customer::customerkycs.messages.cant_request_kyc'));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError('Send kyc error');
        }
    }

    public function updateKyc(UpdateKycRequest $request)
    {
        try {
            $customer = auth()->guard('customer')->user();
            if ($customer->status_kyc == 3) {
                $checkKyc = $this->customerKycRepository->findByAttributes(['customer_id' => $customer->id]);
                if ($checkKyc) {
                    $dataUpdate = [
                        'number' => $request->get('id_number'),
                        'type' => $request->get('id_type'),
                        'reason' => null,
                        'country_id' => $request->get('country_id'),
                        'first_name' => $request->get('firstname'),
                        'last_name' => $request->get('lastname'),
                        'birthday' => $request->get('birthday'),
                    ];
                    $this->customerKycRepository->update($checkKyc, $dataUpdate);
                    if ($request->hasFile('back_image')) {
                        $uploadedFile = $this->fileService->store($request->file('back_image'));
                        if ($uploadedFile) {
                            $currentFile = $checkKyc->imageBack();
                            $this->fileService->delete($currentFile);
                            $checkKyc->files()->attach($uploadedFile->id, ['imageable_type' => CustomerKyc::class, 'zone' => 'CUSTOMER_KYC_BACK']);
                        }
                    }
                    if ($request->hasFile('front_image')) {
                        $uploadedFile = $this->fileService->store($request->file('front_image'));
                        if ($uploadedFile) {
                            $currentFile = $checkKyc->imageFront();
                            if ($currentFile) {
                                $this->fileService->delete($currentFile);
                            }
                            $checkKyc->files()->attach($uploadedFile->id, ['imageable_type' => CustomerKyc::class, 'zone' => 'CUSTOMER_KYC_FRONT']);
                        }
                    }
                    if ($request->hasFile('selfi_image')) {
                        $uploadedFile = $this->fileService->store($request->file('selfi_image'));
                        if ($uploadedFile) {
                            $currentFile = $checkKyc->imageSelfie();
                            $this->fileService->delete($currentFile);
                            $checkKyc->files()->attach($uploadedFile->id, ['imageable_type' => CustomerKyc::class, 'zone' => 'CUSTOMER_KYC_SELFIE']);
                        }
                    }

                    $this->customerRepository->update($customer, ['status_kyc' => 1]);
                    return $this->respondWithSuccess(['message' => trans('customer::customerkycs.messages.request_kyc_success'), 'url' => route('fe.customer.customer.setting')]);
                } else {
                    $dataCreate = [
                        'customer_id' => $customer->id,
                        'number' => $request->get('id_number'),
                        'type' => $request->get('id_type'),
                        'reason' => null,
                        'country_id' => $request->get('country_id'),
                        'first_name' => $request->get('firstname'),
                        'last_name' => $request->get('lastname'),
                        'birthday' => $request->get('birthday'),
                    ];
                    $kyc = $this->customerKycRepository->create($dataCreate);
                    if ($kyc) {
                        if ($request->hasFile('back_image')) {
                            $uploadedFile = $this->fileService->store($request->file('back_image'));
                            if ($uploadedFile) {
                                $kyc->files()->attach($uploadedFile->id, ['imageable_type' => CustomerKyc::class, 'zone' => 'CUSTOMER_KYC_BACK']);
                            }
                        }
                        if ($request->hasFile('front_image')) {
                            $uploadedFile = $this->fileService->store($request->file('front_image'));
                            if ($uploadedFile) {
                                $kyc->files()->attach($uploadedFile->id, ['imageable_type' => CustomerKyc::class, 'zone' => 'CUSTOMER_KYC_FRONT']);
                            }
                        }
                        if ($request->hasFile('selfi_image')) {
                            $uploadedFile = $this->fileService->store($request->file('selfi_image'));
                            if ($uploadedFile) {
                                $kyc->files()->attach($uploadedFile->id, ['imageable_type' => CustomerKyc::class, 'zone' => 'CUSTOMER_KYC_SELFIE']);
                            }
                        }

                        $this->customerRepository->update($customer, ['status_kyc' => 1]);
                        return $this->respondWithSuccess(['message' => trans('customer::customerkycs.messages.request_kyc_success'), 'url' => route('fe.customer.customer.setting')]);
                    } else {
                        return $this->respondWithError(trans('customer::customerkycs.messages.request_kyc_error'));
                    }
                }
            } else {
                return $this->respondWithError(trans('customer::customerkycs.messages.cant_request_kyc'));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError('Send kyc error');
        }
    }

    public function getCurrentKyc()
    {
        try {
            $customer = auth()->guard('customer')->user();
            $kyc = $customer->kyc;
            if ($kyc) {
                return $this->respondWithSuccess(['kyc' => new CustomerKycTransformer($kyc)]);
            } else {
                return $this->respondWithSuccess(['kyc' => null]);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError('Send kyc error');
        }
    }
}
