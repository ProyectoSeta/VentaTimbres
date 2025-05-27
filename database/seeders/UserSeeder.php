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










        /////////SUJETOS TAQUILLEROS PRUEBA 
        $pass1 = '123456';
        $user1 = User::query()->create([
            'email' => 'taquillero1@gmail.com',
            'password' => Hash::make($pass1),
            'type' => 2,
            'key_sujeto' => 2, //////funcionario id 2
        ]);
        $user1->assignRole('Taquillero');

        $user2 = User::query()->create([
            'email' => 'taquillero2@gmail.com',
            'password' => Hash::make($pass1),
            'type' => 2,
            'key_sujeto' => 3,/////funcionario id 3
        ]);
        $user2->assignRole('Taquillero');




        ////////////SUJETO PRUEBA CONTRIBUYENTE
        DB::table('contribuyentes')->insert([
            'condicion_sujeto' => 9,
            'identidad_condicion' => 'V',
            'identidad_nro' =>'123456',
            'nombre_razon' => 'Prueba Uno'
        ]);

        $pass2 = 'Hola45.';
        DB::table('users')->insert([
            'email' => 'prueba_uno@gmail.com',
            'password' => Hash::make($pass2),
            'type' => 1,
            'key_sujeto' => 1,
        ]);


        
       
    }
}
