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
        }
        th, td {
            padding: 15px;
            padding-bottom: 6px;
        }
        .parrafo{
            text-align: justify;
            padding-right: 17px;
            padding-left: 17px;
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
        /* .id{
            margin-top: 10px;
            text-align: end;
        } */
    </style>
</head>
<body>
    <div class="">
        <div>
            <img src="../public/assets/header-doc.png" alt="" title="" width="100%"/>
        </div>

        <span class="fw-bold id">ID ASIGNACIÓN: {{$asignacion}}</span>

        <div class="titulo">
            <h3 class="">Asignación de Rollos | Forma 14</h3>
        </div>

        <p class="parrafo">
            Yo, <span class="fw-bold">{{$taquillero}}</span>, portador de la cédula de identidad <span class="fw-bold">{{$ci_taquillero}}</span>, designado a la taquilla {{$sede}} ID {{$id_taquilla}}, 
            hago constar por medio de la presente que recibo en taquilla la cantidad de <span class="fw-bold">{{$cant_rollos}} Rollos de Timbres Fiscales</span>, para la venta de 
            Timbres Electrónicos TFE-14. A continuación, se detalla el correlativo de los rollos recibidos:
        </p>

        <!-- <h4>Correlativo</h4> -->

        <div class="div_table_rollos">
            <table class="table_rollos" id="tabla">
                <thead class="">
                    <tr>
                        <th>#</th>
                        <th>Desde</th>
                        <th>Hasta</th>
                        <th>Cant. Timbres</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($correlativo as $c)
                        <tr>
                            <td>{{$c->id}}</td>
                            <td>{{$c->desde}}</td>
                            <td>{{$c->hasta}}</td>
                            <td>{{$c->cant_timbres}} und.</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


        <div id="content_firma">
            <hr>
            <span>Taquillero Designado</span><br>
            <span class="fw-bold">{{$taquillero}}</span><br>
            <span>{{$ci_taquillero}}</span>
        </div>
    </div>
    
</body>
</html>