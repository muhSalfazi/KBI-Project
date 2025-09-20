<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;    
use Illuminate\Support\Facades\Hash;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //
        user::create([
            'first_name' => 'Admin',
            'last_name' => 'Delivery',
            'username' => 'adminKBI',
            'id_card_number' => '9021ss',
            'password' => Hash::make('admin'),
            'role' => 'admin',
        ]);
        user::create([
            'first_name' => 'Admin',
            'last_name' => 'Delivery',
            'username' => 'salfazi',
            'id_card_number' => '9051s',
            'password' => Hash::make('salman123'),
            'role' => 'viewer',
        ]);
        user::create([
            'first_name' => 'super',
            'last_name' => 'admin',
            'username' => 'superAdmin',
            'id_card_number' => '9024s',
            'password' => Hash::make('admin123'),
            'role' => 'superAdmin',
        ]);

    }
}