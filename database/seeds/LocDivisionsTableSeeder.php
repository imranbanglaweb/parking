<?php

use Illuminate\Database\Seeder;

class LocDivisionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('loc_divisions')->delete();
        
        \DB::table('loc_divisions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title_en' => 'Barisal',
                'title' => 'বরিশাল',
                'bbs_code' => '10',
                'status' => 1,
                'created_by' => 0,
                'updated_by' => 0,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            1 => 
            array (
                'id' => 2,
                'title_en' => 'Chittagong',
                'title' => 'চট্টগ্রাম',
                'bbs_code' => '20',
                'status' => 1,
                'created_by' => 0,
                'updated_by' => 0,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            2 => 
            array (
                'id' => 3,
                'title_en' => 'Dhaka',
                'title' => 'ঢাকা',
                'bbs_code' => '30',
                'status' => 1,
                'created_by' => 0,
                'updated_by' => 0,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            3 => 
            array (
                'id' => 4,
                'title_en' => 'Khulna',
                'title' => 'খুলনা',
                'bbs_code' => '40',
                'status' => 1,
                'created_by' => 0,
                'updated_by' => 0,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            4 => 
            array (
                'id' => 5,
                'title_en' => 'Rajshahi',
                'title' => 'রাজশাহী',
                'bbs_code' => '50',
                'status' => 1,
                'created_by' => 0,
                'updated_by' => 0,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            5 => 
            array (
                'id' => 6,
                'title_en' => 'Rangpur',
                'title' => 'রংপুর',
                'bbs_code' => '60',
                'status' => 1,
                'created_by' => 0,
                'updated_by' => 0,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            6 => 
            array (
                'id' => 7,
                'title_en' => 'Sylhet',
                'title' => 'সিলেট',
                'bbs_code' => '70',
                'status' => 1,
                'created_by' => 0,
                'updated_by' => 0,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            7 => 
            array (
                'id' => 9,
                'title_en' => 'Mymensingh',
                'title' => 'ময়মনসিংহ',
                'bbs_code' => '45',
                'status' => 1,
                'created_by' => 0,
                'updated_by' => 0,
                'created_at' => '2015-11-17 06:01:41',
                'updated_at' => '2016-02-09 14:06:15',
            ),
        ));
        
        
    }
}