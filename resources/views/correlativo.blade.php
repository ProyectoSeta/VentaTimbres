@extends('adminlte::page')

@section('title', 'Talonarios')

@section('content_header')
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
@stop

@section('content')

    <div class="container rounded-4 p-3" style="background-color:#ffff;">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h3 class="mb-3 text-navy fw-bold titulo">Talonarios <span class="text-secondary fs-4">| Historial </span></h3>
        </div>

        <!-- UL - CONTENIDO -->
        <ul class="nav nav-tabs d-flex justify-content-center" style="font-size:14px">
            <li class="nav-item">
                <a class="nav-link active" id="list-sp-list" data-bs-toggle="list" href="#list-sp" role="tab" aria-controls="list-sp">Solicitados</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="list-admin-list" data-bs-toggle="list" href="#list-admin" role="tab" aria-controls="list-admin">Reserva</a>
            </li>
        </ul>

        <!-- DIV CONTENTS DE LOS UL -->
        <div class="tab-content py-3" id="nav-tabContent">
            <!-- CONTENIDO: TALONARIOS REGULARES -->
            <div class="tab-pane fade show active" id="list-sp" role="tabpanel" aria-labelledby="list-sp-list">
                <div class="table-responsive" style="font-size:12.7px">
                    <table id="example" class="table text-center border-light-subtle" style="font-size:12.7px">
                        <thead class="border-light-subtle">
                            <th>#</th>
                            <th>Cantera</th>
                            <th>Nro. Solicitud</th>
                            <th>Correlativo</th>
                            <th>Reportado</th>
                            <th>R.I.F.</th>
                            <th>Empresa</th>
                            <th>Mensaje</th>
                            <th>Asignación</th>
                            <th>Estado</th>
                        </thead>
                        <tbody> 
                        @foreach ($talonarios as $talonario)
                                <tr>
                                    <td class="text-secondary">{{$talonario->id_talonario}}</td>
                                    <td>
                                        <span class="fw-bold text-navy">{{$talonario->nombre}}</span>
                                    </td>
                                    <td>{{$talonario->id_solicitud}}</td>
                                    <td>
                                        @php
                                            $desde = $talonario->desde;
                                            $hasta = $talonario->hasta;
                                            $length = 6;
                                            $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
                                            $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);
                                        @endphp
                                        <a href="#" class="info_talonario" role="button" id_talonario='{{ $talonario->id_talonario }}' data-bs-toggle="modal" data-bs-target="#modal_ver_talonario">{{$formato_desde}} - {{$formato_hasta}}</a>
                                    </td>
                                    <td>
                                        <!-- <span>{{$talonario->reportado}}%</span> -->
                                        <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="{{$talonario->reportado}}" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar" style="width: {{$talonario->reportado}}%"></div>
                                        </div>
                                    </td>
                                    
                                    <td>
                                        <a class="info_sujeto" role="button" id_sujeto='{{ $talonario->id_sujeto }}' data-bs-toggle="modal" data-bs-target="#modal_info_sujeto">{{$talonario->rif_condicion}}-{{$talonario->rif_nro}}</a>
                                    </td>
                                    <td class="text-muted">{{$talonario->razon_social}}</td>
                                    <td class="align-middle">
                                        @if ($talonario->alert == '1')
                                            <span class="alert_talonario" role="button" intervalo="{{ $talonario->intervalo }}" data-bs-toggle="modal" data-bs-target="#modal_alert_talonario">
                                                <i class='bx bx-error-circle fs-4 text-danger'></i>
                                            </span>
                                            
                                        @else
                                            <span class="text-secondary">S/M</span>
                                        @endif

                                    </td>
                                    <td>
                                        @if ($talonario->asignacion == 'Asignado')
                                            <span class="text-success">{{$talonario->asignacion}}</span>
                                        @else
                                        <span class="text-secondary">{{$talonario->asignacion}}</span>
                                        @endif
                                        
                                    </td>
                                    <td>
                                        @if ($talonario->estado == 22 && $talonario->asignacion == 'Asignado')
                                        <span class="badge d-flex py-1 align-items-center border bg-warning-subtle border-warning-subtle text-warning-emphasis rounded-pill" style="font-size:12px">
                                            <i class='bx bx-error-circle fs-6'></i>
                                            <span class="px-1">Imprimir QR</span>
                                        </span>
                                        @else
                                            @switch($talonario->estado)
                                                @case('20') <!-- Por Enviar warning -->
                                                    <span class="badge bg-warning-subtle border border-warning-subtle text-warning-emphasis rounded-pill" style="font-size:12px">Por Enviar</span>
                                                    @break
                                                @case('21') <!-- Enviado primary -->
                                                    <span class="badge bg-primary-subtle border border-primary-subtle text-primary-emphasis rounded-pill" style="font-size:12px">Enviado</span>
                                                    @break
                                                @case('22') <!-- Recibido success-->
                                                    <span class="badge bg-success-subtle border border-success-subtle text-success-emphasis rounded-pill" style="font-size:12px">Recibido</span>
                                                    @break
                                                @case('23') <!-- Retirado secondary-->
                                                    <span class="badge bg-secondary-subtle border border-secondary-subtle text-secondary-emphasis rounded-pill" style="font-size:12px">Retirado</span>
                                                    @break
                                            
                                                @default
                                                    
                                            @endswitch
                                        @endif
                                    </td>
                                </tr>
                        @endforeach
                            
                        </tbody> 
                        
                    </table>
                    
                </div>
            </div>

            <!-- CONTENIDO: TALONARIOS DE RESERVA -->
            <div class="tab-pane fade" id="list-admin" role="tabpanel" aria-labelledby="list-admin-list">
                <div class="table-responsive" style="font-size:12.7px">
                    <table id="reservas" class="table text-center border-light-subtle" style="font-size:12.7px">
                        <thead class="border-light-subtle">
                            <th>#</th>
                            <th>Correlativo</th>
                            <th>Asignado</th>
                            <th>Emisión</th>
                        </thead>
                        <tbody>
                            @foreach ($reservas as $r)
                                <tr role="button">
                                    <td class="text-secondary">{{$r->id_talonario}}</td>
                                    <td>
                                        @php
                                            $desde = $r->desde;
                                            $hasta = $r->hasta;
                                            $length = 6;
                                            $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
                                            $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);

                                            $asignado = ($r->asignado * 100)/$r->tipo_talonario;
                                        @endphp
                                        <a href="{{ route('detalle_reserva.index', ['talonario' =>$r->id_talonario]) }}">{{$formato_desde}} - {{$formato_hasta}}</a>
                                    </td>
                                    <td>
                                        <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="{{$asignado}}" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar" style="width: {{$asignado}}%">{{$asignado}}%</div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{$r->fecha}}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



        
            
                
           
            
            


        
    </div>
    
    

      

    
    
