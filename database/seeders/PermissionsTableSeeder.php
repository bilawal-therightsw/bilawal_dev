<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
           
            //staff
            ['group' => 'staff', 'name' => 'view_staff', 'title' => 'View Staff', 'guard_name' => 'web'],
            ['group' => 'staff', 'name' => 'approve_staff', 'title' => 'Approve Staff', 'guard_name' => 'web'],
            ['group' => 'staff', 'name' => 'disapprove_staff', 'title' => 'Disapprove Staff', 'guard_name' => 'web'],
            //users
            ['group' => 'user', 'name' => 'view_user', 'title' => 'View User', 'guard_name' => 'web'],
            ['group' => 'user', 'name' => 'approve_user', 'title' => 'Approve User', 'guard_name' => 'web'],
            ['group' => 'user', 'name' => 'disapprove_user', 'title' => 'Disapprove User', 'guard_name' => 'web'],
            //products
            ['group' => 'products', 'name' => 'view_products', 'title' => 'View products', 'guard_name' => 'web'],
            ['group' => 'products', 'name' => 'add_products', 'title' => 'Add products', 'guard_name' => 'web'],
            ['group' => 'products', 'name' => 'edit_products', 'title' => 'Edit products', 'guard_name' => 'web'],
            ['group' => 'products', 'name' => 'delete_products', 'title' => 'Delete products', 'guard_name' => 'web']
        ];
        Permission::insert($permissions);
    }
}
