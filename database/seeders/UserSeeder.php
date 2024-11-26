<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'admin',
                'email' => 'admin@example.com',
                'role' => 'admin',
            ],
            [
                'name' => 'technician',
                'email' => 'technician@example.com',
                'role' => 'technician',
            ],
            [
                'name' => 'user',
                'email' => 'user@example.com',
                'role' => 'user',
            ],
            [
                'name' => 'visitor',
                'email' => 'visitor@example.com',
                'role' => 'visitor',
            ],
        ];

        // Use the following instead for mysql
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        //
        // for SQL: as in https://github.com/laravel/framework/issues/35401
        // DB::table('users')->delete();
        //
        // Use the following instead for sqlite
        // DB::statement('PRAGMA foreign_keys = OFF;');
        DB::table('users')->truncate();

        // User::factory()->create($users);
        foreach ($users as $user) {
            User::factory()->create($user);
        }

        // Use the following instead for mysql
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        //
        // Use the following instead for sqlite
        // DB::statement('PRAGMA foreign_keys = ON;');

        // User::factory()->count(5)->create();
    }
}