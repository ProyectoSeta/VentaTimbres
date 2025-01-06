<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>PDF Template</title>
    <style>
        @font-face{
            font-family: "Poppins";
            src: url('{{storage_path('fonts/Poppins-Light.ttf')}}') format('truetype');
            font-weight: 300;
            font-style: normal;
        }
        @font-face{
            font-family: "Poppins";
            src: url('{{storage_path('fonts/Poppins-Regular.ttf')}}') format('truetype');
            font-weight: 400;
            font-style: normal;
        }
        @font-face{
            font-family: "Poppins";
            src: url('{{storage_path('fonts/Poppins-Bold.ttf')}}') format('truetype');
            font-weight: 700;
            font-style: normal;
        }
        *{
            font-family: "Poppins";
            font-weight: 300;
        }
        .titulo{
            text-align: center;
        }
        .titulo h3{
            font-family: "Poppins";
            font-weight: 700;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .titulo h4{
            margin-top: 0;
            padding-top: 0;
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
        .thead tr th{
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="">
        <div>
            <img src="../public/assets/header-doc.png" alt="" title="" width="100%"/>
        </div>

        <div class="titulo">
            <h3 class="fw-bold">Correlativo del Lote en Emisión | PAPEL DE SEGURIDAD</h3>
            <h4>Timbres Fiscales Electrónicos Forma 14</h4>
        </div>
        

        <div class="div_table_rollos">
            <table class="table_rollos" id="tabla">
                <thead class="thead">
                    <tr>
                        <th width="10%">#</th>
                        <th>Desde</th>
                        <th>Hasta</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($correlativo as $c)
                        <tr>
                            <td>#</td>
                            <td>{{$c->desde}}</td>
                            <td>{{$c->hasta}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
</body>
</html>