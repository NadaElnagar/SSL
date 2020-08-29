<?php


namespace Modules\Admin\Http\Service;


use App\Helpers\StaticVariables;
use App\Http\Services\ResponseService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Admin\Http\Repository\AdminRepository;
use Modules\Notification\Entities\BodyMail;
use Modules\Notification\Http\Service\NotificationService;
use Modules\Users\Entities\User;
use Modules\Users\Http\Services\UserServices;

class AdminService extends ResponseService
{
    private $admin;
    public function __construct()
    {
        $this->admin = new AdminRepository();
    }
    /*get all admins*/
    public function index($request)
    {
        $admin = $this->admin->index($request);
        if ($admin) {
            return $this->responseWithSuccess($admin);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.No Content'));
        }
    }
    /*add new admin with his roles*/
    public function store($data)
    {
        $admin = $this->admin->store($data);
        if ($admin) {
            if(isset($admin['email'])){
                $mail_details =  BodyMail::find(StaticVariables::$CONGRATEULATION_AS_NEW_ADMIN);
                 $data=array('to'=>$admin['email'],'website_name'=>$mail_details->website_name
                 ,'title'=>'Hi,','subject'=>$mail_details->subject,
                    "body"=>$mail_details->body . $data['password']);
               (new NotificationService())->sendMail($data);
            }
            return $this->responseWithSuccess($admin);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, $admin);
        }
    }

    public function show($id)
    {
        $data = $this->admin->show($id);
        if ($data) {
            return $this->responseWithSuccess($data);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.Error, Please Try again Letter'));
        }
    }
     public function update($id, $data)
     {
         $data = $this->admin->update($id,$data);
         if ($data) {
             return $this->responseWithSuccess($data);
         } else {
             return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.Error, Please Try again Letter'));
         }
     }
     public function destroy($id)
     {
         $data = $this->admin->destroy($id);
         if ($data) {
             return $this->responseWithSuccess($data);
         } else {
             return $this->responseWithFailure(Response::HTTP_UNAUTHORIZED, __('messages.Error, Please Try again Letter'));
         }
     }
    public function login($data)
    {
        try{
            if (Auth::attempt(['email' => $data['email'], 'password' => $data['password'],'is_Admin'=>1])) {
                $user = Auth::user();
                $user->role_permission = $this->admin->login($user->id);
                $user->token = $user->createToken('MyApp')->accessToken;
                return $this->responseWithSuccess($user);
            } else {
                return $this->responseWithFailure(Response::HTTP_UNAUTHORIZED, __('messages.Unauthorized'));
            }
        } catch (\Exception $exception) {
            return $exception;
        }
    }
}