<!--****************** MODALES **************************-->
    <!-- ********* INFO SUJETO ******** -->
    <div class="modal" id="modal_info_sujeto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="html_info_sujeto">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

     <!-- ********* VER GUIAS ******** -->
     <div class="modal" id="modal_ver_talonario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content" >
                <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bxs-layer fs-1 text-muted" ></i>                    
                        <h1 class="modal-title text-navy fw-bold fs-5" id="exampleModalLabel">Datos del talonario</h1>
                    </div>
                </div>
                <div class="modal-body" style="font-size:14px" id="content_ver_talonario">
                    <div class="my-5 py-5 d-flex flex-column text-center">
                        <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                        <span class="text-muted">Cargando, por favor espere un momento...</span>
                    </div>

                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ********* VER QR ******** -->
    <div class="modal" id="modal_ver_qr" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" >
                <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class='bx bx-qr fs-1 text-muted'></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy" id="exampleModalLabel">Código QR</h1>
                    </div>
                </div>
                <div class="modal-body" style="font-size:14px" id="content_ver_qr">
                    <div class="my-5 py-5 d-flex flex-column text-center">
                        <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                        <span class="text-muted">Cargando, por favor espere un momento...</span>
                    </div>

                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>


     <!-- ********* VER EL REGISTRO DE LA GUÍA ******** -->
     <div class="modal" id="modal_content_guia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                
                <div class="row mx-3 mt-3 mb-1 d-flex align-items-center">
                    <div class="col-3 d-flex justify-content-center">
                        <img src="{{asset('assets/aragua.png')}}" alt="" width="100px">
                    </div>
                    <div class="col-6 d-flex flex-column text-center pt-4">
                        <span class="fs-6 fw-bold">GUÍA DE CIRCULACIÓN DE MINERALES NO METÁLICOS</span>
                        <span>GOBIERNO BOLIVARIANO DEL ESTADO ARAGUA SERVICIO TRIBUTARIO DE ARAGUA (SETA)</span>
                    </div>
                    <div class="col-3 d-flex justify-content-center">
                        <img src="{{asset('assets/logo_seta.png')}}" alt="" class="mt-3 ms-2" width="110px">
                    </div>
                </div>
                <div class="modal-body mx-4" style="font-size:14px" id="content_info_guia">
                    
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>


    <!-- ********* ALERT ******** -->
    <div class="modal" id="modal_alert_talonario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" >
                <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <!-- <i class="bx bx-barcode-reader fs-1" style="color:#0c82ff"  ></i>     -->
                        <i class='bx bx-error-circle bx-tada fs-1 text-danger'></i>       
                        <h1 class="modal-title fs-5" id="exampleModalLabel">IMPORTANTE</h1>
                    </div>
                </div>

                <div class="modal-body" style="font-size:14px" id="content_alert_talonario">
                    
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>
    

