<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\carbon;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        DB::table('table_kelas')->insert([
            'nama_kelas' => 'VII A',
            'tingkatan' => 'SMP',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('table_kelas')->insert([
            'nama_kelas' => 'VII B',
            'tingkatan' => 'SMP',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('table_kelas')->insert([
            'nama_kelas' => 'VII C',
            'tingkatan' => 'SMP',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('table_kelas')->insert([
            'nama_kelas' => 'VII D',
            'tingkatan' => 'SMP',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('table_kelas')->insert([
            'nama_kelas' => 'VII E',
            'tingkatan' => 'SMP',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
