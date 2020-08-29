<?php


namespace Modules\Admin\Http\Repository;

use App\Http\Repository\BaseRepository;
use Illuminate\Support\Facades\Auth;

use Modules\Admin\Entities\Admin;
use Illuminate\Support\Facades\Hash;
use Modules\Users\Entities\User;
use Spatie\Permission\Models\Role;
use DB;

class AdminRepository
{
    /**
     * Display a listing of the resource.
     *get all admins
     * @return \Illuminate\Http\Response
     */
    public function index($request)
    {
        $user = User::orderBy('id', 'DESC')->where('is_admin', 1)->with(['roles'=>function($q){
            $q->select('id','name');
        }])->select('id','name','email','created_at');
        $users = (new BaseRepository())->paginationRepository($request,$user);
        return  array('count'=>$users['count'],"data"=>$users['data']);
    }

    /**
     * Store a newly created resource in storage.
     *add new admin with his roles
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store($data)
    {
        if ($user = User::where('email', $data['email'])->first()) {
            if ($user['is_admin'] == 1) {
                return "user Already Exists as Admin";
            } else {
                if (User::where('id', $user->id)->update(['is_admin' => 1])) {
                    $roleToAssign = Role::Find($data['role'] );
                    $user->assignRole($roleToAssign);
                    return $user;
                } else {
                    return false;
                }
            }
        } else {
            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            $user->is_admin = 1;
            if ($user->save()) {
                $roleToAssign = Role::Find($data['role'] );
                $user->assignRole($roleToAssign);
                return $user;
            } else return false;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *get user with his role
     * this method used in edit page
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if ($user->roles) {
             $user->roles;
         }
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update($data, $id)
    {
        $user = User::find($id);
        if (isset($data['name'])) $user->update(['name' => $data['name']]);
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        if ($data['role']) {
            $roleToAssign = Role::find($data['role']);
            $user->assignRole($roleToAssign->name);
        }
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->update(['is_admin' => 0]);
        return true;
    }

    public function login($user_id)
    {
        if ($role = DB::table("model_has_roles")->select('role_id', 'name')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('model_id', $user_id)->first()) {
            $permissions = DB::table("role_has_permissions")
                ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
                ->where("role_has_permissions.role_id", $role->role_id)
                ->select('permissions.id', 'permissions.name')
                ->get();
            $result = array('role' => $role, 'permission' => $permissions);
            return $result;
        } else {
            return false;
        }
    }

    public function checkPermissionLogin($user_id)
    {
        if ($role = DB::table("model_has_roles")->select('role_id', 'name')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('model_id', $user_id)->first()) {
            $permissions = DB::table("role_has_permissions")
                ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
                ->where("role_has_permissions.role_id", $role->role_id)
                ->pluck('permissions.id', 'permissions.name')
                ->all();
            $result = array('role' => $role, 'permission' => $permissions);
            return $result;
        } else {
            return false;
        }
    }

}
