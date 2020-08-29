<?php


namespace Modules\SSL\Http\Controllers;


use App\Http\Services\SingletonService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Cart\Http\Requests\CartValidation;
use Modules\SSL\Http\Services\SSLServices;
use Illuminate\Routing\Controller;

class SSLControllerApi extends Controller
{
    private $services;
    public function __construct()
    {
        $this->services  = SingletonService::serviceInstance(SSLServices::class);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function fetchDataSSL()
    {
        return $this->services->fetchDataSSL();
    }
    public function inviteOrder()
    {
        $user_id = Auth::user()->id;
        return $this->services->InviteOrder($user_id);
    }
}
