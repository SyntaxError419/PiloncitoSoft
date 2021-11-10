<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
           $user= User::Create([
            'name'=>'Santiago Echeverri',
            'email'=>'santiago_0323@hotmail.com',
            'password'=> bcrypt('123456789'),
            'id_rol' => '1'
           ]);

           $user=User::find(1);




    }
}
