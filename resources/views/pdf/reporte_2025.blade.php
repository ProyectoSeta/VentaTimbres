<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Trimestral de Recaudación</title>
    <style>
        /* Estilos generales para las tablas */
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            border-radius: 5px;
            overflow: hidden;
        }
        /* Estilos para los encabezados de la tabla */
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-transform: uppercase;
        }
        /* Estilos para las filas de totales mensuales */
        .total-mes {
            font-weight: bold;
            background-color: #f0f4c3;
            color: #689f38;
        }
        /* Estilos para las filas de totales trimestrales */
        .total-trimestre {
            font-weight: bold;
            background-color: #e0f7fa;
            color: #006064;
        }
        /* Estilos para las filas de totales anuales */
        .total-anual {
            font-weight: bold;
            font-size: 1.2em;
            background-color: #c8e6c9;
            color: #00897b;
        }

        /* Estilos para el encabezado de la página */
        h1 {
            color: #424242;
            text-align: center;
            margin-bottom: 20px;
        }

         /* Estilos para texto */
         p {
            color: #424242;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Estilos para los encabezados de los trimestres */
        h2 {
            color: #616161;
            margin-top: 30px;
            margin-bottom: 10px;
            text-align: center;
            text-transform: uppercase;
        }

         /* Estilos para los textos */
         p {
            color: #616161;
            margin-top: 30px;
            margin-bottom: 10px;
            text-align: center;
        }

        /* Estilos para separar los trimestres con bordes externos */
        .trimestre-table {
            border: 2px solid #616161;
            margin-bottom: 30px;
            padding: 10px;
        }

        .trimestre-table tfoot {
            margin-top: 10px;
        }

        /* Estilos para el nombre del mes */
        .nombre-mes {
            text-align: center;
            font-size: 1.3em;
            color: #000000;
            text-transform: uppercase;
            font-weight: bold;
            padding-top: 10px;
            padding-bottom: 10px;
        }
    </style>
</head>
<body>
    <h1>Reporte Trimestral de Recaudación Año 2025</h1>
    <p></p>
    <div class="trimestre-table">
        <h2>Trimestre 1 Ene-Mar</h2>
        <table>
            
            <thead>
                <tr>
                    <th colspan="4" class="nombre-mes">Enero</th>
                </tr>
                <tr>
                    <th>Descripción</th>
                    <th>Efectivo</th>
                    <th>Punto de Venta</th>
                    <th>Total Timbres</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Timbre Fiscal Electrónico</td>
                    <td>500,00 Bs.</td>
                    <td>700,00 Bs.</td>
                    <td class="total-producto">1.200,00 Bs.</td>
                </tr>
                <tr>
                    <td>Timbre Fiscal Estampilla</td>
                    <td>400,00 Bs.</td>
                    <td>600,00 Bs.</td>
                    <td class="total-producto">1.000,00 Bs.</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="total-mes">Total Enero</th>
                    <td class="total-mes">2.200,00 Bs.</td>
                </tr>
            </tfoot>
        </table>
        <table>
            
            <thead>
                <tr>
                    <th colspan="4" class="nombre-mes">Febrero</th>
                </tr>
                <tr>
                    <th>Descripción</th>
                    <th>Efectivo</th>
                    <th>Punto de Venta</th>
                    <th>Total Timbres</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Timbre Fiscal Electrónico</td>
                    <td>500,00 Bs.</td>
                    <td>700,00 Bs.</td>
                    <td class="total-producto">1.200,00 Bs.</td>
                </tr>
                <tr>
                    <td>Timbre Fiscal Estampilla</td>
                    <td>400,00 Bs.</td>
                    <td>600,00 Bs.</td>
                    <td class="total-producto">1.000,00 Bs.</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="total-mes">Total Febrero</th>
                    <td class="total-mes">2.200,00 Bs.</td>
                </tr>
            </tfoot>
        </table>
        <table>
            <thead> 
            <tr>
                <th colspan="4" class="nombre-mes">Marzo</th>
            </tr>
                <tr>
                    <th>Descripción</th>
                    <th>Efectivo</th>
                    <th>Punto de Venta</th>
                    <th>Total Timbres</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Timbre Fiscal Electrónico</td>
                    <td>500,00 Bs.</td>
                    <td>700,00 Bs.</td>
                    <td class="total-producto">1.200,00 Bs.</td>
                </tr>
                <tr>
                    <td>Timbre Fiscal Estampilla</td>
                    <td>400,00 Bs.</td>
                    <td>600,00 Bs.</td>
                    <td class="total-producto">1.000,00 Bs.</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="total-mes">Total Marzo</th>
                    <td class="total-mes">2.200,00 Bs.</td>
                </tr>
            </tfoot>
        </table>
        <table>
            <tfoot>
                <tr>
                    <th colspan="3" class="total-trimestre">Total Trimestre 1</th>
                    <td class="total-trimestre">6.600,00 Bs.</td>
                </tr>
            </tfoot>
        </table>
    </div>
   
   
    <h2>Recaudado hasta la fecha</h2>
    <table>
        <tbody>
            <tr>
                <th>Total Timbres Fiscal Electrónico</th>
                <td class="total-anual">3.600,00 Bs.</td>
            </tr>
            <tr>
                <th>Total Timbre Fiscal Estampilla</th>
                <td class="total-anual">3.000,00 Bs.</td>
            </tr>
            <tr>
                <th>Total</th>
                <td class="total-anual">6.600,00 Bs.</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
