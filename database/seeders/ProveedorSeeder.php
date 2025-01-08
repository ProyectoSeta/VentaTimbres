<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProveedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('proveedores')->insert([
            'condicion_identidad' => 'G',
            'nro_identidad' => '00000001',
            'razon_social' => 'CASA DE LA MONEDA, S.A.',
            'direccion' => 'DIRECCIÓN',
            'nombre_representante' => 'REPRESENTANTE',
            'email' => 'casamoneda@gmail.com',
            'tlf_movil' => '0414000001',
            'tlf_fijo' => null,
        ]);
    }
}
