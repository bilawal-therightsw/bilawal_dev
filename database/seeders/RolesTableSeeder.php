<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_permissions = Permission::pluck('id');
        $admin = Role::create(['name' => 'admin', 'title' => 'Admin']);
        $admin->permissions()->sync($admin_permissions);

        $staff_permissions = Permission::whereIn('name', ['add_products','view_products','edit_products'])
                                ->pluck('id');
        $staff = Role::create(['name' => 'staff', 'title' => 'staff']);
        $staff->permissions()->sync($staff_permissions);

        $user_permissions = Permission::whereIn('name', ['view_products'])
                                ->pluck('id');
        $user = Role::create(['name' => 'user', 'title' => 'user']);
        $user->permissions()->sync($user_permissions);
    }
}
