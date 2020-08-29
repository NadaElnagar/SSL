<?php


namespace Modules\Users\Http\Services;

use App\Helpers\StaticVariables;
use App\Http\Services\CacheService;
use App\Http\Services\ResponseService;
use App\Http\Services\SingletonService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Modules\Notification\Entities\BodyMail;
use Modules\Notification\Http\Service\NotificationService;
use Modules\Users\Entities\User;
use Modules\Users\Http\Repository\UserRepository;
use Users\Http\Requests\StoreUsers;
use Illuminate\Support\Facades\Auth;

class UserServices extends ResponseService
{
    public function __construct()
    {
        $this->user = SingletonService::serviceInstance(UserRepository::class);
    }

    public function register($data)
    {
        $data['password'] = Hash::make($data['password']);
        $user = $this->user->create($data);
        if ($user) {
            $user->token = $user->createToken('MyApp')->accessToken;
            return $this->responseWithSuccess($user);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, $user);
        }
    }

    public function login($data)
    {
        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            $user = Auth::user();
            $user->token = $user->createToken('MyApp')->accessToken;
            return $this->responseWithSuccess($user);
        } else {
            return $this->responseWithFailure(Response::HTTP_UNAUTHORIZED, __('messages.Unauthorized'));
        }
    }

    public function getuser()
    {
        $user = Auth::user();
        if ($user) {
            return $this->responseWithSuccess($user);
        } else {
            return $this->responseWithFailure(Response::HTTP_UNAUTHORIZED, __('messages.Unauthorized'));
        }
    }

    public function update($data)
    {
        $user_id = Auth::user()->id;
        $user = $this->user->update($user_id, $data);
        if ($user) {
            return $this->responseWithSuccess($user);
        } else {
            return $this->responseWithFailure(Response::HTTP_UNAUTHORIZED, __('messages.Unauthorized'));
        }
    }

    public function updatePassword($data)
    {
        $user_id = Auth::user()->id;
        $hashedPassword = Auth::user()->password;
        if ($data['new_password'] && $data['old_password']) {
            $oldPassword = $data['old_password'];
            if (Hash::check($oldPassword, $hashedPassword)) {
                $data['hash_new_password'] = Hash::make($data['new_password']);
                $user = $this->user->update($user_id, $data);
                if ($user) {
                    return $this->responseWithSuccess($user);
                } else {
                    return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, $user);
                }
            } else {
                return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __("messages.old password is wrong"));
            }
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __("messages.old and New Password Required Fields"));
        }
    }

    public function logout()
    {
        // TODO: Implement logout() method.
        if (Auth::check()) {
            Auth::user()->token()->revoke();
            return $this->responseWithSuccess(__('messages.logout_success'));
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, Null);
        }
    }

    public function sendPasswordResetToken($request)
    {
        $user = $this->user->sendPasswordResetToken($request);
        if ($user) {
            $url =  $user['token'];
            $mail = BodyMail::find(StaticVariables::$FORGET_PASSWORD_SSL_TO_SECURE);
            $data = array('to' => $user['email'], 'website_name' => $mail->website_name
            , 'title' => 'Hi,', 'subject' => $mail->subject,
                "body" => $mail->body . $url
            );
            (new NotificationService())->sendMail($data);
            return $this->responseWithSuccess(__('messages.We have e-mailed your password reset link!.'));
        } else {
            return $this->responseWithFailure(Response::HTTP_UNAUTHORIZED, __("messages.We can't find a user with that e-mail address."));
        }
    }

    public function resetPassword($request)
    {
        $request['password'] = Hash::make($request['password']);
        $user = $this->user->resetPassword($request);
        if ($user == true ) {
            return $this->responseWithSuccess(__("messages.Now You Can Login"));
        }elseif ($user == 2) {
            return $this->responseWithFailure(Response::HTTP_UNAUTHORIZED, __("messages.This password reset token is invalid."));
        }else{
            return $this->responseWithFailure(Response::HTTP_UNAUTHORIZED, __("messages.This password reset token is invalid."));
        }
    }

    public function listUser($request)
    {
        $user = $this->user->listUser($request);
        if ($user) {
            return $this->responseWithSuccess($user);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __("messages.Error, Please Try again Letter"));
        }
    }

    public function activeUser($data)
    {
        $user = $this->user->activeUser($data);
        if ($user) {
            return $this->responseWithSuccess(null);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __("messages.Error, Please Try again Letter"));
        }
    }
}
