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
    public function run(): void
    {
        $usr = User::create([
            'name' => 'Administrator',
            'cid' => '11000000011',
            'organization' => 'Bhutan Telecom Limited',
            'email' => 'admin@bt.bt',
            'contact' => '17123410',
            'password' => Hash::make('12345678'),
            'verified' => 1,
            'user_ref_id' => 0,
            'file_name' => null,
            'file_path' => null
        ]);
        $usr->attachRole('admin');
    }
}
