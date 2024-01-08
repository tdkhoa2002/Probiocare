<?php

namespace Modules\Core\Http\Controllers\Api;

use Illuminate\Routing\Controller;

abstract class BaseApiController extends Controller
{
    protected $statusCode = 200;

    public function __construct()
    {
    }

    protected function getStatusCode()
    {
        return $this->statusCode;
    }

    protected function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    protected function respondWithError($message = null, $stautsCode = null)
    {
        if (is_null($stautsCode)) {
            $this->setStatusCode(200);
        } else {
            $this->setStatusCode($stautsCode);
        }
        $response = [
            'error' => true,
            'error_code' => $this->getStatusCode(),
            'message' => $message,
        ];

        return $this->respondWithArray($response);
    }

    protected function respondWithValidateError($message = null, $data = [], $stautsCode = null)
    {
        if (is_null($stautsCode)) {
            $this->setStatusCode(200);
        } else {
            $this->setStatusCode($stautsCode);
        }
        $response = [
            'error' => true,
            'validate' => true,
            'error_code' => $this->getStatusCode(),
            'message' => $message,
            'data' => $data
        ];

        return $this->respondWithArray($response);
    }

    protected function respondWithArray(array $array, array $headers = [])
    {
        return response()->json($array, $this->statusCode, $headers);
    }

    protected function respondWithSuccess($data = [])
    {
        $response = [
            'error' => false,
            'error_code' => $this->getStatusCode(),
            'data' => $data,
        ];

        return $this->respondWithArray($response);
    }

    protected function respondWithData($data = [], array $headers = [])
    {
        $array = array_merge([
            'error' => false,
            'error_code' => $this->getStatusCode(),
            'data' => $data,
        ]);
        return $this->respondWithArray($array, $headers);
    }
}
