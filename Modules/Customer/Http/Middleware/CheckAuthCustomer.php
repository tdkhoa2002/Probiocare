<?php

namespace Modules\Customer\Http\Middleware;

use Closure;

class CheckAuthCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!auth()->guard('customer')->check()) {
            return redirect()->route('fe.customer.customer.login');
        }

        return $next($request);
    }

}