<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\carbon;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        DB::table('users')->insert([
            'name' => 'Admin Perpus',
            'email' => 'adminperpus@admin.com',
            'password' => bcrypt('Perpus.123'),
            'is_adminperpus' => true,
            'remember_token' => Str::random(60),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('users')->insert([
            'name' => 'Admin Loker',
            'email' => 'adminloker@admin.com',
            'password' => bcrypt('Loker.123'),
            'is_adminloker' => true,
            'remember_token' => Str::random(60),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('users')->insert([
            'name' => 'SuperAdmin',
            'email' => 'superadmin@admin.com',
            'password' => bcrypt('Bismillah12345!'),
            'is_superadmin' => true,
            'remember_token' => Str::random(60),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
