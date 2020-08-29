<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Users\Entities\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        // create permissions
        $permission = Permission::firstOrNew(['name' => 'role']);
        $permission->guard_name = "api";
        $permission->save();

        $permission = Permission::firstOrNew(['name' => 'admin']);
        $permission->guard_name = "api";
        $permission->save();
        Permission::firstOrNew(['name' => 'faq']);
        $permission->guard_name = "api";
        $permission->save();
        $permission = Permission::firstOrNew(['name' => 'setting']);
        $permission->guard_name = "api";
        $permission->save();
        $permission = Permission::firstOrNew(['name' => 'product']);
        $permission->guard_name = "api";
        $permission->save();
        $permission = Permission::firstOrNew(['name' => 'ticket']);
        $permission->guard_name = "api";
        $permission->save();
        $permission = Permission::firstOrNew(['name' => 'order']);
        $permission->guard_name = "api";
        $permission->save();
        $permission = Permission::firstOrNew(['name' => 'category']);
        $permission->guard_name = "api";
        $permission->save();
        $permission = Permission::firstOrNew(['name' => 'home_page']);
        $permission->guard_name = "api";
        $permission->save();
        $permission = Permission::firstOrNew(['name' => 'faq']);
        $permission->guard_name = "api";
        $permission->save();
        $permission = Permission::firstOrNew(['name' => 'reports']);
        $permission->guard_name = "api";
        $permission->save();
        // create roles and assign created permissions
        Role::where('name','super-admin')->delete();
        Role::where('name','Super Admin')->delete();
        Role::where('id',1)->delete();
        $role = Role::firstOrNew(['id'=>1,'name' => 'Super Admin']);
        $role->guard_name = "api";
        $role->save();
        $role->syncPermissions(Permission::all());
        $user = User::where('email','superAdmin@panarab-media.com')->first();
        $user->assignRole('Super Admin');

    }
}
