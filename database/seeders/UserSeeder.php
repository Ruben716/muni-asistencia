<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     *@return void  
     */

     public function run()
     {
        User::create([
        'name'=> 'muniAdmin',
        'email' => 'muniadmin@gmail.com',
        'password' => bcrypt('muni123'),
        ])->assignRole('admin');
     }

}