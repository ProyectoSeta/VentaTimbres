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
        margin: 40px;
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
    </style>
</head>
<body>
    <div class="">
        <div>
            <img src="../public/assets/header-doc.png" alt="" title="" width="100%"/>
        </div>


        <div class="titulo">
            <h3 class="">Reporte de Ventas | {{$fecha}}</h3>
        </div>

        
        <div class="section-title">Forma</div>
        <table>
            <tr>
                <td class="label">Timbre Fiscal Electrónico</td>
                <td class="amount">{{number_format($c1->recaudado_tfe, 2, ',', '.')}} Bs.</td>
            </tr>
            <tr>
                <td class="label">Timbre Fiscal Estampilla</td>
                <td class="amount">{{number_format($c1->recaudado_est, 2, ',', '.')}} Bs.</td>
            </tr>
        </table>

        <div class="section-title">Forma de Pago</div>
        <table>
            <tr>
                <td class="label">Punto de Venta</td>
                <td class="amount">{{number_format($c1->punto, 2, ',', '.')}} Bs.</td>
            </tr>
            <tr>
                <td class="label">Efectivo</td>
                <td class="amount">{{number_format($c1->efectivo, 2, ',', '.')}} Bs.</td>
            </tr>
        </table>

        <table>
            <tfoot>
            <tr>
                <td class="label">Total Recaudación</td>
                <td class="amount">{{number_format($c1->recaudado, 2, ',', '.')}} Bs.</td>
            </tr>
            </tfoot>
        </table>

        


        
    </div>
    
</body>
</html>