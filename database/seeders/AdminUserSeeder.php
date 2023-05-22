<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'bayuxbca@gmail.com',
            'email_verified_at' => date('Y-m-d H:i:s', time()),
            'password' => bcrypt('bayu28022000'),
            'is_admin' => true
        ]);
    }
}
