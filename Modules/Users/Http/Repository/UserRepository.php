<?php


namespace Modules\Users\Http\Repository;

use App\Http\Repository\BaseRepository;
use Carbon\Carbon;
use Modules\Order\Entities\Order;
use Modules\Users\Entities\PasswordReset;
use Modules\Users\Entities\User;
use DB;
use Illuminate\Support\Str;

class UserRepository
{
    public function create($data)
    {
        // TODO: Implement create() method.
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = $data['password'];
        $user->wallet_ballance = 0;
        if ($user->save()) return $user;
        else return false;
    }

    public function update($id, $data)
    {
        // TODO: Implement update() method.
        $user = User::find($id);

        if ($data['name']) $user->name = $data['name'];
        if ($data['hash_new_password']) $user->password = $data['hash_new_password'];
        if ($user->save()) return $user; else return false;

    }

    public function sendPasswordResetToken($request)
    {
        $user = User::where('email', $request['email'])->first();
        if (!$user) return false;
        //create a new token to be sent to the user.
        $passwordReset = PasswordReset::firstOrNew(['email' => $request['email']]);
        $passwordReset->token = Str::random(5);
        $passwordReset->created_at = Carbon::now();
        if($passwordReset->save()){
            return $passwordReset;
        }else{
            return false;
        }
    }

    /**
     * Find token password reset
     *
     * @param  [string] $token
     * @return [string] message
     * @return [json] passwordReset object
     */

    private function findResetPasswordValidateLink($request)
    {
        $passwordReset = PasswordReset::where('token', $request['token'])->where('email',$request['email'])->first();
        if (!$passwordReset) return false;
        if (Carbon::parse($passwordReset->created_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return false;
        }
        return $passwordReset;
    }
    /**
     * Reset password
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @param  [string] token
     * @return [string] message
     * @return [json] user object
     */
    public function resetPassword($request)
    {
        $passwordReset = $this->findResetPasswordValidateLink($request);
        if (!$passwordReset) return 2;//'This password reset token is invalid.'
        $user = User::where('email', $passwordReset->email)->first();
        if (!$user) return false;//"We can't find a user with that e-mail address."
        $user->password = $request['password'];
        $user->save();
        PasswordReset::where([['email', $request['email']]])->delete();
        //   $user->notify(new PasswordResetSuccess($passwordReset));
        return true;
    }

    public function login($data)
    {
        if ($email = User::where('email', $data['email'])->first()) {
            return $email;
        } else {
            return false;
        }
    }

    public function listUser($request)
    {
        $result = array();
        $user = (new User())->newQuery();
        $query = $user->where('is_admin', 0);
        $users = (new BaseRepository())->paginationRepository($request, $query);
        if ($users['data']) {
            foreach ($users['data'] as $user_details) {
                $user_details['number_order'] = $this->countOrders($user_details->id);
                $details[] = $user_details;
            }
            $result['count'] = $users['count'];
            $result['users'] = $details;
            return $result;
        }
        return $result;
    }

    private function countOrders($user_id)
    {
        return Order::where('user_id', $user_id)->count();
    }

    public function activeUser($data)
    {
        return User::where('id', $data['id'])->update(['active' => $data['active']]);
    }
}
