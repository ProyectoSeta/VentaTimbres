<!DOCTYPE html>
<html>
<head>
    <title>PDF Template</title>
    <style>
        *{
            font-family: "Reddit Sans", sans-serif;
            
        }
        @page {
            margin: 0.5cm 0.5cm; /* cm arriba y abajo, cm a los lados */
        }

        
        
        .container {
            width: 100%;
            padding: 15px;
            /* break-after: page; */
            
        }

        .row {
            /* display: flex;
            flex-wrap: wrap; */
            /* margin-right: -15px;
            margin-left: -15px; */
            width: 100%;
            padding-left: 30px;
        }

        .col-8 {
            /* flex: 0 0 50%;
            max-width: 50%; */
            float: left;
            width: 50%;
        }

        .col-4 {
            /* flex: 0 0 20%;
            max-width: 20%; */
            float: left;
            width: 40%;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            margin: 0;
            padding: 0;
        }

        .input-box {
            padding: 6px;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin-top: 5px;
        }

        .text-center {
            text-align: center;
        }

        .text-danger {
            color: red;
        }

        .fw-bold {
            font-weight: bold;
        }

        .fs-3 {
            font-size: 1.25rem;
        }

        .fs-5 {
            font-size: 1rem;
        }

        .text-muted {
            color: gray;
        }
        


    </style>
</head>
<body>
    @foreach ($estampillas as $est)
        <div class="container" >
            <div class="row">
                <div class="col-8" style="font-size: 5px;">
                    <div class="form-group">
                        <label>Nombre del Solicitante</label>
                        <div class="input-box"></div>
                    </div>
                    <div class="form-group">
                        <label>No. de Identificación</label>
                        <div class="input-box"></div>
                    </div>
                    <div class="form-group">
                        <label>Concepto</label>
                        <div class="input-box"></div>
                    </div>
                    <div class="form-group">
                        <label>Fecha</label>
                        <div class="input-box"></div>
                    </div>
                    <div class="text-center" style="font-weight: bold; color: red; font-size: 1rem;  margin-top: 1px;">{{$est->serial}}</div>
                </div>
                <div class="col-4">
                    <div class="text-center">
                        <div style="font-size: 1.25rem; font-weight: bold; ">{{$est->denominacion}}</div>
                        <div style="font-size: 8px; color: gray;">Unidad de Cuenta Dinámica</div>
                        <img src="{{$est->ruta}}" alt="" style="width: 70px; margin-top: 5px;">
                    </div>
                </div>
            </div>
        </div>
        <div style="page-break-before: always;"></div>
    @endforeach
    

    
</body>
</html>