<!--************************************************-->

  

@stop





@section('css')
    <link rel="stylesheet" href="{{asset('assets/style.css')}}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
@stop

@section('js')
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
        const myModal = document.getElementById('myModal');
        const myInput = document.getElementById('myInput');

        myModal.addEventListener('shown.bs.modal', () => {
            myInput.focus();
        });
    </script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
    <script src="{{ asset('jss/datatable.min.js') }}" defer ></script>
    <script src="{{ asset('jss/datatable.bootstrap.js') }}" ></script>
    <script src="{{ asset('jss/toastr.js') }}" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" ></script>
   
    <script type="text/javascript">
        $(document).ready(function () {
            $('#example').DataTable(
                {
                    "language": {
                        "lengthMenu": " Mostrar  _MENU_  Registros por página",
                        "zeroRecords": "No se encontraron registros",
                        "info": "Mostrando página _PAGE_ de _PAGES_",
                        "infoEmpty": "No se encuentran Registros",
                        "infoFiltered": "(filtered from _MAX_ total records)",
                        'search':"Buscar",
                        'paginate':{
                            'next':'Siguiente',
                            'previous':'Anterior'
                        }
                    }
                }
            );

            $('#reservas').DataTable(
                {
                    "language": {
                        "lengthMenu": " Mostrar  _MENU_  Registros por página",
                        "zeroRecords": "No se encontraron registros",
                        "info": "Mostrando página _PAGE_ de _PAGES_",
                        "infoEmpty": "No se encuentran Registros",
                        "infoFiltered": "(filtered from _MAX_ total records)",
                        'search':"Buscar",
                        'paginate':{
                            'next':'Siguiente',
                            'previous':'Anterior'
                        }
                    }
                }
            );

        });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            ///////MODAL: INFO SUJETO PASIVO
            $(document).on('click','.info_sujeto', function(e) { 
                e.preventDefault(e); 
                var sujeto = $(this).attr('id_sujeto');
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("aprobacion.sujeto") }}',
                    data: {sujeto:sujeto},
                    success: function(response) {              
                        $('#html_info_sujeto').html(response);
                    },
                    error: function() {
                    }
                });
            });

            ///////MODAL: INFO TALONARIO
            $(document).on('click','.info_talonario', function(e) { 
                e.preventDefault(e); 
                var talonario = $(this).attr('id_talonario');

                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("correlativo.talonario") }}',
                    data: {talonario:talonario},
                    success: function(response) {              
                    //    console.log(response);
                            $('#content_ver_talonario').html(response);
                            $('#tableGuias').DataTable();

                       
                    },
                    error: function() {
                    }
                });
            });

            ////////////////////MODAL: INFO GUIA
            $(document).on('click','.info_guia', function(e) { 
                e.preventDefault(e); 
                var guia = $(this).attr('nro_guia');
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("correlativo.guia") }}',
                    data: {guia:guia},
                    success: function(response) { 
                        console.log(response);
                        $('#modal_ver_talonario').modal('hide');             
                        $('#modal_content_guia').modal('show');
                        
                        $('#content_info_guia').html(response);
                    },
                    error: function() {
                    }
                });
            });

            ///////MODAL: INFO TALONARIO
            $(document).on('click','.qr', function(e) { 
                e.preventDefault(e); 
                var ruta = $(this).attr('ruta');
                var talonario = $(this).attr('talonario');
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("correlativo.qr") }}',
                    data: {ruta:ruta,talonario:talonario},
                    success: function(response) {              
                        console.log(response);
                        $('#content_ver_qr').html(response);
                       
                    },
                    error: function() {
                    }
                });
            });

           

            ///////MODAL: alert talonario
            $(document).on('click','.alert_talonario', function(e) { 
                e.preventDefault(e); 
                var intervalo = $(this).attr('intervalo');

                $('#content_alert_talonario').html('<p class="text-justify text-muted"><span class="fw-bold">NOTA: </span>'+
                            'Han pasado '+intervalo+' días desde que el Contribuyente retiro el Talonario de la institución,'+ 
                            'y todavía no ha reportado ninguna guía en el Libro de Control.</p>');
            });


        });

     
    </script>


  
@stop