@extends('adminlte::page')

@section('title', 'Libros')

@section('content_header')
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>
@stop

@section('content')
    <div class="container rounded-4 p-3" style="background-color:#ffff;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-3 text-navy fw-bold titulo">Libros de Control <span class="text-secondary fs-4">| Historial</span></h3>
        </div>

        @if ($userTipo == 'sp')
            <div class="table-responsive" style="font-size:12.7px">
                <table id="example" class="table display border-light-subtle text-center table-sm" style="width:100%; font-size:12.7px">
                    <thead class="bg-primary border-light-subtle">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Mes</th>
                            <th scope="col">Año</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($x as $libro)
                            @php
                                $meses = ['','ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO','JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];
                                $mes_bd = $libro->mes;
                                $mes_libro = $meses[$mes_bd];


                            @endphp
                            <tr class="ver_libro">
                                <td>{{$libro->id_libro}}</td>
                                <td>{{$mes_libro}}</td>
                                <td>{{$libro->year}}</td>
                                
                                <td>
                                    <a href="{{ route('detalle_libro.index', ['mes' =>$libro->mes, 'year' =>$libro->year, 'sujeto' =>$libro->id_sujeto]) }}" class="btn btn-primary btn-sm px-3 rounded-4 " mes="{{$libro->mes}}" year="{{$libro->year}}" >
                                        <!-- <i class='bx bx-show-alt fs-5 me-1'></i> -->
                                        <span>Ver Libro</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        @else
            <div class="table-reponsive" style="font-size:14px">
                <table class="table align-middle mb-0 border-light-subtle table-sm table-hover" id="example" style="width:100%; font-size:13px">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>Contribuyente</th>
                            <th>Sin Declarar</th>
                            <th>Opción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($x as $sp)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img
                                            src="{{asset('assets/user2.png')}}"
                                            alt=""
                                            style="width: 45px; height: 45px"
                                            class="rounded-circle"
                                        />
                                    </div>
                                </td>
                                <td>
                                    <p class="fw-bold text-navy mb-1">{{$sp->razon_social}}</p>
                                    <p class="text-muted mb-0">
                                        <a class="info_sujeto" role="button" id_sujeto='{{ $sp->id_sujeto }}' data-bs-toggle="modal" data-bs-target="#modal_info_sujeto">{{$sp->rif_condicion}} - {{$sp->rif_nro}}</a>
                                    </p>
                                </td>
                                <td>
                                    @if ($sp->sin_declarar == 0)
                                        <span class="badge bg-success-subtle border border-success-subtle text-success-emphasis rounded-pill" style="font-size:14px">{{$sp->sin_declarar}}</span>
                                    @elseif ($sp->sin_declarar < 50)
                                        <span class="badge bg-warning-subtle border border-warning-subtle text-warning-emphasis rounded-pill" style="font-size:14px">{{$sp->sin_declarar}} libro(s)</span>
                                    @elseif ($sp->sin_declarar >= 50)
                                        <span class="badge bg-danger-subtle border border-danger-subtle text-danger-emphasis rounded-pill" style="font-size:14px">{{$sp->sin_declarar}} libro(s)</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('libro_contribuyente.index', ['sujeto' =>$sp->id_sujeto]) }}" class="btn btn-primary btn-sm px-3 rounded-4" style="font-size:12.7px">
                                        <span>Libros</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        @endif


        
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

    <!-- ********* APERTURA DE LIBRO: NUEVA GUIA ******** -->
    <div class="modal" id="modal_registro_guia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 d-flex align-items-center" id="exampleModalLabel" style="color: #0072ff">
                        <i class='bx bx-barcode fs-1 me-2'></i>
                        Registro de Guía
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4" style="font-size:14px;" id="content_registro_guia">

                    
                </div>  <!-- cierra modal-body -->
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ********* DETALLES: DECLARACIÓN ******** -->
    <div class="modal" id="modal_detalle_declaracion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_detalle_declaracion">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
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
            $('#example').DataTable({
                "order": [[ 0, "desc" ]],
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
            });
        
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

            ///////MODAL: INFO DECLARAR EXTEMPORANEAS
            $(document).on('click','.detalle_declaracion', function(e) { 
                e.preventDefault(e); 
                var libro = $(this).attr('id_libro');
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("libros.detalles") }}',
                    data: {libro:libro},
                    success: function(response) {    
                        console.log(response);  
                        
                        $('#content_detalle_declaracion').html(response);

                        
                    },
                    error: function() {
                    }
                });
            });
           

        });
            
    </script>
@stop