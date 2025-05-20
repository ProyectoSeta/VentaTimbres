<!DOCTYPE html>
<html>
<head>
    <title>Reporte Taquilla</title>
    <style>
        *{
            font-family: "Reddit Sans", sans-serif;
        }
        .titulo{
            text-align: center;
        }
        #tabla{
            margin: auto;
        }
        /* table {
            table-layout: fixed;
            width: 100%;
            border-collapse: collapse;
            text-align: center;
            border-spacing: 10px 5px;
        }
        th, td {
            padding-left: 15px;
            padding-right: 15px;
        }
        tr{
            padding-top: 0px;
            padding-bottom: 0px;
        } */
        .parrafo{
            text-align: justify;
            padding-right: 17px;
            padding-left: 17px;
        }
        .ucd_title{
            font-size: 18px;
            font-weight: bold;
            color: #022040;
        }
        #cant_title{
            font-size: 16px;
            /* font-weight: bold; */
            color: #5c5c5c;
            padding-bottom: 20px;
        }
        #tr_ucd{
            background-color: #85bef8a7;  
            /* border-spacing: 100px 5px; */
        }
        
        .fw-bold{
            font-weight: bold;
        }
        hr {
            height: 1px;
            width: 30%;
            background-color: black;
        }
        #content_firma{
            display: flex;
            justify-content: center;
            text-align: center;
            margin-top: 140px;
        }
        .table_detalle{
            margin-bottom: 20px;
        }

        body {
        /* font-family: Arial, sans-serif;
        background-color: #f4f4f4; */
        /* margin: 40px; */
        color: #333;
        }
        h3 {
        text-align: center;
        color: #444;
        margin-bottom: 40px;
        }
        table {
        width: 100%;
        margin: 20px auto;
        border-collapse: collapse;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ccc;
        font-size: 12px;
        }
        th {
        background-color: #e0e0e0;
        color: #000;
        }
        td.label {
        font-weight: bold;
        background-color: #f0f0f0;
        width: 50%;
        }
        td.amount {
        text-align: right;
        }
        tfoot td {
        font-weight: bold;
        background-color: #d0d0d0;
        }
        .section-title {
        text-align: left;
        margin-top: 40px;
        font-weight: bold;
        color: #555;
        }
        .msj{
            color: #5c5c5c;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="">
        <div>
            <img src="../public/assets/header-doc.png" alt="" title="" width="100%"/>
        </div>


        <div class="titulo">
            <h3 class="">Reporte de Ventas Anual | {{$year}}</h3>
        </div>

        
        <!-- <div class="section-title">Enero</div> -->
        
        @foreach ($content_meses as $mes)
            <h4 class="">{{$mes->mes}}</h4>
            <table>
                <thead>
                <tr>
                    <th></th>
                    <th>Timbre Fiscal Electrónico</th>
                    <th>Timbre Fiscal Estampilla</th>
                    <th>Punto de Venta</th>
                    <th>Efectivo</th>
                </tr>
                </thead>
                <tbody>
                    @if ($mes->actividad == true)
                        <tr>
                            <th>Recaudado</th>
                            <td>{{number_format($mes->recaudado_tfe, 2, ',', '.')}} Bs.</td>
                            <td>{{number_format($mes->recaudado_est, 2, ',', '.')}} Bs.</td>
                            <td>{{number_format($mes->recaudado_punto, 2, ',', '.')}} Bs.</td>
                            <td>{{number_format($mes->recaudado_efectivo, 2, ',', '.')}} Bs.</td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="5 msj">Sin Actividad.</td>
                        </tr>
                    @endif
                    
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="3">Total Recaudación</td>
                    <td colspan="2">{{number_format($mes->recaudado_mes, 2, ',', '.')}} Bs.</td>
                </tr>
                </tfoot>
            </table>
        @endforeach


    


        <h4 class="titulo">Resumen Anual</h4>
        <table>
            <thead>
            <tr>
                <th></th>
                <th>Timbre Fiscal Electrónico</th>
                <th>Timbre Fiscal Estampilla</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th>Recaudado</th>
                <td>{{number_format($recaudacion_total_tfe, 2, ',', '.')}} Bs.</td>
                <td>{{number_format($recaudacion_total_est, 2, ',', '.')}} Bs.</td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="1">Total General</td>
                <td colspan="2">{{number_format($recaudacion_total, 2, ',', '.')}} Bs.</td>
            </tr>
            </tfoot>
        </table>
  

        


        
    </div>
    
</body>
</html>