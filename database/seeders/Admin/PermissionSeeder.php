<?php

namespace Database\Seeders\Admin;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            array('id' => '1', 'name' => 'KYC Management', 'guard_name' => 'admin', 'group_name' => 'KYC Management'),
            array('id' => '2', 'name' => 'Role Management', 'guard_name' => 'admin', 'group_name' => 'Access Management'),
            array('id' => '3', 'name' => 'Role User Management', 'guard_name' => 'admin', 'group_name' => 'Access Management'),
            array('id' => '5', 'name' => 'Category Management', 'guard_name' => 'admin', 'group_name' => 'Product Categoires'),
            array('id' => '6', 'name' => 'Tags Management', 'guard_name' => 'admin', 'group_name' => 'Product Tags'),
            array('id' => '7', 'name' => 'Brand Management', 'guard_name' => 'admin', 'group_name' => 'Product Brands'),
            array('id' => '8', 'name' => 'Product Management', 'guard_name' => 'admin', 'group_name' => 'Products', )
        ];

        DB::table('permissions')->insert($permissions);
    }
}
