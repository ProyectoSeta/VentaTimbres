<!DOCTYPE html>
<html>
<head>
    <title>PDF Template</title>
    <style>
        *{
            font-family: "Reddit Sans", sans-serif;
            font-size:12px
            
        }
        @page {
            size: 7.5cm 14cm;
            margin: 0.5cm 0.5cm; /* 2cm arriba y abajo, 3cm a los lados */
        }

        @media all {
            div.saltopagina{
                display: none;
            }
        }
        
        @media print{
            div.saltopagina{
                display:block;
                page-break-before:always;
            }
        }

        
        
        .custom-container {
            border: 1px solid #000;
            padding: 16px;
            text-align: center;
        }
        .custom-logo {
            width: 100%;
        }
        .custom-title {
            margin: 16px 0;
        }
        .custom-info {
            text-align: left;
        }
        .custom-item {
            display: flex;
            flex-direction: column;
            margin: 8px 0;
        }
        .custom-bold {
            font-weight: 600;
            font-size: 1.25rem;
        }
        .custom-copy {
            margin: 16px 0;
            font-weight: bold;
            color: red;
        }
        .custom-footer {
            margin: 16px 0;
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



    </style>
</head>
<body>
    
        
        @foreach ($timbres as $timbre)
            @for ($i = 1; $i < 3; $i++)
            <div class="container saltopagina">
                <div class="text-center" style="margin-bottom: 9px; margin-top: 25%; font-size:10px;">
                    TIMBRE FISCAL ELECTRONICO<br/>
                    PLANILLAS DE PAGO<br/>
                    FORMA 14 - TFE<br/>
                    PARA ABONAR A LA CUENTA DE:<br/>
                    GOBIERNO BOLIVARIANO DEL ESTADO ARAGUA
                </div>

                <div class="text-center" style="margin-bottom: 9px;">
                    <span class="text-danger fw-bold">*** CADUCA A LOS SIETE (7) DÍAS ***</span>
                </div>

                <div class="text-start" style="margin-bottom: 9px;">
                    <div class="d-flex flex-column my-2">
                        <span>SERIAL: </span>
                        <span class="fw-bold fs-5">{{$timbre->serial}}</span>
                    </div>
                    <div class="d-flex flex-column my-2">
                        <span>CI/RIF: </span>
                        <span class="fw-bold fs-5">{{$timbre->ci}}</span>
                    </div>
                    <div class="d-flex flex-column my-2">
                        <span>NOMBRE/RAZÓN: </span>
                        <span class="fw-bold fs-5">{{$timbre->nombre}}</span>
                    </div>
                    <div class="d-flex flex-column my-2">
                        <span>FECHA DE EMISIÓN: </span>
                        <span class="fw-bold fs-5">{{$timbre->fecha}}</span>
                    </div>
                    <div class="d-flex flex-column my-2">
                        <span>ENTE</span>
                        <span class="fw-bold fs-5">{{$timbre->ente}}</span>
                    </div>
                    <div class="d-flex flex-column my-2">
                        <span>MONTO EN BS.: </span>
                        <span class="fw-bold fs-5">{{$timbre->bs}}</span>
                    </div>
                    @if ($timbre->capital == false)
                        <div class="d-flex flex-column my-2">
                            <span>UCD: </span>
                            <span class="fw-bold fs-5">{{$timbre->ucd}}</span>
                        </div>
                    @endif
                    
                </div>

                <div class="text-center">
                    <img src="{{asset($timbre->qr)}}" alt="" style="width: 60%; margin-top: 9px; margin-bottom: 9px;">
                    <!-- <img src="../public/assets/qrcode_TFE1.png" alt="" style="width: 70%; margin-top: 9px; margin-bottom: 9px;"> -->
                </div>

                @if ($i == 1)
                    <!-- ORIGINAL -->
                    <div class="text-center" style="margin-bottom: 9px;">
                        <span class="text-danger fw-bold">--------- ORIGINAL ----------</span>
                    </div>
                @else
                    <!-- COPIA -->
                    <div class="text-center" style="margin-bottom: 9px;">
                        <span class="text-danger fw-bold">--------- COPIA ----------</span>
                    </div>
                @endif

                <div class="text-center" style="font-size:10px;">
                    SERVICIO TRIBUTARIO DEL ESTADO ARAGUA (SETA)<br/>
                </div>
            </div>    
            @endfor
        @endforeach
        

    
        
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
    <script type="text/javascript">
        
        $(document).ready(function () {
            /////////////   MODAL EXENCION TAQUILLA
            window.print();

            setTimeout('Volver();',2000);


            
        });

        function Volver(){
            window.location.href = "{{ route('venta')}}";
        }

    </script>
</body>

</html>