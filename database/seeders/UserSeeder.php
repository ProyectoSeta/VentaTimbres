<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pass = 'Admin852.';
        $adminUser = User::query()->create([
            'email' => 'administrador@gmail.com',
            'password' => Hash::make($pass),
            'type' => 2,
            'key_sujeto' => 1, /////funcionario id 1 admin
        ]);

        // CREAR EL ROL
        $roleAdmin = Role::create(['name' => 'Admin Master']);

        // ASIGNAR EL ROL AL USUARIO
        $adminUser->assignRole($roleAdmin);

        // BUSCAR TODOS LOS PERMISOS REGISTRADOS
        $permissionsAdmin = Permission::query()->where('name','!=','venta')
                                                ->where('name','!=','home.apertura_taquilla')
                                                ->where('name','!=','home.cierre_taquilla')
                                                ->where('name','!=','home.modal_clave')
                                                ->where('name','!=','timbres_asignados')
                                                ->where('name','!=','timbre')
                                                ->pluck('name');

        // ASIGNAR LOS PERMISOS AL ROL
        $roleAdmin->syncPermissions($permissionsAdmin);













        


        
       
    }
}
