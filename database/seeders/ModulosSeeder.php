<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModulosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('modulos')->insert([
            'modulo' => 'Consulta',  
        ]);
        DB::table('modulos')->insert([
            'modulo' => 'Cierre',  
        ]);
        DB::table('modulos')->insert([
            'modulo' => 'Papel de Seguridad',  
        ]);
        DB::table('modulos')->insert([
            'modulo' => 'Estampillas',  
        ]);
        DB::table('modulos')->insert([
            'modulo' => 'Asignaciones',  
        ]);
        DB::table('modulos')->insert([
            'modulo' => 'Taquillas',  
        ]);
        DB::table('modulos')->insert([
            'modulo' => 'Sedes | Taquillas',  
        ]);
        DB::table('modulos')->insert([
            'modulo' => 'Configuraciones',  
        ]);
        DB::table('modulos')->insert([
            'modulo' => 'Mi Cuenta',  
        ]);
        DB::table('modulos')->insert([
            'modulo' => 'Ventas',  
        ]);
    }
}
