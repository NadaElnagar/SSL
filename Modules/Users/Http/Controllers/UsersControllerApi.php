<?php

namespace Modules\Users\Http\Controllers;

use App\Http\Requests\pagination;
use App\Http\Services\SingletonService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Users\Http\Requests\EmailValidate;
use Modules\Users\Http\Requests\LoginValidation;
use Modules\Users\Http\Requests\UpdateRequest;
use Modules\Users\Http\Requests\UpdateUser;
use Modules\Users\Http\Services\UserServices;
use Modules\Users\Http\Requests\StoreUsers;
use Illuminate\Container\Container;
class UsersControllerApi extends Controller
{

    private $user;
    public function __construct( )
    {
        $this->user  = SingletonService::serviceInstance( UserServices::class);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function register(StoreUsers $request)
    {
       return $this->user->register($request);
    }
    public function login(LoginValidation $request)
    {
        return $this->user->login($request);
    }
    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function getUserDetails()
    {
        return $this->user->getuser();
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateRequest $request)
    {
        return $this->user->update($request);
    }
    public function updatePassword(UpdateRequest $request)
    {
        return $this->user->updatePassword($request);
    }
    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function logout()
    {
        return $this->user->logout();
    }
    public function listUser(pagination $request)
    {
        return $this->user->listUser($request);
    }
}
