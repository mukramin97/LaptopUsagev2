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
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('Admin.123'),
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
