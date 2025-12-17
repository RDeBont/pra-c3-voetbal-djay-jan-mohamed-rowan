<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'password' => Hash::make('admin1'),
            'is_admin' => true,
            'email' => 'admin@example.com',

        ]);

        DB::table('users')->insert([
            'name' => 'school',
            'password' => Hash::make('school1'),
            'is_admin' => false,
            'email' => 'school@example.com',

        ]);
    }
}
