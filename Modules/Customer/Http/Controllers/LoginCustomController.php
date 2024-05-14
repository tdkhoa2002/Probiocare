<?php
namespace Modules\Customer\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Modules\Core\Http\Controllers\BasePublicController;

class LoginCustomController extends BasePublicController
{
    public function __construct() {
        parent::__construct();
        
    }

    public function login()
    {
        try {
            if (auth()->guard('customer')->check()) {
                return redirect()->route('fe.wallet.wallet.list');
            }
            return view('auths.signin');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }

    public function verifyLogin(Request $request)
    {
        try {
            $dataRequest = $request->all();
            $isEmail = $dataRequest['isEmail'] ?? "";
            $email = $dataRequest['email'] ?? "";
            return view('auths.verify-login', ['isEmail' => $isEmail, 'email' => $email]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }
}
