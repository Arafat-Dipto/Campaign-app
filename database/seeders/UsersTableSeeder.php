<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Nagib Mahfuj',
                'email' => 'nagib@mavengers.com.bd',
                'email_verified_at' => NULL,
                'password' => '$2y$10$79MmWNB7MUsQks13HSvTo.0Rwof.EmOdNU9oZQlUJBKBGNvxm1VtO',
                'remember_token' => '7LLixQnBlq7SRe2QYqzMh9Ij9kAgYp6CKQFKvffVsOr5KJ4mxyAjoKSOAfsb',
                'created_at' => '2021-06-03 14:47:31',
                'updated_at' => '2021-06-03 15:43:09',
            ),
        ));
        
        
    }
}