<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;

use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    public function run()
    {
         // Crear roles
         $role1 = Role::create(['name' => 'admin']);
         $role2 = Role::create(['name' => 'user']);
 
         // Crear permisos
         Permission::create(['name' => 'home']);
         Permission::create(['name' => 'dashboard']);
         Permission::create(['name' => 'settings.profile']);
         Permission::create(['name' => 'settings.password']);
         Permission::create(['name' => 'settings.appearance']);
         Permission::create(['name' => 'interns.index']);
         Permission::create(['name' => 'interns.show']);
         Permission::create(['name' => 'export.global']);
         Permission::create(['name' => 'export.individual']);
         Permission::create(['name' => 'attendances.index']);
         Permission::create(['name' => 'attendance.export']);
         Permission::create(['name' => 'historial-asistencias.index']);
 
         // Asignar permisos a roles
         // El rol admin tendrá todos los permisos
         $role1->givePermissionTo(Permission::all());
        $role2->givePermissionTo([
            'home', 
            'dashboard', 
            'attendances.index', 
            'attendance.export', 
            
        ]);
        
    }
}

