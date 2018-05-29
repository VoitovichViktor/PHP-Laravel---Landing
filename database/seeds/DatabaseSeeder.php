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
        $this->call([
            PagesTableSeeder::class,
            ServicesTableSeeder::class,
            PeoplesTableSeeder::class,
            PortfoliosTableSeeder::class,
        ]);
    }
}
