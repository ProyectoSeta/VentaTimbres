<!DOCTYPE html>
<html>
<head>
    <title>PDF Template</title>
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
        table {
            table-layout: fixed;
            width: 100%;
            border-collapse: collapse;
            text-align: center;
            border-spacing: 10px 5px;
        }
        th, td {
            padding-left: 15px;
            padding-right: 15px;
            /* padding-bottom: 3px; */
        }
        tr{
            padding-top: 0px;
            padding-bottom: 0px;
        }
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
    </style>
</head>
<body>
    <div class="">
        <div>
            <img src="../public/assets/header-doc.png" alt="" title="" width="100%"/>
        </div>

        <span class="fw-bold id">ID ASIGNACIÓN: {{$asignacion}}</span>

        <div class="titulo">
            <h3 class="">Asignación de Estampillas | Timbre móvil</h3>
        </div>

        <p class="parrafo">
            Yo, <span class="fw-bold">{{$taquillero}}</span>, portador de la cédula de identidad 
            <span class="fw-bold">{{$ci_taquillero}}</span>, designado a la taquilla {{$sede}} ID {{$id_taquilla}}, 
            hago constar por medio de la presente que recibo en taquilla el correlativo de estampillas descritas a continuación, 
            previstas para su venta.
        </p>


        <table>
            <thead>
                <tr>
                    <th>Estampillas</th>
                    <th>Desde</th>
                    <th>Hasta</th>
                    <th>Cant. Timbres</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($correlativo as $c)
                    <tr>
                        <td class="ucd_title">{{$c->ucd}} {{$c->alicuota}}</td>
                        <td>{{$c->desde}}</td>
                        <td>{{$c->hasta}}</td>
                        <td>{{$c->cantidad}} und.</td>
                    </tr>
                @endforeach
            </tbody>
        </table>


        <div id="content_firma">
            <hr>
            <span>Taquillero Designado</span><br>
            <span class="fw-bold">{{$taquillero}}</span><br>
            <span>{{$ci_taquillero}}</span>
        </div>
    </div>
    
</body>
</html>