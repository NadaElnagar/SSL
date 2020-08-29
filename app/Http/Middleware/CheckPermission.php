<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use DB;
use Modules\Admin\Http\Repository\AdminRepository;
use Modules\Users\Entities\User;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {

        if (Auth::user() &&   Auth::user()->is_admin == 1) {
            $user_id= Auth::user()->id;
            $result= (new AdminRepository())->checkPermissionLogin($user_id);
            $permissions = $result['permission'];
              if(isset($permissions[$permission])){
                  return $next($request);
              }else{
                  return response()->json([
                      'responseMessage' => 'You do not have permission for this page access.',
                  ],Response::HTTP_UNAUTHORIZED);
              }
            return $next($request);
        }
        else{
            return response()->json([
                'responseMessage' => 'You do not have permission for this page access.',
            ],Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}
