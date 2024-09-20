@extends('adminlte::page')

@section('title', 'Estado - Solicitudes')

@section('content_header')
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
@stop

@section('content')
    <div class="container rounded-4 p-3 pt-0" style="background-color:#ffff; font-size:12.7px">
        <div class="d-flex justify-content-center my-2 mb-4">
            <div class="text-cente">
                <h3 class="mb-1 text-navy fw-bold titulo">Estado de Solicitudes <span class="text-secondary fs-4">| Activas - Rechazadas</span></h3>
            </div>
        </div>

        <!-- UL: OPCIONES DE LOS ESTADOS -->
        <ul class="nav nav-tabs d-flex justify-content-center">
            <li class="nav-item">
                <a class="nav-link active" id="list-verificando-list" data-bs-toggle="list" href="#list-verificando" role="tab" aria-controls="list-verificando">
                    <div class="d-flex gap-1 py-1 pe-3">
                        <div class="d-flex align-items-end flex-between-center">
                            <i class='bx bx-search-alt-2 fs-2'></i>
                        </div>
                        <div class="ms-2">
                            <h6 class="mb-1 text-700 text-nowrap text-secondary" style="font-size:13px">Control</h6>
                            <h6 class="mb-0 lh-1 fw-bold text-secondary-emphasis">Verificando</h6>
                        </div>
                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="list-negadas-list" data-bs-toggle="list" href="#list-negadas" role="tab" aria-controls="list-negadas">
                    <div class="d-flex gap-1 py-1 pe-3">
                        <div class="d-flex align-items-end flex-between-center">
                            <i class='bx bx-error-circle fs-2'></i>
                        </div>
                        <div class="ms-2">
                            <h6 class="mb-1 text-700 text-nowrap text-secondary" style="font-size:13px">Solicitudes</h6>
                            <h6 class="mb-0 lh-1 fw-bold text-secondary-emphasis">Negadas</h6>
                        </div>
                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="list-proceso-list" data-bs-toggle="list" href="#list-proceso" role="tab" aria-controls="list-proceso">
                    <div class="d-flex gap-1 py-1 pe-3">
                        <div class="d-flex align-items-end flex-between-center">
                        <i class='bx bx-loader fs-2'></i>
                        </div>
                        <div class="ms-2">
                            <h6 class="mb-1 text-700 text-nowrap text-secondary" style="font-size:13px">Imprenta</h6>
                            <h6 class="mb-0 lh-1 fw-bold text-secondary-emphasis">En Proceso</h6>
                        </div>
                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="list-retirar-list" data-bs-toggle="list" href="#list-retirar" role="tab" aria-controls="list-retirar">
                    <div class="d-flex gap-1 py-1 pe-3">
                        <div class="d-flex align-items-end flex-between-center">
                            <i class='bx bx-package fs-2'></i>
                        </div>
                        <div class="ms-2">
                            <h6 class="mb-1 text-700 text-nowrap text-secondary" style="font-size:13px">Solicitudes</h6>
                            <h6 class="mb-0 lh-1 fw-bold text-secondary-emphasis">Por Retirar</h6>
                        </div>
                    </div>
                </a>
            </li>
        </ul>


        <!-- CONTENTS DE LOS UL - ESTADOS -->
        <div class="tab-content py-3" id="nav-tabContent">
            <!-- CONTENIDO: VERIFICANDO  -->
            <div class="tab-pane fade show active" id="list-verificando" role="tabpanel" aria-labelledby="list-verificando-list">
                <div class="table-responsive" style="font-size:12.7px">
                    <table id="verificando" class="table border-light-subtle text-center" style="width:100%; font-size:12.7px">
                        <thead class="bg-primary border-light-subtle">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Razón Social</th>
                                    <th scope="col">R.I.F</th>
                                    <th scope="col">Cantera</th>
                                    <th scope="col">Solicitud</th>
                                    <th scope="col">Emisión</th>
                                </tr>
                        </thead>
                        <tbody>
                            @foreach ($verificando as $v)
                                <tr>
                                        <td>{{$v->id_solicitud}}</td>
                                        <td>{{$v->razon_social}}</td>
                                        <td>
                                            <a class="info_sujeto" role="button" id_sujeto='{{ $v->id_sujeto }}' data-bs-toggle="modal" data-bs-target="#modal_info_sujeto">{{$v->rif_condicion}}-{{$v->rif_nro}}</a>
                                        </td>
                                        <td class="fw-bold text-navy">{{$v->nombre}}</td>
                                        <td>
                                            <a class="text-primary info_talonario" role="button" id_solicitud="{{$v->id_solicitud}}" data-bs-toggle="modal" data-bs-target="#modal_info_talonario">Ver</a>
                                        </td>
                                        <td class="text-secondary">{{$v->fecha}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> <!-- cierra tab-pane VERIFICANDO  -->


            <!-- CONTENIDO: NEGADAS  -->
            <div class="tab-pane fade" id="list-negadas" role="tabpanel" aria-labelledby="list-negadas-list">
                <div class="table-responsive" style="font-size:12.7px">
                    <table id="negadas" class="table border-light-subtle text-center" style="width:100%; font-size:12.7px">
                        <thead class="bg-primary border-light-subtle">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Razón Social</th>
                                    <th scope="col">R.I.F</th>
                                    <th scope="col">Cantera</th>
                                    <th scope="col">Solicitud</th>
                                    <th scope="col">Info.</th>
                                    <th scope="col">Emisión</th>
                                    <th scope="col">Opción</th>
                                </tr>
                        </thead>
                        <tbody>
                            @foreach ($negadas as $n)
                                <tr>
                                    <td>{{$n->id_solicitud}}</td>
                                    <td>{{$n->razon_social}}</td>
                                    <td>
                                        <a class="info_sujeto" role="button" id_sujeto='{{ $n->id_sujeto }}' data-bs-toggle="modal" data-bs-target="#modal_info_sujeto">{{$n->rif_condicion}}-{{$n->rif_nro}}</a>
                                    </td>
                                    <td class="fw-bold text-navy">{{$n->nombre}}</td>
                                    <td>
                                        <a class="text-primary info_talonario" role="button" id_solicitud="{{$n->id_solicitud}}" data-bs-toggle="modal" data-bs-target="#modal_info_talonario">Ver</a>
                                    </td>
                                    <td>
                                        <span role="button" class="badge text-bg-danger p-2 py-1 d-flex justify-content-center align-items-center solicitud_denegada" style="font-size: 12px;" data-bs-toggle="modal" data-bs-target="#modal_info_denegada" id_solicitud='{{ $n->id_solicitud }}'><i class='bx bx-x-circle fs-6 me-2'></i>Negada</span>
                                    </td>
                                    <td class="text-secondary">{{$n->fecha}}</td>
                                    <td>
                                        <span class="badge delete_solicitud" style="background-color: #ed0000;" role="button" id_cantera="{{$n->id_cantera}}" id_solicitud="{{$n->id_solicitud}}">
                                            <i class="bx bx-trash-alt fs-6"></i>
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> <!-- cierra tab-pane NEGADAS  -->


            <!-- CONTENIDO: EN PROCESO  -->
            <div class="tab-pane fade" id="list-proceso" role="tabpanel" aria-labelledby="list-proceso-list">
                <div class="table-responsive" style="font-size:12.7px">
                    <table id="proceso" class="table border-light-subtle text-center" style="width:100%; font-size:12.7px">
                        <thead class="bg-primary border-light-subtle">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Razón Social</th>
                                    <th scope="col">R.I.F</th>
                                    <th scope="col">Cantera</th>
                                    <th scope="col">Detalles</th>
                                    <th scope="col">Emisión</th>
                                </tr>
                        </thead>
                        <tbody>
                            @foreach ($proceso as $p)
                                <tr>
                                        <td>{{$p->id_solicitud}}</td>
                                        <td>{{$p->razon_social}}</td>
                                        <td>
                                            <a class="info_sujeto" role="button" id_sujeto='{{ $p->id_sujeto }}' data-bs-toggle="modal" data-bs-target="#modal_info_sujeto">{{$p->rif_condicion}}-{{$p->rif_nro}}</a>
                                        </td>
                                        <td class="fw-bold text-navy">{{$p->nombre}}</td>
                                        <td>
                                            <a class="text-primary detalle_solicitud" role="button" id_solicitud="{{$p->id_solicitud}}" data-bs-toggle="modal" data-bs-target="#modal_detalle_solicitud">Ver</a>
                                        </td>
                                        <td class="text-secondary">{{$p->fecha}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> <!-- cierra tab-pane EN PROCESO  -->


            <!-- CONTENIDO: RETIRAR  -->
            <div class="tab-pane fade" id="list-retirar" role="tabpanel" aria-labelledby="list-retirar-list">
                <div class="table-responsive" style="font-size:12.7px">
                    <table id="retirar" class="table border-light-subtle text-center" style="width:100%; font-size:12.7px">
                        <thead class="bg-primary border-light-subtle">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Razón Social</th>
                                    <th scope="col">R.I.F</th>
                                    <th scope="col">Cantera</th>
                                    <th scope="col">Detalles</th>
                                    <th scope="col">Emisión</th>
                                </tr>
                        </thead>
                        <tbody>
                            @foreach ($retirar as $r)
                                <tr>
                                        <td>{{$r->id_solicitud}}</td>
                                        <td>{{$r->razon_social}}</td>
                                        <td>
                                            <a class="info_sujeto" role="button" id_sujeto='{{ $r->id_sujeto }}' data-bs-toggle="modal" data-bs-target="#modal_info_sujeto">{{$r->rif_condicion}}-{{$r->rif_nro}}</a>
                                        </td>
                                        <td class="fw-bold text-navy">{{$r->nombre}}</td>
                                        <td>
                                            <a class="text-primary detalle_solicitud" role="button" id_solicitud="{{$r->id_solicitud}}" data-bs-toggle="modal" data-bs-target="#modal_detalle_solicitud">Ver</a>
                                        </td>
                                        <td class="text-secondary">{{$r->fecha}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> <!-- cierra tab-pane RETIRAR  -->
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

    <!-- ********* VER INFO TALONARIO(S) ******** -->
    <div class="modal fade" id="modal_info_talonario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_info_talonarios">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- *********INFO SOLICITUD DENEGADA ******** -->
    <div class="modal" id="modal_info_denegada" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_info_denegada">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ********* DETALLE SOLICITUD******** -->
    <div class="modal fade" id="modal_detalle_solicitud" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_detalle_solicitud">
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
            $('#verificando').DataTable({   
                ordering: false,  
                "order": [[ 0, "asc" ]],
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

            $('#negadas').DataTable({   
                ordering: false,  
                "order": [[ 0, "asc" ]],
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

            $('#proceso').DataTable({   
                ordering: false,  
                "order": [[ 0, "asc" ]],
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

            $('#retirar').DataTable({   
                ordering: false,  
                "order": [[ 0, "asc" ]],
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

            ///////MODAL: INFO TALONARIOS
            $(document).on('click','.info_talonario', function(e) { 
                e.preventDefault(e); 
                var id = $(this).attr('id_solicitud');
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("solicitud.talonarios") }}',
                    data: {id:id},
                    success: function(response) {    
                        // console.log(response);          
                        $('#content_info_talonarios').html(response);
                    },
                    error: function() {
                    }
                });
            });

            ///////MODAL: INFO SOLICITUD DENEGADA
            $(document).on('click','.solicitud_denegada', function(e) { 
                e.preventDefault(e); 
                var solicitud = $(this).attr('id_solicitud');
                // alert(cantera);
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("estado.info_denegada") }}',
                    data: {solicitud:solicitud},
                    success: function(response) {
                        // console.log(response);               
                        $('#content_info_denegada').html(response);
                    },
                    error: function() {
                    }
                });
            });

            //////ELIMINAR SOLICITUD
            $(document).on('click','.delete_solicitud', function(e) { 
                e.preventDefault(e); 
                var solicitud = $(this).attr('id_solicitud');
                var cantera = $(this).attr('id_cantera');
                
                if (confirm("¿ESTA SEGURO QUE DESEA ELIMINAR LA SOLICITUD CON EL CÓDIGO:   " + solicitud + "?")) {
                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        type: 'POST',
                        url: '{{route("solicitud.destroy") }}',
                        data: {solicitud:solicitud,cantera:cantera},
                        success: function(response) {
                        //    console.log(response);
                            if (response.success){
                                alert("SOLICITUD ELIMINADA EXITOSAMENTE");
                                window.location.href = "{{ route('solicitud')}}";
                            } else{
                                alert("SE HA PRODUCIDO UN ERROR AL ELIMINAR LA SOLICITUD");
                            }              
                        },
                        error: function() {
                        }
                    });
                }else{
                }
            });

            ///////MODAL: DETALLE SOLICITUD
            $(document).on('click','.detalle_solicitud', function(e) { 
                e.preventDefault(e); 
                var solicitud = $(this).attr('id_solicitud');
                // alert(solicitud);
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("estado_solicitud.detalles") }}',
                    data: {solicitud:solicitud},
                    success: function(response) {           
                        // alert(response);
                        // console.log(response);
                        $('#content_detalle_solicitud').html(response);
                    },
                    error: function() {
                    }
                });
            });


        });


    </script>
  
@stop