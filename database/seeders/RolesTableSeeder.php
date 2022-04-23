<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'super_admin',
                'display_name' => 'Super Admin',
                'description' => NULL,
                'created_at' => '2020-11-01 01:31:41',
                'updated_at' => '2020-11-01 01:31:41',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'admin',
                'display_name' => 'Admin',
                'description' => NULL,
                'created_at' => '2020-11-01 01:31:53',
                'updated_at' => '2020-11-01 01:31:53',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'manager',
                'display_name' => 'Manager',
                'description' => NULL,
                'created_at' => '2020-12-14 15:44:22',
                'updated_at' => '2021-01-23 23:24:49',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'product_manager',
                'display_name' => 'Product Manager',
                'description' => NULL,
                'created_at' => '2020-12-21 20:26:31',
                'updated_at' => '2021-06-03 15:39:54',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'accounts_manager',
                'display_name' => 'Accounts Manager',
                'description' => NULL,
                'created_at' => '2021-01-23 23:26:09',
                'updated_at' => '2021-06-03 15:41:10',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'customer_support_manager',
                'display_name' => 'Customer Support Manager',
                'description' => NULL,
                'created_at' => '2021-01-23 23:29:45',
                'updated_at' => '2021-01-23 23:29:45',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'reporting_manager',
                'display_name' => 'Reporting Manager',
                'description' => NULL,
                'created_at' => '2021-01-23 23:31:05',
                'updated_at' => '2021-01-23 23:31:05',
            ),
        ));
        
        
    }
}