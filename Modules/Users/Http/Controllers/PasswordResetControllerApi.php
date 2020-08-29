<?php


namespace Modules\Users\Http\Controllers;


use App\Http\Services\SingletonService;
use Illuminate\Routing\Controller;
use Modules\Users\Http\Requests\EmailValidate;
use Modules\Users\Http\Requests\ResetPasswordRequest;
use Modules\Users\Http\Services\UserServices;

class PasswordResetControllerApi extends Controller
{
    private $user;
    public function __construct( )
    {
        $this->user  = SingletonService::serviceInstance( UserServices::class);
    }
    public function sendPasswordResetToken(EmailValidate $request)
    {
        return $this->user->sendPasswordResetToken($request);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        return $this->user->resetPassword($request);
    }
}
