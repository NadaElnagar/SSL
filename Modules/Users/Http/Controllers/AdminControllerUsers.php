<?php


namespace Modules\Users\Http\Controllers;


use App\Http\Services\SingletonService;
use Illuminate\Routing\Controller;
use Modules\Users\Http\Requests\ActiveUser;
use Modules\Users\Http\Services\UserServices;

class AdminControllerUsers extends Controller
{

    private $user;
    public function __construct( )
    {
        $this->user  = SingletonService::serviceInstance( UserServices::class);
    }
    public function activeUser(ActiveUser $request)
    {
        return $this->user->activeUser($request);
    }
}
