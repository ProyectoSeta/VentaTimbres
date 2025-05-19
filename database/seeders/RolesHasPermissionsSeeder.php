<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesHasPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // SUPERINTENDENTE
        $roleSuperInt = Role::create(['name' => 'Superintendente']);

        // RECAUDACIÓN
        $roleRecaud = Role::create(['name' => 'Recaudación']);


        // FISCALIZACIÓN
        $roleFisca = Role::create(['name' => 'Administrador']);
    

        // TECNOLOGÍA
        $roleTecno = Role::create(['name' => 'Coordinador']);
        

        // SUPERVISOR
        $roleSupervisor = Role::create(['name' => 'Tecnología']);
        

        // SECRETARÍA
        $roleSecretaria = Role::create(['name' => 'Auditoría']);
        

        // SUJETOS PASIVOS
        $roleSujetos = Role::create(['name' => 'Taquillero']);
          
    }
}
