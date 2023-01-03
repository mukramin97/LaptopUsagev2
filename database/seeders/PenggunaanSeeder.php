<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Faker\Factory as Faker;
use Carbon\carbon;

class PenggunaanSeeder extends Seeder
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

            $startDate = '2022-12-01 00:00:00'; // tanggal awal adalah 1 Januari 2022
            $endDate = '2022-12-31 23:59:59'; // tanggal akhir adalah 31 Desember 2022

            $pinjam = $faker->dateTimeBetween($startDate, $endDate);
            $kembali = $faker->dateTimeBetween($pinjam, $endDate);

    		DB::table('table_penggunaan')->insert([
    			'siswa_id' => $faker->numberBetween(1,100),
    			'tanggal_pinjam' => $pinjam->format('Y-m-d H:i:s'),
    			'tanggal_kembali' => $kembali->format('Y-m-d H:i:s'),
				'created_at' => $pinjam->format('Y-m-d H:i:s'),
           		'updated_at' => $now,
    		]);
    	}    
    }
}
