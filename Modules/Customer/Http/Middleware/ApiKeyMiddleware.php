<?php

namespace Modules\Customer\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Customer\Repositories\CustomerApiKeyRepository;
use Modules\Core\Http\Controllers\Api\BaseApiController;

class ApiKeyMiddleware extends BaseApiController
{
    private $apiToken;

    public function __construct(CustomerApiKeyRepository $apiToken)
    {
        $this->apiToken = $apiToken;
    }
    
    public function handle(Request $request, Closure $next)
    {
        if ($request->header('api-key') === null) {
            return $this->respondWithError(trans('customer::customerapitoken.messages.api_token_invalid'));
        }

        if ($this->isValidToken($request->header('api-key')) === false) {
            return $this->respondWithError(trans('customer::customerapitoken.messages.api_token_invalid'));
        }

        if ($this->isExpired($request->header('api-key')) === false) {
            return $this->respondWithError(trans('customer::customerapitoken.messages.api_token_expired'));
        }
        return $next($request);
    }

    private function isValidToken($token)
    {
        $apiToken = $this->apiToken->findByAttributes(['token' => $token]);

        if ($apiToken === null) {
            return false;
        }

        return true;
    }

    private function isExpired($token)
    {
        $apiToken = $this->apiToken->findByAttributes(['token' => $token]);
        $now = now();
        $expired_at = Carbon::parse($apiToken->expired_at);
        if($now > $expired_at) {
            return false;
        }
        return true;
    } 
}
