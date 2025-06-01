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






        $pass_taq = 'Taq11237.';
        //USUARIOS TAQUILLEROS
        ///TAQ1
        $taq_1 = User::query()->create([
            'email' => 'sptaquilla@gmail.com',
            'password' => Hash::make($pass_taq),
            'type' => 2,
            'key_sujeto' => 2, 
        ]);
        $taq_1->assignRole('Taquillero');

        ///TAQ2
        $taq_2 = User::query()->create([
            'email' => 'attaquilla@gmail.com',
            'password' => Hash::make($pass_taq),
            'type' => 2,
            'key_sujeto' => 3, 
        ]);
        $taq_2->assignRole('Taquillero');

        ///TAQ3
        $taq_3 = User::query()->create([
            'email' => 'dltaquilla@gmail.com',
            'password' => Hash::make($pass_taq),
            'type' => 2,
            'key_sujeto' => 4, 
        ]);
        $taq_3->assignRole('Taquillero');

        ///TAQ4
        $taq_4 = User::query()->create([
            'email' => 'rmtaquilla@gmail.com',
            'password' => Hash::make($pass_taq),
            'type' => 2,
            'key_sujeto' => 5, 
        ]);
        $taq_4->assignRole('Taquillero');

        ///TAQ5
        $taq_5 = User::query()->create([
            'email' => 'wrtaquilla@gmail.com',
            'password' => Hash::make($pass_taq),
            'type' => 2,
            'key_sujeto' => 6, 
        ]);
        $taq_5->assignRole('Taquillero');

        ///TAQ6
        $taq_6 = User::query()->create([
            'email' => 'crtaquilla@gmail.com',
            'password' => Hash::make($pass_taq),
            'type' => 2,
            'key_sujeto' => 7, 
        ]);
        $taq_6->assignRole('Taquillero');

        ///TAQ7
        $taq_7 = User::query()->create([
            'email' => 'mgtaquilla@gmail.com',
            'password' => Hash::make($pass_taq),
            'type' => 2,
            'key_sujeto' => 8, 
        ]);
        $taq_7->assignRole('Taquillero');





        


        
       
    }
}
