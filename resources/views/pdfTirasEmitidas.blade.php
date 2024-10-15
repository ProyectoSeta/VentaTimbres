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
        #ucd_title{
            font-size: 15px;
            font-weight: bold;
            color: #022040;
        }
    </style>
</head>
<body>
    <div class="">
        <div>
            <img src="../public/assets/header-doc.png" alt="" title="" width="100%"/>
        </div>

        <div class="titulo">
            <h3 class="fw-bold">Correlativo de Tiras| Timbres Fiscales</h3>
            <h4>Emisión Estampillas</h4>
        </div>
        

        <div class="">
            {{$tables}}
        </div>
    </div>
    
</body>
</html>