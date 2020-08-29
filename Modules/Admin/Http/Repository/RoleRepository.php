<?php


namespace Modules\Admin\Http\Repository;


use App\Http\Repository\BaseRepository;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Modules\Users\Entities\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use DB;

class RoleRepository
{
    use Authorizable;

    public function index()
    {
        $data['roles'] = Role::all();
        $data['permissions'] = Permission::all();
        return $data;
    }

    public function store($data)
    {
        if (Role::where('name', $data['name'])->first()) {
            return "Role Name Exists Before";
        } else {
            $role = Role::create(['name' => $data['name'], 'guard_name' => 'api']);
            $role->givePermissionTo([$data['permission']]);
            if ($role) {
                return true;
            } else return false;
        }
    }

    public function update($id, $data)
    {
        if ($id == 1) {
            return "Can't Update This Role";
        } else {
            $role = Role::find($id);
            if (isset($data['name']) && $role['name'] != null) {
                $role->name = $data['name'];
                $role->save();
            }
            if ($data['permission']) $role->syncPermissions($data['permission']);
            return $role;
        }
    }

    public function destroy($id)
    {
        if ($id == 1) {
            return "Can't delete This Role";
        } else {
            DB::table("roles")->where('id', $id)->delete();
        }
        return true;
    }

    public function edit($id)
    {
        $role = Role::find($id);
            $role['permission'] = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
                ->join('permissions', 'permissions.id', 'role_has_permissions.permission_id')
                ->select('permissions.id', 'permissions.name')
                ->get();
            return $date = ['role' => $role];

    }

    public function listPermission()
    {
        return Permission::all();
    }

    public function getAllRoleRelatdPermission($request)
    {
        $array_role = array();
        $role_query = (new Role())->newQuery();
        $roles = (new BaseRepository())->paginationRepository($request, $role_query);
        if ($roles['data']) {
            foreach ($roles['data'] as $role) {
                $permission = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $role->id)
                    ->join('permissions', 'permissions.id', 'role_has_permissions.permission_id')
                    ->select('permissions.id', 'permissions.name')
                    ->get();
                if ($permission) {
                    $array_role[] = array('role' => $role, 'permission' => $permission);
                }
            }
            $result['count'] = $roles['count'];
            $result['data'] = $array_role;
        }
        return $result;
    }
}
