<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(LocDivisionsTableSeeder::class);
        $this->call(LocDistrictsTableSeeder::class);
        $this->call(LocUpazilasTableSeeder::class);
        $this->call(LocMunicipalitiesTableSeeder::class);
        $this->call(LocUnionsTableSeeder::class);
    }
}
