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
    </style>
</head>
<body>
    <div class="">
        <div>
            <img src="../public/assets/header-doc.png" alt="" title="" width="100%"/>
        </div>

        <div class="titulo">
            <h3 class="fw-bold">Correlativo de Rollos | Timbres Fiscales</h3>
            <h4>Emisión Forma 14</h4>
        </div>
        

        <div class="div_table_rollos">
            <table class="table_rollos" id="tabla">
                <thead class="">
                    <tr>
                        <th>#</th>
                        <th>Desde</th>
                        <th>Hasta</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($correlativo as $c)
                        <tr>
                            <td>{{$c->id}}</td>
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