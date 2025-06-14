<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TramitesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        

        // ENTE: REGISTRO
        // DB::table('tramites')->insert([
        //     'tramite' => 'Protocolización',
        //     'key_ente' => 1,
        //     'alicuota' => 7,
        //     'natural' => '3',
        //     'juridico' => '10',
        //     'small' => null,
        //     'medium' => null,
        //     'large' => null,
        //     'porcentaje' => null,
        // ]);
        // DB::table('tramites')->insert([
        //     'tramite' => 'Folio',
        //     'key_ente' => 1,
        //     'alicuota' => 7,
        //     'natural' => '1',
        //     'juridico' => '1',
        //     'small' => null,
        //     'medium' => null,
        //     'large' => null,
        //     'porcentaje' => null,
        // ]);


        // DB::table('tramites')->insert([
        //     'tramite' => 'Título de Bachiller',
        //     'key_ente' => 1,
        //     'alicuota' => 7,
        //     'natural' => '1',
        //     'juridico' => '1',
        //     'small' => null,
        //     'medium' => null,
        //     'large' => null,
        //     'porcentaje' => null,
        // ]);
        // DB::table('tramites')->insert([
        //     'tramite' => 'Título Universitario',
        //     'key_ente' => 1,
        //     'alicuota' => 7,
        //     'natural' => '2',
        //     'juridico' => '2',
        //     'small' => null,
        //     'medium' => null,
        //     'large' => null,
        //     'porcentaje' => null,
        // ]);
        // DB::table('tramites')->insert([
        //     'tramite' => 'Otro documento | Elaborados o expedidos en Educacion',
        //     'key_ente' => 1,
        //     'alicuota' => 7,
        //     'natural' => '3',
        //     'juridico' => '3',
        //     'small' => null,
        //     'medium' => null,
        //     'large' => null,
        //     'porcentaje' => null,
        // ]);


        // DB::table('tramites')->insert([
        //     'tramite' => 'Inscripción o aumento de Capital. | Sociedades mercantiles y Firmas personales',
        //     'key_ente' => 1,
        //     'alicuota' => 8,
        //     'natural' => null,
        //     'juridico' => null,
        //     'small' => null,
        //     'medium' => null,
        //     'large' => null,
        //     'porcentaje' => '2.5',
        // ]);
        // DB::table('tramites')->insert([
        //     'tramite' => 'Compra, venta, cesión, etc. | Fondo de comercio y Firmas personales.',
        //     'key_ente' => 1,
        //     'alicuota' => 8,
        //     'natural' => null,
        //     'juridico' => null,
        //     'small' => null,
        //     'medium' => null,
        //     'large' => null,
        //     'porcentaje' => '2.5',
        // ]);
        // DB::table('tramites')->insert([
        //     'tramite' => 'Compra, venta, cesión, etc. | Inmuebles de tipo comercial.',
        //     'key_ente' => 1,
        //     'alicuota' => 8,
        //     'natural' => null,
        //     'juridico' => null,
        //     'small' => null,
        //     'medium' => null,
        //     'large' => null,
        //     'porcentaje' => '2.5',
        // ]);
        // DB::table('tramites')->insert([
        //     'tramite' => 'Compra, venta, cesión, etc. | Inmuebles de tipo industrial.',
        //    'key_ente' => 1,
        //     'alicuota' => 8,
        //     'natural' => null,
        //     'juridico' => null,
        //     'small' => null,
        //     'medium' => null,
        //     'large' => null,
        //     'porcentaje' => '3',
        // ]);
        // DB::table('tramites')->insert([
        //     'tramite' => 'Compra, venta, cesión, etc. | Persona natural.',
        //     'key_ente' => 1,
        //     'alicuota' => 7,
        //     'natural' => '5',
        //     'juridico' => null,
        //     'small' => null,
        //     'medium' => null,
        //     'large' => null,
        //     'porcentaje' => null,
        // ]);
        
        // DB::table('tramites')->insert([
        //     'tramite' => 'Sellado de Libros o Actas.',
        //     'key_ente' => 1,
        //     'alicuota' => 7,
        //     'natural' => '3',
        //     'juridico' => '10',
        //     'small' => null,
        //     'medium' => null,
        //     'large' => null,
        //     'porcentaje' => null,
        // ]);
        
        // DB::table('tramites')->insert([
        //     'tramite' => 'Docuemntos de cualquier naturaleza que requiera de apostilla ante un órgano competente.',
        //     'key_ente' => 1,
        //     'alicuota' => 7,
        //     'natural' => '3',
        //     'juridico' => '3',
        //     'small' => null,
        //     'medium' => null,
        //     'large' => null,
        //     'porcentaje' => null,
        // ]);

 

        // // ENTE: MUNICIPAL O ALCALDÍA
        // DB::table('tramites')->insert([
        //     'tramite' => 'Municipal o Alcaldías',
        //     'key_ente' => 2,
        //     'alicuota' => 7,
        //     'natural' => '3',
        //     'juridico' => '10',
        //     'small' => null,
        //     'medium' => null,
        //     'large' => null,
        //     'porcentaje' => null,
        // ]);




        // // ENTE: NOTARÍA
        // DB::table('tramites')->insert([
        //     'tramite' => 'Venta de vehículo',
        //     'key_ente' => 3,
        //     'alicuota' => 8,
        //     'natural' => null,
        //     'juridico' => null,
        //     'small' => null,
        //     'medium' => null,
        //     'large' => null,
        //     'porcentaje' => '2.5',
        // ]);
        // DB::table('tramites')->insert([
        //     'tramite' => 'Venta de maquinaria agrícola, de contrucción o industrial.',
        //     'key_ente' => 3,
        //     'alicuota' => 8,
        //     'natural' => null,
        //     'juridico' => null,
        //     'small' => null,
        //     'medium' => null,
        //     'large' => null,
        //     'porcentaje' => '2.5',
        // ]);
        // DB::table('tramites')->insert([
        //     'tramite' => 'Otorgamiento de autorizaciones',
        //     'key_ente' => 3,
        //     'alicuota' => 7,
        //     'natural' => '3',
        //     'juridico' => '10',
        //     'small' => null,
        //     'medium' => null,
        //     'large' => null,
        //     'porcentaje' => null,
        // ]);
        // DB::table('tramites')->insert([
        //     'tramite' => 'Apertura de Testamento',
        //     'key_ente' => 3,
        //     'alicuota' => 7,
        //     'natural' => '5',
        //     'juridico' => '5',
        //     'small' => null,
        //     'medium' => null,
        //     'large' => null,
        //     'porcentaje' => null,
        // ]);
        // DB::table('tramites')->insert([
        //     'tramite' => 'Otorgamiento de Declaraciones juradas',
        //     'key_ente' => 3,
        //     'alicuota' => 7,
        //     'natural' => '5',
        //     'juridico' => '5',
        //     'small' => null,
        //     'medium' => null,
        //     'large' => null,
        //     'porcentaje' => null,
        // ]);
        // DB::table('tramites')->insert([
        //     'tramite' => 'Copias certificadas de documentos Autenticados',
        //     'key_ente' => 3,
        //     'alicuota' => 7,
        //     'natural' => '10',
        //     'juridico' => '10',
        //     'small' => null,
        //     'medium' => null,
        //     'large' => null,
        //     'porcentaje' => null,
        // ]);
        // DB::table('tramites')->insert([
        //     'tramite' => 'Copias o reproducciones simples de los documentos autenticados',
        //     'key_ente' => 3,
        //     'alicuota' => 7,
        //     'natural' => '4',
        //     'juridico' => '8',
        //     'small' => null,
        //     'medium' => null,
        //     'large' => null,
        //     'porcentaje' => null,
        // ]);
        // DB::table('tramites')->insert([
        //     'tramite' => 'Otorgamiento de Poderes',
        //     'key_ente' => 3,
        //     'alicuota' => 7,
        //     'natural' => '5',
        //     'juridico' => '10',
        //     'small' => null,
        //     'medium' => null,
        //     'large' => null,
        //     'porcentaje' => null,
        // ]);
        // DB::table('tramites')->insert([
        //     'tramite' => 'Notificaciones, insspeciones oculares, etc. | Fuera de la sede de Notaría',
        //     'key_ente' => 3,
        //     'alicuota' => 7,
        //     'natural' => '5',
        //     'juridico' => '10',
        //     'small' => null,
        //     'medium' => null,
        //     'large' => null,
        //     'porcentaje' => null,
        // ]);
        // DB::table('tramites')->insert([
        //     'tramite' => 'Inscripción o Autenticación de documentos, actuaciones, solicitudes o tramites no detallado anteriormente.',
        //     'key_ente' => 3,
        //     'alicuota' => 7,
        //     'natural' => '5',
        //     'juridico' => '10',
        //     'small' => null,
        //     'medium' => null,
        //     'large' => null,
        //     'porcentaje' => null,
        // ]);




        // // ENTE:BOMBEROS
        // DB::table('tramites')->insert([
        //     'tramite' => 'Bomberos',
        //     'key_ente' => 4,
        //     'alicuota' => 13,
        //     'natural' => null,
        //     'juridico' => null,
        //     'small' => '100',
        //     'medium' => '250',
        //     'large' => '500',
        //     'porcentaje' => null,
        // ]);
        // DB::table('tramites')->insert([
        //     'tramite' => 'Prestación del Servicio de guardias de prevención.',
        //     'key_ente' => 4,
        //     'alicuota' => 7,
        //     'natural' => '5',
        //     'juridico' => '10',
        //     'small' => null,
        //     'medium' => null,
        //     'large' => null,
        //     'porcentaje' => null,
        // ]);
        // DB::table('tramites')->insert([
        //     'tramite' => 'Servicios particulares que beneficien a personas jurídicas | Consultoría, Capacitación, Entrenamiento.',
        //     'key_ente' => 4,
        //     'alicuota' => 7,
        //     'natural' => '5',
        //     'juridico' => '10',
        //     'small' => null,
        //     'medium' => null,
        //     'large' => null,
        //     'porcentaje' => null,
        // ]);
        // DB::table('tramites')->insert([
        //     'tramite' => 'Aprobación/Autorización de quema de basura, y encendido de hogueras en trerrenos públicos o privados.',
        //     'key_ente' => 4,
        //     'alicuota' => 7,
        //     'natural' => '5',
        //     'juridico' => '10',
        //     'small' => null,
        //     'medium' => null,
        //     'large' => null,
        //     'porcentaje' => null,
        // ]);


        // // PREFECTURAS
        // DB::table('tramites')->insert([
        //     'tramite' => 'Trámites por Prefectura',
        //     'key_ente' => 5,
        //     'alicuota' => 7,
        //     'natural' => '1',
        //     'juridico' => '1',
        //     'small' => null, 
        //     'medium' => null,
        //     'large' => null,
        //     'porcentaje' => null,
        // ]);

        
        // // CORPOSALUD
        // DB::table('tramites')->insert([
        //     'tramite' => 'Permiso Sanitario',
        //     'key_ente' => 6,
        //     'alicuota' => 13,
        //     'natural' => null,
        //     'juridico' => null,
        //     'small' => '100', 
        //     'medium' => '250',
        //     'large' => '500',
        //     'porcentaje' => null,
        // ]);
        // DB::table('tramites')->insert([
        //     'tramite' => 'Solicitudes de Evaluación, Estudio o Inspección. | Farmacéutica, Cosméticos, Naturales y afines.',
        //     'key_ente' => 6,
        //     'alicuota' => 7,
        //     'natural' => '3',
        //     'juridico' => '10',
        //     'small' => null, 
        //     'medium' => null,
        //     'large' => null,
        //     'porcentaje' => null,
        // ]);
        // DB::table('tramites')->insert([
        //     'tramite' => 'Solicitud para certificación de libre venta y consumo, o calidad de alimentos. | Productos alimenticios.',
        //     'key_ente' => 6,
        //     'alicuota' => 7,
        //     'natural' => '3',
        //     'juridico' => '10',
        //     'small' => null, 
        //     'medium' => null,
        //     'large' => null,
        //     'porcentaje' => null,
        // ]);
        // DB::table('tramites')->insert([
        //     'tramite' => 'Solicitud de Permiso sanitario para la higiene de los alimientos, o el funcionamiento de expendido y almacenamiento de los mismos.',
        //     'key_ente' => 6,
        //     'alicuota' => 7,
        //     'natural' => '5',
        //     'juridico' => '15',
        //     'small' => null, 
        //     'medium' => null,
        //     'large' => null,
        //     'porcentaje' => null,
        // ]);
        // DB::table('tramites')->insert([
        //     'tramite' => 'Solicitud de Permiso para el funcionamiento de expendios ambulantes y transporte de alimientos.',
        //     'key_ente' => 6,
        //     'alicuota' => 7,
        //     'natural' => '3',
        //     'juridico' => '10',
        //     'small' => null, 
        //     'medium' => null,
        //     'large' => null,
        //     'porcentaje' => null,
        // ]);
        // DB::table('tramites')->insert([
        //     'tramite' => 'Otro acto y/o documento expedido.',
        //     'key_ente' => 6,
        //     'alicuota' => 7,
        //     'natural' => '3',
        //     'juridico' => '10',
        //     'small' => null, 
        //     'medium' => null,
        //     'large' => null,
        //     'porcentaje' => null,
        // ]);



        // // SENIAT
        // DB::table('tramites')->insert([
        //     'tramite' => 'Solicitud | Autorización de industrias productoras de alcoholy especies alcohólicas o ampliación de las ya instaladas.',
        //     'key_ente' => 7,
        //     'alicuota' => 7,
        //     'natural' => '500',
        //     'juridico' => '500',
        //     'small' => null, 
        //     'medium' => null,
        //     'large' => null,
        //     'porcentaje' => null,
        // ]);
        // DB::table('tramites')->insert([
        //     'tramite' => 'Solicitud | Autorización para la instalación de expendio de bebidas alcohólica, transformación, traspasos y traslados de los mismos.',
        //     'key_ente' => 7,
        //     'alicuota' => 7,
        //     'natural' => '300',
        //     'juridico' => '300',
        //     'small' => null, 
        //     'medium' => null,
        //     'large' => null,
        //     'porcentaje' => null,
        // ]);
        // DB::table('tramites')->insert([
        //     'tramite' => 'Solicitud | Autorización eventual para expendio de bebidas alcohólica.',
        //     'key_ente' => 7,
        //     'alicuota' => 7,
        //     'natural' => '50',
        //     'juridico' => '50',
        //     'small' => null, 
        //     'medium' => null,
        //     'large' => null,
        //     'porcentaje' => null,
        // ]);
        // DB::table('tramites')->insert([
        //     'tramite' => 'Otro acto y/o documento expedido.',
        //     'key_ente' => 7,
        //     'alicuota' => 7,
        //     'natural' => '10',
        //     'juridico' => '15',
        //     'small' => null, 
        //     'medium' => null,
        //     'large' => null,
        //     'porcentaje' => null,
        // ]);




        // DB::table('tramites')->insert([
        //     'tramite' => 'Para Constitución de una Empresa | Persona Natural',
        //     'key_ente' => 1,
        //     'alicuota' => 7,
        //     'natural' => '10',
        //     'juridico' => '10',
        //     'small' => null,
        //     'medium' => null,
        //     'large' => null,
        //     'porcentaje' => null,
        // ]);
        // DB::table('tramites')->insert([
        //     'tramite' => 'Para Constitución de una Empresa | Jurídico',
        //     'key_ente' => 1,
        //     'alicuota' => 7,
        //     'natural' => '15',
        //     'juridico' => '15',
        //     'small' => null,
        //     'medium' => null,
        //     'large' => null,
        //     'porcentaje' => null,
        // ]);
        // DB::table('tramites')->insert([
        //     'tramite' => 'Registro | Persona Natural',
        //     'key_ente' => 1,
        //     'alicuota' => 7,
        //     'natural' => '5',
        //     'juridico' => '5',
        //     'small' => null,
        //     'medium' => null,
        //     'large' => null,
        //     'porcentaje' => null,
        // ]);
        // DB::table('tramites')->insert([
        //     'tramite' => 'Registro | Jurídico',
        //     'key_ente' => 1,
        //     'alicuota' => 7,
        //     'natural' => '10',
        //     'juridico' => '10',
        //     'small' => null,
        //     'medium' => null,
        //     'large' => null,
        //     'porcentaje' => null,
        // ]);









        //NUEVOS
        ///CORPOSALUD
         DB::table('tramites')->insert([
            'tramite' => 'Permiso Sanitario',
            'key_ente' => 6,
            'alicuota' => 7,
            'natural' => '15',
            'juridico' => '15',
            'small' => null, 
            'medium' => null,
            'large' => null,
            'porcentaje' => null,
        ]);


        ///SENIAT
        DB::table('tramites')->insert([
            'tramite' => 'Declaración de Vivienda Principal.',
            'key_ente' => 7,
            'alicuota' => 7,
            'natural' => '5',
            'juridico' => '5',
            'small' => null, 
            'medium' => null,
            'large' => null,
            'porcentaje' => null,
        ]);
        DB::table('tramites')->insert([
            'tramite' => 'Solicitudes.',
            'key_ente' => 7,
            'alicuota' => 7,
            'natural' => '10',
            'juridico' => '10',
            'small' => null, 
            'medium' => null,
            'large' => null,
            'porcentaje' => null,
        ]);

        DB::table('tramites')->insert([
            'tramite' => 'Declaración sucesoral.',
            'key_ente' => 7,
            'alicuota' => 7,
            'natural' => '5',
            'juridico' => '5',
            'small' => null, 
            'medium' => null,
            'large' => null,
            'porcentaje' => null,
        ]);
        DB::table('tramites')->insert([
            'tramite' => 'Sucesión.',
            'key_ente' => 7,
            'alicuota' => 7,
            'natural' => '10',
            'juridico' => '10',
            'small' => null, 
            'medium' => null,
            'large' => null,
            'porcentaje' => null,
        ]);

        // ENTE:BOMBEROS
        DB::table('tramites')->insert([
            'tramite' => 'Permisos de Bomberos para vehículos.',
            'key_ente' => 4,
            'alicuota' => 7,
            'natural' => '10',
            'juridico' => '10',
            'small' => null,
            'medium' => null,
            'large' => null,
            'porcentaje' => null,
        ]);
        DB::table('tramites')->insert([
            'tramite' => 'Ficha catastral.',
            'key_ente' => 3,
            'alicuota' => 7,
            'natural' => '3',
            'juridico' => '10',
            'small' => null,
            'medium' => null,
            'large' => null,
            'porcentaje' => null,
        ]);

    }
}
