@extends('adminlte::page')

@section('title', 'Historial - Declaraciones')

@section('content_header')
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
@stop

@section('content')
    <div class="container rounded-4 p-3" style="background-color:#ffff;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-3 text-navy fw-bold titulo">Declaraciones <span class="text-secondary fs-4">| Historial</span></h3>
        </div>
        @if ($userTipo == 'sp')
            <div class="table-responsive" style="font-size:14px">
                <table id="example" class="table text-center border-light-subtle" style="font-size:13px">
                    <thead class="border-light-subtle">
                        <th>#</th>
                        <!-- <th>Contribuyente</th>
                        <th>R.I.F.</th> -->
                        <th>Período</th>
                        <th>Tipo de Declaración</th>
                        <th>Referencia</th>
                        <th>Estado</th>
                        <th class="w-25">Nota</th>
                    </thead>
                    <tbody> 
                        @foreach ($x as $dclr)
                            <tr>
                                <td>{{$dclr->id_declaracion}}</td>
                                <!-- <td>{{$dclr->razon_social}}</td>
                                <td>
                                    <a class="info_sujeto" role="button" id_sujeto='{{ $dclr->id_sujeto }}' data-bs-toggle="modal" data-bs-target="#modal_info_sujeto">{{$dclr->rif_condicion}}-{{$dclr->rif_nro}}</a>
                                </td> -->
                                @php
                                    $meses = ['','ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO','JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];
                                    $mes_bd = $dclr->mes_declarado;
                                    $mes_libro = $meses[$mes_bd];
                                @endphp
                                <td class="fw-bold">{{$mes_libro}} {{$dclr->year_declarado}}</td>
                                <td>{{$dclr->nombre_tipo}}</td>
                                <td>
                                    @php
                                        if($dclr->referencia == null){
                                    @endphp
                                        <span class="fw-bold text-danger">SIN ACTIVIDAD ECONÓMICA</span>    
                                    @php
                                        }else{
                                    @endphp
                                        <a target="_blank" class="ver_pago" href="{{ asset($dclr->referencia) }}">Ver</a>
                                    @php
                                        }
                                    @endphp
                                </td>
                                <td>
                                    @php
                                        if($dclr->nombre_clf == 'Verificado'){
                                    @endphp
                                        <div class="d-flex align-items-center justify-content-center badge bg-success-subtle border text-success rounded-pill px-2 py-2" style="font-size:13px;">
                                            <i class='bx bx-check-circle fs-6 me-2'></i>
                                            <span>{{$dclr->nombre_clf}}</span>
                                        </div>
                                    @php
                                        }elseif($dclr->nombre_clf == 'Verificando'){
                                    @endphp
                                        <div class="d-flex align-items-center justify-content-center badge bg-secondary-subtle text-muted rounded-pill px-2 py-2" style="font-size:13px;">
                                            <i class="bx bx-error-circle fs-6 me-2"></i>
                                            <span>{{$dclr->nombre_clf}}</span>
                                        </div>
                                    @php
                                        }else{
                                    @endphp
                                        <div class="d-flex align-items-center justify-content-center badge bg-danger-subtle text-danger rounded-pill px-2 py-2" style="font-size:13px;">
                                        <i class='bx bx-x-circle fs-6 me-2'></i>
                                            <span>{{$dclr->nombre_clf}}</span>
                                        </div>
                                    @php
                                        }
                                    @endphp
                                </td>
                                <td>
                                    @php
                                        if($dclr->observaciones != ''){
                                            $cadena = $dclr->observaciones;
                                            $longitud = 50;
                                            $subcadena = substr($cadena, 0, $longitud).' ...';
                                    @endphp  
                                        <span class="text-secondary-emphasis ver_nota" role="button" data-bs-toggle="modal" data-bs-target="#modal_ver_nota" id_declaracion="{{$dclr->id_declaracion}}">{{$subcadena}}</span>
                                    @php   
                                        }else{
                                    @endphp  
                                        <span class="fst-italic text-secondary">Sin Nota</span>
                                    @php 
                                        }
                                    @endphp
                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody> 
                    
                </table>
                
            </div>
        @else
            <div class="table-reponsive" style="font-size:14px">
                <table class="table align-middle mb-0 border-light-subtle table-sm table-hover" id="example2" style="width:100%; font-size:13px">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>Contribuyente</th>
                            <th>Ultima Declaración (Libros)</th>
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
                                    @if ($sp->mes_declarado == 0)
                                        <span class="badge bg-secondary-subtle border border-secondary-subtle text-secondary-emphasis rounded-pill" style="font-size:14px">Sin Declaraciones</span>
                                    @else
                                        <span class="badge bg-success-subtle border border-success-subtle text-success-emphasis rounded-pill" style="font-size:14px">{{$sp->mes_declarado}} - {{$sp->year_declarado}}</span>   
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('declaraciones_contribuyente.index', ['sujeto' =>$sp->id_sujeto]) }}" class="btn btn-primary btn-sm px-3 rounded-4" >
                                        <span>Declaraciones</span>
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
    <!-- ********* VER NOTA ******** -->
    <div class="modal" id="modal_ver_nota" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" id="content-edit-cantera">
                <div class="modal-body px-3 py-4" id="content_ver_nota">
                    <div class="py-4 d-flex flex-column text-center">
                        <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                        <span class="text-muted">Cargando, por favor espere un momento...</span>
                    </div>
                </div>                   
            </div>  
        </div>  <!-- cierra modal-dialog -->
    </div>

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

            $('#example2').DataTable(
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
           ///////MODAL: VER NOTA
            $(document).on('click','.ver_nota', function(e) { 
                e.preventDefault(e); 
                var declaracion = $(this).attr('id_declaracion');
                // alert(cantera);
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("historial_declaraciones.nota") }}',
                    data: {declaracion:declaracion},
                    success: function(response) {
                        // alert(response);                 
                        $('#content_ver_nota').html(response);
                    },
                    error: function() {
                    }
                });
            });

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

        });


       
    </script>
  
@stop