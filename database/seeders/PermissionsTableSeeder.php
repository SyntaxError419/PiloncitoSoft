<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Lista de roles
        $role1= Role::create(['name' => 'admin']);
        $role2= Role::create(['name' => 'profesional']);
        $role3= Role::create(['name' => 'cliente']);

        //Lista de permisos
        Permission::create(['name' => 'ServiciosProductos_index']);
        Permission::create(['name' => 'ServiciosProductos_create']);
        Permission::create(['name' => 'ServiciosProductos_edit']);
        Permission::create(['name' => 'ServiciosProductos_destroy']);



        $role1->givePermissionTo([
            'ServiciosProductos_index',
            'ServiciosProductos_create',
            'ServiciosProductos_edit',
            'ServiciosProductos_destroy'
        ]);

    }
}
