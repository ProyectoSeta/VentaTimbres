<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActividadesEconomicasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('actividades_economicas')->insert([
            'sector' => 'Primario',
            'ramo' => 'Pesca, Agricultura, Avicultura, Ganadería, Silvicultura',
            'cod' => '1.01',
            'descripcion' => 'Pesca.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Primario',
            'ramo' => 'Pesca, Agricultura, Avicultura, Ganadería, Silvicultura',
            'cod' => '1.02',
            'descripcion' => 'Agricultura.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Primario',
            'ramo' => 'Pesca, Agricultura, Avicultura, Ganadería, Silvicultura',
            'cod' => '1.03',
            'descripcion' => 'Avicultura.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Primario',
            'ramo' => 'Pesca, Agricultura, Avicultura, Ganadería, Silvicultura',
            'cod' => '1.04',
            'descripcion' => 'Ganadería.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Primario',
            'ramo' => 'Pesca, Agricultura, Avicultura, Ganadería, Silvicultura',
            'cod' => '1.05',
            'descripcion' => 'Silvicultura.',
        ]);


        // SECUNDARIO

        DB::table('actividades_economicas')->insert([
            'sector' => 'Secundario',
            'ramo' => 'Explotación de minas y canteras',
            'cod' => '2.01',
            'descripcion' => 'Extracción de minerales, piedras, arcilla, arena y cualquier otra actividad no especificada en la explotación de minas y canteras.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Secundario',
            'ramo' => 'Manufactura',
            'cod' => '2.02',
            'descripcion' => 'Mataderos y frigoríficos, establecimientos dedicados a la matanza de ganado. Preparación y elaboración de carne, productos a base de carne, aves y otros animales.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Secundario',
            'ramo' => 'Manufactura',
            'cod' => '2.02',
            'descripcion' => 'Fabricación de mantequilla, quesos, helados, productos lácteos y derivados y otros productos lácteos no bien especificados.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Secundario',
            'ramo' => 'Manufactura',
            'cod' => '2.02',
            'descripcion' => 'Envasado y preparación de salsas, encurtidos, condimentos, especies, sopas de hortalizas, legumbres, vegetales, mermeladas, jaleas, preparación de frutas Secas o en almíbar, jugos, concentrados de frutas, legumbres y hortalizas.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Secundario',
            'ramo' => 'Manufactura',
            'cod' => '2.02',
            'descripcion' => 'Preparación y envasado de pescado, crustáceos y otros productos marinos.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Secundario',
            'ramo' => 'Manufactura',
            'cod' => '2.02',
            'descripcion' => 'Fabricación de aceites y grasas comestibles de origen vegetal, trillado de trigo, molienda de trigo y maíz y preparación de cereales, leguminosas para el consumo humano.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Secundario',
            'ramo' => 'Manufactura',
            'cod' => '2.02',
            'descripcion' => 'Fabricación de productos de panaderías, galletas, pastelería y repostería, pastas y productos alimenticios diversos.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Secundario',
            'ramo' => 'Manufactura',
            'cod' => '2.02',
            'descripcion' => 'Fabricación de hielo.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Secundario',
            'ramo' => 'Manufactura',
            'cod' => '2.02',
            'descripcion' => 'Elaboración de bebidas no alcohólicas gaseosas o saborizadas, tratamiento y embotellado de aguas naturales y minerales.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Secundario',
            'ramo' => 'Manufactura',
            'cod' => '2.02',
            'descripcion' => 'Elaboración de alimentos preparados para animales.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Secundario',
            'ramo' => 'Manufactura',
            'cod' => '2.02',
            'descripcion' => 'Fabricación de Tapices, alfombras, productos sintéticos.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Secundario',
            'ramo' => 'Manufactura',
            'cod' => '2.02',
            'descripcion' => 'Prendas de vestir para caballeros, damas, niños y niñas, otros accesorios para vestir.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Secundario',
            'ramo' => 'Manufactura',
            'cod' => '2.02',
            'descripcion' => 'Carteras, artículos de viajes, billeteras, monederos, sombreros, partes y accesorios de cuero para calzado, calzado de cuero.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Secundario',
            'ramo' => 'Manufactura',
            'cod' => '2.02',
            'descripcion' => 'Otras fabricaciones en telas y otros materiales, excepto caucho, plástico o madera.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Secundario',
            'ramo' => 'Manufactura',
            'cod' => '2.02',
            'descripcion' => 'Aserraderos y talleres de acepilladura.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Secundario',
            'ramo' => 'Manufactura',
            'cod' => '2.02',
            'descripcion' => 'Fabricación de materiales de madera y metal para la construcción de edificaciones, cajas, jaulas, tambores, barriles y otros envases de madera y metal, mangos de madera para herramientas y de artículos menudos de madera, ataúdes, muebles o accesorios, de madera, metal, ratán, mimbre y otras fibras.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Secundario',
            'ramo' => 'Manufactura',
            'cod' => '2.02',
            'descripcion' => 'Fabricación de sustancias químicas industriales, básicas, abono y plaguicidas.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Secundario',
            'ramo' => 'Manufactura',
            'cod' => '2.02',
            'descripcion' => 'Fabricación de pinturas, barnices y lacas.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Secundario',
            'ramo' => 'Manufactura',
            'cod' => '2.02',
            'descripcion' => 'Fabricación de productos farmacéuticos, sustancias químicas medicinales y productos botánicos de uso farmacéutico.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Secundario',
            'ramo' => 'Manufactura',
            'cod' => '2.02',
            'descripcion' => 'Fabricación de jabones y preparados de limpieza, perfumes, cosméticos y otros productos de tocador. Fabricación de ceras, abrillantadores, desinfectantes, desodorizantes, pulimentos de muebles y metales, otros productos de limpieza y mantenimiento no especificados.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Secundario',
            'ramo' => 'Manufactura',
            'cod' => '2.02',
            'descripcion' => 'Construcción y ensamblaje de vehículos, automotores y fabricación de chasis para vehículos, carrocería y aeronaves.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Secundario',
            'ramo' => 'Manufactura',
            'cod' => '2.02',
            'descripcion' => 'Fabricación de juguetes y adornos Infantiles, artículos de oficina y artículos para escribir.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Secundario',
            'ramo' => 'Manufactura',
            'cod' => '2.02',
            'descripcion' => 'Fabricación de colchones, almohadas y cojines.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Secundario',
            'ramo' => 'Manufactura',
            'cod' => '2.02',
            'descripcion' => 'Fabricación de servicios de mesa, utensilios de cocina y artículos de tocador, bolsas, envases, estuches, botellas y sus accesorios, artículos diversos de material plásticos, objetos barro, loza y porcelana.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Secundario',
            'ramo' => 'Manufactura',
            'cod' => '2.02',
            'descripcion' => 'Fabricación en vidrio y fibras de vidrio y manufactura de vidrio para carros y otros vidrios de seguridad.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Secundario',
            'ramo' => 'Manufactura',
            'cod' => '2.02',
            'descripcion' => 'Fabricación de productos de arcilla y cerámica para construcción.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Secundario',
            'ramo' => 'Manufactura',
            'cod' => '2.02',
            'descripcion' => 'Fabricación de cemento, cal, yeso, hormigón y otros productos a base de cemento, mármol, granito y otras piedras naturales.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Secundario',
            'ramo' => 'Manufactura',
            'cod' => '2.02',
            'descripcion' => 'Fabricación de abrasivos en general.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Secundario',
            'ramo' => 'Manufactura',
            'cod' => '2.03',
            'descripcion' => 'Manufactura de licores, tabaco, cigarrillos y derivados.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Secundario',
            'ramo' => '	Construcción',
            'cod' => '2.04',
            'descripcion' => 'Industrias básicas del hierro y del acero.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Secundario',
            'ramo' => '	Construcción',
            'cod' => '2.04',
            'descripcion' => 'Fabricación de piezas fundidas, forjadas o estampadas, de hierro o acero, productos con cobre, plomo, estaño, zinc, bronce y latón, estructuras y construcciones mayores de hierro, productos estructurales de aluminio, envases metálicos.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Secundario',
            'ramo' => 'Construcción',
            'cod' => '2.04',
            'descripcion' => 'Construcción de edificios, casas para vivienda, hospitales, edificios para industrias y talleres fabriles. Instalación de pilotes, trabajos de excavación, cimentación y rehabilitación de tierras para construcciones. Albañilería en construcción de edificios, instalación de lomería, instalaciones eléctricas, instalación de ascensores, instalación de aire acondicionado y sistemas de ventilación, pintura y decoración de edificios, obras de construcción, reforma, reparación y demolición de edificios distintos a aquellos servicios prestados a la Industria Petrolera, petroquímica y similares.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Secundario',
            'ramo' => 'Construcción',
            'cod' => '2.04',
            'descripcion' => 'Construcción y reparación de máquinas y equipos electrónicos.Fabricación de equipo de ventilación, aire acondicionado y refrigeración comercial e Industrial. Fabricación de aparatos y accesorios eléctricos. Fabricación de equipo profesional y científico e Instrumentos de medida y control. Fabricación de bombillos,tubos eléctricos, lámparas y accesorios de metal para iluminación eléctrica.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Secundario',
            'ramo' => 'Construcción',
            'cod' => '2.04',
            'descripcion' => 'Fabricación de instrumentos de óptica, lentes y artículos oftálmicos.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Secundario',
            'ramo' => 'Construcción',
            'cod' => '2.04',
            'descripcion' => 'Fabricación de maquinaria y equipos diversos no clasificados.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Secundario',
            'ramo' => 'Construcción',
            'cod' => '2.04',
            'descripcion' => 'Construcción, reparación y mantenimiento de calles, caminos y carreteras. Construcción de aeropuertos con todas sus instalaciones relacionadas. Construcción de centrales eléctricas de origen térmico, Instalación de líneas y equipos para la transmisión y distribución de electricidad, instalación de centrales y líneas telefónicas y telegráficas. Construcción de represas, diques y canales. Construcción de puertos y obras relacionadas. Dragado y eliminación de rocas marítimas y fluviales. Otras construcciones de obras portuarias, n.e.p. Construcción de cloacas y alcantarillado. Construcción de incineradores y compactadores de basura y desperdicios, distintos a aquellos servicios prestados a la Industria Petrolera, petroquímica y similares.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Secundario',
            'ramo' => 'Construcción',
            'cod' => '2.05',
            'descripcion' => 'Construcción, servicios y suministros relaciones con obras civiles, eléctricas, mecánicas, de instrumentación, exploración, perforación, extracción y procesamiento de crudo o sus derivados, así como otros servicios o suministros de cualquier índole prestados a la industria petrolera, petroquímica y similar.',
        ]);


        ///// TERCIARIO 

        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al por mayor',
            'cod' => '3.01',
            'descripcion' => 'Materias primas, agrícolas, pecuarias, cafés en granos, granos, cereales, leguminosos, grasos, aceites crudos (vegetal y animal).',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al por mayor',
            'cod' => '3.01',
            'descripcion' => 'Minerales, metales, productos químicos, combustible (gasolina, gas-oil, kerosén, etc.), aceites, grasas lubricantes, minerales y metales ferrosos y no ferrosos.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al por mayor',
            'cod' => '3.01',
            'descripcion' => 'Barras, cabillas, perfiles, tubos, vaciados, alambres.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al por mayor',
            'cod' => '3.01',
            'descripcion' => 'Productos químicos industriales básicos, colorantes industriales, resinas, abonos, plaguicidas, detergentes, artículos de limpieza.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al por mayor',
            'cod' => '3.01',
            'descripcion' => 'Productos farmacéuticos, medicamentos.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al por mayor',
            'cod' => '3.01',
            'descripcion' => 'Cosméticos, perfumes, artículos de tocador.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al por mayor',
            'cod' => '3.01',
            'descripcion' => 'Productos veterinarios.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al por mayor',
            'cod' => '3.01',
            'descripcion' => 'Madera aserrada, cepillada, terciada o contra enchapada.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al por mayor',
            'cod' => '3.01',
            'descripcion' => 'Materiales de construcción.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al por mayor',
            'cod' => '3.01',
            'descripcion' => 'Vehículos automóviles, repuestos y accesorios para vehículos automóviles motocicletas, motonetas, bicicletas, llantas, cámaras de caucho, e acumuladores, baterías, maquinaria, equipos para la agricultura.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al por mayor',
            'cod' => '3.01',
            'descripcion' => 'Máquinas de escribir, calcular, artículos de oficina, muebles, y accesorios para la Industria, el comercio y la agricultura, para clínicas y hospitales.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al por mayor',
            'cod' => '3.01',
            'descripcion' => 'Equipo profesional y científico e instrumentos de medida y de control, materiales de ferretería, pinturas, lacas, barnices, artículos y materiales eléctricos, repuestos y accesorios para artefactos domésticos, cuchillería y artículos de porcelana, loza, vidrio, artículos y accesorios de cocina, aparatos de ventilación, aire acondicionado refrigeración, aparatos y sistemas de comunicación, muebles, accesorios para el hogar, cortinas, alfombras, tapices, lámparas, marcos, cuadros, espejos, telas, mercerías, lencerías.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al por mayor',
            'cod' => '3.01',
            'descripcion' => 'Prendas de vestir para caballeros, damas y niños, calzados, artículos de zapaterías, artículos de cuero natural, géneros textiles, prendas de vestir, artefactos de uso doméstico.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al por mayor',
            'cod' => '3.01',
            'descripcion' => 'Leche, queso, mantequilla, otros productos, carne de ganado vacuno, porcino, caprino, otras carnes, aves beneficiadas, pescados, mariscos, frutas, hortalizas, productos de molinería, aceites y grasas comestibles (refinadas).',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al por mayor',
            'cod' => '3.01',
            'descripcion' => 'Distribución y comercialización de bebidas alcohólicas.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al por mayor',
            'cod' => '3.01',
            'descripcion' => 'Mayor de bebidos no alcohólicas.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al por mayor',
            'cod' => '3.01',
            'descripcion' => 'Bombones, caramelos, confitería, cigarrillos, tabacos, alimentos para animales, productos alimenticios, papel, cartón, libros, periódicos, revistas, artículos deportivos, juguetes.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al por mayor',
            'cod' => '3.01',
            'descripcion' => 'Joyas, relojes.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al por mayor',
            'cod' => '3.01',
            'descripcion' => 'Instrumentos y accesorios musicales, discos para fonógrafos, cartuchos, cassettes.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al por mayor',
            'cod' => '3.01',
            'descripcion' => 'Flores, plantas naturales.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al por mayor',
            'cod' => '3.01',
            'descripcion' => 'Artículos fotográficos, cinematográficos.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al por mayor',
            'cod' => '3.01',
            'descripcion' => 'Instrumentos de óptica.',
        ]);

        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al detal',
            'cod' => '3.02',
            'descripcion' => 'Supermercados, automercados, tiendas por departamentos, hipermercados.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al detal',
            'cod' => '3.02',
            'descripcion' => 'Abasto, bodegas, pulperías, aceites y grasas comestibles (refinadas), productos, alimentos o especies naturistas, gas natural en bombonas.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al detal',
            'cod' => '3.02',
            'descripcion' => 'Farmacias, botica, expendio de medicinas, perfumería, cosméticos, artículos de tocador.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al detal',
            'cod' => '3.02',
            'descripcion' => 'Preparados, detal de carnes, aves de corral, pescado, mariscos, frutas, verduras, hortalizas, bebidas no alcohólicas envasadas, hielo, alimentos para animales, charcutería, pasapalos, delicateses, detergentes, artículos de limpieza.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al detal',
            'cod' => '3.02',
            'descripcion' => 'Telas, mercerías,  prendas de vestir para damas, caballeros y niños, lencería, calzado, carteras, maletas, maletines, neceseres y otro. artículos de cuero, sucedáneos del cuero, prenda de vestir playera.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al detal',
            'cod' => '3.02',
            'descripcion' => 'Muebles, accesorios para el hogar, artefactos, artículos, accesorios, para uso domésticos, eléctricos o no eléctricos, equipos de ventilación, aire acondicionado, refrigeración, artefactos, mobiliarios y sus accesorios para hospitales, clínicas, ambulatorios, consultorios, accesorios para oficinas.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al detal',
            'cod' => '3.02',
            'descripcion' => 'Instrumentos musicales, discos, cartuchos, cassettes.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al detal',
            'cod' => '3.02',
            'descripcion' => 'Lámparas, persianas, alfombras, cortinas,  tapicerías,  cuadros, marcos, cañuelas, cristales, espejos.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al detal',
            'cod' => '3.02',
            'descripcion' => 'Equipos e instrumentos de medición, control, ubicación y sus accesorios, maquinas o equipos especializados para la construcción, tarjetas magnéticas y no magnéticas para comunicaciones, artículos de ferretería, pintura, lacas, barnices, repuestos para artefactos eléctricos y no eléctricos, materiales de construcción, cuchillería, vajilla y otros artículos de vidrio, loza o porcelana.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al detal',
            'cod' => '3.02',
            'descripcion' => 'Automóviles, camiones, autobuses, motocicletas, motonetas, bicicletas, repuestos y accesorios para vehículos, acumuladores o baterías, llantas, cámaras de caucho, lanchas, motores para lanchas y otras embarcaciones, artículos, prendas y accesorios policiales, militares, seguridad personal,  equipo o audio para vehículo, vehículos automóviles, motocicletas, bicicletas, aceites, grasas, lubricantes y aditivos especiales para maquinarias.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al detal',
            'cod' => '3.02',
            'descripcion' => 'Bazares, juguetes, Papelería, librerías, revistas, bombones, caramelos, confitería, artículos para regalos y novedades (Quincallerías), pelucas, peluquines, artículos deportivos, artículos de artesanía, típicos, folklóricos.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al detal',
            'cod' => '3.02',
            'descripcion' => 'Floristería, artículos para jardines, plantas o especies naturales de la flora (viveros).',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al detal',
            'cod' => '3.02',
            'descripcion' => 'Joyas, relojes.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al detal',
            'cod' => '3.02',
            'descripcion' => 'Fertilizantes, abonos y otros productos, químicos para la agricultura, productos veterinarios, animales domésticos, máquinas, accesorios, aparatos, prendas o dispositivos para animales domésticos.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al detal',
            'cod' => '3.02',
            'descripcion' => 'Computadoras aparatos informáticos y sus accesorios, teléfonos celulares, inalámbricos y accesorios, artículos, dispositivos, aparatos y equipos de fotocopiado, escáner, digitalizadores.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al detal',
            'cod' => '3.02',
            'descripcion' => 'Aparatos sexuales, eróticos, juguetes de adultos.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al detal',
            'cod' => '3.02',
            'descripcion' => 'Artículos religiosos, artículos esotéricos, paranormales.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al detal',
            'cod' => '3.02',
            'descripcion' => 'Artículos de fotografía, cinematografía.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Comercio al detal',
            'cod' => '3.02',
            'descripcion' => 'Instrumentos de óptica.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Venta al detal y/o mayor de licores',
            'cod' => '3.02.01',
            'descripcion' => 'Licorerías, bodegones, distribuidoras y cualquier tipo de venta al detal o distribución al mayor de bebidas alcohólicas tapadas y en sus envases originales.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Alimentos, bebidas y esparcimiento',
            'cod' => '3.03.01',
            'descripcion' => 'Restaurantes sin expendio de bebidas alcohólicas, cafeterías, heladerías, refresquerías, areperas, cafés.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Alimentos, bebidas y esparcimiento',
            'cod' => '3.03.01',
            'descripcion' => 'Parques, salas de atracción.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Alimentos, bebidas y esparcimiento',
            'cod' => '3.03.01',
            'descripcion' => 'Clubes sociales con o sin fines de lucro.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Alimentos, bebidas y esparcimiento',
            'cod' => '3.03.01',
            'descripcion' => 'Agencias de festejos y otros servidos conexos.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Alimentos, bebidas y esparcimiento',
            'cod' => '3.03.02',
            'descripcion' => 'Agencias de billetes de lotería, terminales, apuestas hípicas, casas de apuestas, sport book.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Alimentos, bebidas y esparcimiento',
            'cod' => '3.03.03',
            'descripcion' => 'Casinos, bingos, maquinas traganíqueles, salas, recintos de juegos.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Alimentos, bebidas y esparcimiento',
            'cod' => '3.03.04',
            'descripcion' => 'Catering, servicios de comida producidos en forma industrial, servicios de shipchandlers, atenciones a embarcaciones y tripulantes.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Alimentos, bebidas y esparcimiento',
            'cod' => '3.03.05',
            'descripcion' => 'Bares, cervecerías, tascas, bar-restaurante, cabarets, night club, american bar, discotecas, karaokes, fuentes de soda con expendio de cervezas, vinos y cocteles.',
        ]);

        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Hoteles, pensiones y afines',
            'cod' => '3.04.01',
            'descripcion' => 'Hoteles.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Hoteles, pensiones y afines',
            'cod' => '3.04.02',
            'descripcion' => 'Hostales, pensiones, posadas, campamentos y hospedajes.',
        ]);

        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Transporte de pasajero y carga terrestre, marítimo y aéreo',
            'cod' => '3.05.01',
            'descripcion' => 'Líneas de buses urbanas e interurbanas, transporte de pasajeros por carreteras, taxis para transporte de pasajeros, líneas de carros por puesto para transporte de pasajeros por carretera, transportes especiales para turistas y excursionistas.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Transporte de pasajero y carga terrestre, marítimo y aéreo',
            'cod' => '3.05.01',
            'descripcion' => 'Estación de servicios (gasolineras).',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Transporte de pasajero y carga terrestre, marítimo y aéreo',
            'cod' => '3.05.01',
            'descripcion' => 'Alquiler de automóviles sin chofer, alquiler de camiones con chofer, consolidación y desconsolidación de cargas, transporte multimodal.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Transporte de pasajero y carga terrestre, marítimo y aéreo',
            'cod' => '3.05.01',
            'descripcion' => 'Agentes de aduanas, servicio de tránsito de mercancías, servicios de depósito o almacenamiento, servicios de estiba, desestiba de cargas, agencias navieras, vapores, alquiler, resguardo, custodia, reparación y mantenimiento de contenedores o furgones, almacén para mercancía en general.',
        ]);

        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Transporte de pasajero y carga terrestre, marítimo y aéreo',
            'cod' => '3.05.02',
            'descripcion' => 'Servicios de transporte a pasajeros ocasionales, transporte de carga terrestre, transporte marítimo de pasajeros, transporte de cabotaje, transportes oceánicos, transporte aéreo de pasajeros, transporte aéreo de carga, distribución y comercio de bebidas alcohólicas a través de vehículos, servicios de transportación.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Transporte de pasajero y carga terrestre, marítimo y aéreo',
            'cod' => '3.05.03',
            'descripcion' => 'Servicios de mantenimiento de muelles, atracaderos, faros, edificios e instalaciones conexas para la navegación, servicio de remolques marítimos, servicio de alquiler de buques, otros medios de transporte, servicios relacionados, con el transporte por agua. Reparación y mantenimiento de embarcaciones, servicio de handling, groundservices, remolques, demás servicios a aeronaves, líneas aéreas.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Transporte de pasajero y carga terrestre, marítimo y aéreo',
            'cod' => '3.05.03',
            'descripcion' => 'Servicios de mudanzas nacionales e internacionales, alquiler de aeronaves con o sin pilotos, servicios de correo, paqueterías, encomiendas, cargas menores, servicios de embalaje y empaque de artículos.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Transporte de pasajero y carga terrestre, marítimo y aéreo',
            'cod' => '3.05.04',
            'descripcion' => 'Agencias de viajes.',
        ]);

        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Servicios de salud, estética y cuidado personal',
            'cod' => '3.06',
            'descripcion' => 'Clínicas, consultorios y otras instituciones similares, laboratorios médicos y dentales, servicios de ambulancia, hospitales, imagenología, geriátricos, clínicas para animales y demás servicios conexos a la salud.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Servicios de salud, estética y cuidado personal',
            'cod' => '3.06',
            'descripcion' => 'Peluquerías, salones de belleza, barberías, escuelas de peluquería, baños turcos, sala de masajes, gimnasios, servicio de pedicuros, manicuros y quiropedia.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Otros Servicios domésticos y empresariales',
            'cod' => '3.07',
            'descripcion' => 'Recolección, reciclaje, destrucción de desperdicios y desechos, limpieza en edificios, casa, exterminio, fumigación, desinfección, servicios de mantenimiento, limpieza de drenajes, desagües, bateas, cunetas, ductos, brocales, embaulamiento de quebradas.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Otros Servicios domésticos y empresariales',
            'cod' => '3.07',
            'descripcion' => 'Auto-escuelas, academias, otros institutos similares.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Otros Servicios domésticos y empresariales',
            'cod' => '3.07',
            'descripcion' => 'Agencias de detectives, de protección personal, resguardo a la propiedad, servicios, instalación y venta de dispositivos o aparatos para sistemas de seguridad personal, residencial, industrial o comercial.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Otros Servicios domésticos y empresariales',
            'cod' => '3.07',
            'descripcion' => 'Agencias funerarias.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Otros Servicios domésticos y empresariales',
            'cod' => '3.07',
            'descripcion' => 'Estacionamiento, autolavados.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Otros Servicios domésticos y empresariales',
            'cod' => '3.07',
            'descripcion' => 'Servicios de mantenimiento, cultivo de áreas verdes ornamentales.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Otros Servicios domésticos y empresariales',
            'cod' => '3.07',
            'descripcion' => 'Actividades de gestoría de documentos, tramitaciones, agencias de colocaciones, gestoría de cobranzas.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Otros Servicios domésticos y empresariales',
            'cod' => '3.07',
            'descripcion' => 'Servicios de reproducción, impresión heliográfica, fotocopia de correspondencia, documentos, taquimecanografía, traducción.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Telecomunicaciones',
            'cod' => '3.08',
            'descripcion' => 'Empresas con concesión o contrato para operar servicios de telecomunicaciones, tales como: telefonía fija, celular, voz y datos sobre IP, trunking, internet u otros valores agregados. Servicio de radiodifusión y televisión abierta, por cable, satélite u otro medio tecnológico similar. Ventas de equipos de telecomunicaciones.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Radiodifusión',
            'cod' => '3.09',
            'descripcion' => 'Empresas con concesión o contrato para operar servicios de radiodifusión sonora.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Tecnología, formación y medios de difusión',
            'cod' => '3.10',
            'descripcion' => 'Servicio y programación de sistemas, navegación de internet, cibercafé y realidad virtual.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Tecnología, formación y medios de difusión',
            'cod' => '3.10',
            'descripcion' => 'Instrucción y talleres de computación, cursos de formación continuada privada presencial u on-line.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Tecnología, formación y medios de difusión',
            'cod' => '3.10',
            'descripcion' => 'Estudios fotográficos y otros servicios relacionados con la fotografía, laboratorios de revelado y copia de películas, servicios de audio, data y video, arrendamiento y ventas de películas grabadas o filmadas, videos y juegos digitalizados. Otros servicios relacionados con la distribución y exhibición de películas, n.e.p.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Tecnología, formación y medios de difusión',
            'cod' => '3.10',
            'descripcion' => 'Entradas a espectáculos públicos, agencias de contratación de actores, obras teatrales, artistas y conciertos.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Tecnología, formación y medios de difusión',
            'cod' => '3.10',
            'descripcion' => 'Empresas grabadoras de discos, cintas y similares, servicios, instalación y venta de dispositivos o aparatos para sistemas de seguridad personal, residencial, industrial o comercial.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Tecnología, formación y medios de difusión',
            'cod' => '3.10',
            'descripcion' => 'Servicios de anuncios publicitarios, en todo tipo de medios informativos, carteles, anuncios luminosos, distribución de propagandas, ornamentación de vidrieras.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Tecnología, formación y medios de difusión',
            'cod' => '3.10',
            'descripcion' => '	Comercialización en medios digitales.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Tecnología, formación y medios de difusión',
            'cod' => '3.10',
            'descripcion' => 'Litografía, tipografías e Imprentas en general, edición de periódicos y revistas, edición de libros, cuadernos y materiales didácticos impresos, y cualquier otro medio de difusión no especificado.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Mecánica, electricidad y gas',
            'cod' => '3.11',
            'descripcion' => 'Prestación de servicios mecánicos, eléctricos y de gas a domicilio o en talleres.',
        ]);


        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Bancos comerciales, instituciones financieras y seguros	',
            'cod' => '3.12.01',
            'descripcion' => 'Agencias de bancos comerciales, asociaciones de ahorro y préstamo, establecimientos de crédito personal y agentes de préstamo.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Bancos comerciales, instituciones financieras y seguros	',
            'cod' => '3.12.01',
            'descripcion' => 'Casas de cambio.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Bancos comerciales, instituciones financieras y seguros	',
            'cod' => '3.12.01',
            'descripcion' => 'Empresas de investigación y asesoramiento sobre inversiones.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Bancos comerciales, instituciones financieras y seguros	',
            'cod' => '3.12.01',
            'descripcion' => 'Compañías de seguros y reaseguros, agentes y corredores de seguros, agencias de avalúos y servicios para fines de seguros.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Bancos comerciales, instituciones financieras y seguros	',
            'cod' => '3.12.01',
            'descripcion' => '',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Bancos comerciales, instituciones financieras y seguros	',
            'cod' => '3.12.02',
            'descripcion' => 'Casas de empeño, otros establecimientos financieros.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Servicios inmobiliarios, administradoras y actividades de índole similar',
            'cod' => '3.13.01',
            'descripcion' => 'Servicios inmobiliarios en la compra y venta de bienes inmuebles, oficinas urbanizadoras, arrendamiento y administración de bienes e inmuebles, administración de condominios.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Servicios inmobiliarios, administradoras y actividades de índole similar',
            'cod' => '3.13.01',
            'descripcion' => 'Ventas de parcelas, fosas, para la inhumación de cadáveres.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Servicios inmobiliarios, administradoras y actividades de índole similar',
            'cod' => '3.13.02',
            'descripcion' => 'Empresas administradoras de puerto y aeropuerto.',
        ]);

        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Actividades con impuesto fijo por equipos de servicios no especificados y comercio eventual y ambulante',
            'cod' => '3.14',
            'descripcion' => 'Aparatos, máquinas y dispositivos para juegos o para actividades y servicios diversos accionados por cualquier medio de funcionamiento. Aparatos accionados por medio de moneda, fichas, tarjetas magnéticas, u otra forma; o por cuyo funcionamiento se cobre al público en cualquier forma (Cada Uno), musicales, en bares, cantinas, fuentes de soda u otros recintos, por cada aparato, musicales en cabarets, discotecas y clubes, por cada aparato. Aparatos o máquinas de juego o diversión, accionados por medio de monedas, fichas o impulsos electrónicos, aparatos o máquinas de juego o diversión, accionados por medio de monedas o fichas, por cada aparato.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Actividades con impuesto fijo por equipos de servicios no especificados y comercio eventual y ambulante',
            'cod' => '3.14',
            'descripcion' => 'Refrescos y bebidas no alcohólicas, por cada aparato, cigarrillos, por cada aparato, golosinas y otros comestibles listos para el consumo, por cada aparato, billares, pool, por cada  mesa, juegos de Bowling, por cada cancha.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Actividades con impuesto fijo por equipos de servicios no especificados y comercio eventual y ambulante',
            'cod' => '3.14',
            'descripcion' => 'Pesos automáticos que funcionan por medio de monedas, fichas u otro modo. Los demás dispositivos, instrumentos, maquinas o aparatos, por cada aparato de estos.',
        ]);
        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Actividades con impuesto fijo por equipos de servicios no especificados y comercio eventual y ambulante',
            'cod' => '3.14',
            'descripcion' => 'Venta de periódicos, revistas y golosinas, stands, módulos de venta, alimentos no perecederos, flores, frutas, legumbres, hortalizas, jugos naturales, máquinas de café, chicha, helados, dulces criollos, perros calientes, parrillas, pepitos, cachapas, hamburguesas, arepas, empanadas, refrescos, perros calientes, parrillas, pepitos, cachapas, hamburguesas, arepas, empanadas, churros, donuts, panecillos, pastelitos prendas de vestir, zapatos, lencería, juguetes, prendas, accesorios, productos de playa, perfumes, cosméticos, productos de tocador, arreglos de calzados, alquiler de tarjetas de teléfonos o de teléfonos, reparaciones de relojes o prendas o servicios en general, sillas toldos y otros objetos para pernoctar en la playa y lugares, expendio de bebidas alcohólicas eventuales.',
        ]);

        DB::table('actividades_economicas')->insert([
            'sector' => 'Terciario',
            'ramo' => 'Actividad no bien especificada',
            'cod' => '3.15',
            'descripcion' => 'Cualquier otra actividad que no especifique en el clasificador único de actividades económicas.',
        ]);
        





    }
}
