<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = [
            [
                'name' => 'はなこ',
                'email' => 'user1@test.com',
                'password' => Hash::make('1234'),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('users')->insert($data);
    
    }
}
