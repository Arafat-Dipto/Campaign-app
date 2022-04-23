<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CampaignsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('campaigns')->delete();
        
        \DB::table('campaigns')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'April Campaign',
                'images' => NULL,
                'total_budget' => 100,
                'daily_budget' => 10,
                'start_date' => '2022-04-02 14:47:31',
                'end_date' => '2022-04-22 14:47:31',
                'created_at' => '2022-03-03 14:47:31',
                'updated_at' => '2022-03-03 15:43:09',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'May Campaign',
                'images' => NULL,
                'total_budget' => 250,
                'daily_budget' => 15,
                'start_date' => '2022-04-12 14:47:31',
                'end_date' => '2022-04-23 14:47:31',
                'created_at' => '2022-03-03 14:47:31',
                'updated_at' => '2022-03-03 15:43:09',
            ),
        ));
        
        
    }
}