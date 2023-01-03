<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LaptopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Laptop::factory()->count(100)->create(); 
    }
}
