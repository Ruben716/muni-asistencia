<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;


class RolesSeeder extends Seeder
{
    public function run()
    {
        // Crear los roles 'admin' y 'user'
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);
    }
}

