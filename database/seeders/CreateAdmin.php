<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name' => 'nelayanJkt',
            'email' => 'nelayanjkt@anaklaut.id',
            'password' => Hash::make('admin123')
        ]);
    }
}
