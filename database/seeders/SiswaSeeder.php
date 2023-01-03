<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Faker\Factory as Faker;
use Carbon\carbon;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$faker = Faker::create('id_ID');
		$now = Carbon::now();
 
    	for($i = 1; $i <= 100; $i++){
    		DB::table('table_siswa')->insert([
    			'nama' => $faker->name,
				'NISN' => $faker->randomNumber(5, true),
    			'laptop_id' => $i,
    			'kelas_id' => $faker->numberBetween(1,5),
				'created_at' => $now,
           		'updated_at' => $now,
    		]);
    	}
	

		
    }
}
