<!DOCTYPE html>
<html>
<head>
    <title>TFE14</title>
    <style>
        *{
            font-family: "serif", serif;
           
            
        }
        @page {
            size: 7.5cm 14cm;
            margin: 0.5cm 1.5cm 0.5cm 0.6cm; /*arriba derecha abajo izquierda */
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
        .my-2{
            margin: 3px;
        }
        .container{
             font-size:11.2px;
        }



    </style>
</head>
<body>
    
        
        @foreach ($timbres as $timbre)
            @for ($i = 1; $i < 3; $i++)
            <div class="container saltopagina">
                <div class="text-center" style="margin-bottom: 9px; margin-top: 100px;">
                    TIMBRE FISCAL ELECTRONICO<br/>
                    PLANILLAS DE PAGO<br/>
                    FORMA 14 - TFE<br/>
                    PARA ABONAR A LA CUENTA DE:<br/>
                    GOBIERNO BOLIVARIANO DEL ESTADO ARAGUA
                    <br/>...................................................................
                </div>


                <!-- SERIAL IMG -->

                <div class="text-center">
                    <img src="{{asset($timbre->barra)}}" alt="" style="width: 220px; margin-top: 9px; margin-bottom: 9px;">
                </div>
                

                <div class="text-start" style="margin-bottom: 9px;">
                    <div class="my-2" style="font-size:12.5px;">
                        <span class="fw-bold">{{$timbre->serial}}</span> <span>CI/RIF: </span><span class="fw-bold fs-5">{{$timbre->ci}}</span>                     
                    </div>
                    <div class="my-2">
                        <span>FECHA DE EMISIÓN: </span> <span class="fw-bold fs-5">{{$timbre->fecha}}</span>
                    </div>
                    <div class="my-2">
                        <span style="font-size:10.6px">*** CADUCA A LOS QUINCE (15) DÍAS ***</span>
                    </div>
                    <div class="my-2">
                        <span>MONTO EN BOLIVARES: Bs. </span> <span class="fs-5">{{$timbre->bs}}</span>
                    </div>
                    <div class="my-2">
                        <span>CANTIDAD DE U.C.D.: </span> <span class="fs-5">{{$timbre->ucd}}</span>
                    </div>
                    <div class="my-2">
                        <span>ENTE: </span> <span class="fs-5" style="text-transform: uppercase;">{{$timbre->ente}}</span>
                    </div>



                    <div class="fw-bold" style="font-size:12.5px">
                        <div class="my-2">
                            SETA {{$timbre->fecha}}
                        </div>
                        <div class="my-2">
                            Monto: {{$timbre->bs}}
                        </div>
                        <div class="my-2">
                            Planilla: {{$timbre->serial}}
                        </div>
                        <div class="my-2">
                            BENIF: <br>GOBIERNO BOLIVARIANO DEL ESTADO ARAGUA
                        </div>
                    </div>
                
                </div>

                

                @if ($i == 1)
                    <!-- ORIGINAL -->
                    <div class="text-center" style="margin-bottom: 9px;">
                        <span class="">Original - Z0{{$timbre->key}}</span><br/>----------------------------------------
                    </div>
                @else
                    <!-- COPIA -->
                    <div class="text-center" style="margin-bottom: 9px;">
                        <span class="">Copia - Z0{{$timbre->key}}</span><br/>----------------------------------------
                    </div>
                @endif

                
            </div>    
            @endfor
        @endforeach
        

    
        
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
    <script type="text/javascript">
        
        $(document).ready(function () {
            /////////////   MODAL EXENCION TAQUILLA
            window.print();

            setTimeout('Volver();',1000);


            
        });

        function Volver(){
            window.close();
        }

    </script>
</body>

</html>