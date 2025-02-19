@extends('adminlte::page')

@section('title', 'Exenciones')

@section('content_header')
    
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <!-- <script src="{{asset('vendor/sweetalert.js') }}"></script> -->
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>

    <!-- <img src="{{asset('assets/bf-1.svg')}}" class="w-100" alt="..."> -->
@stop

@section('content')
    
    <div class="container rounded-4 p-3 px-0" style="background-color:#ffff;">
        


        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-3 text-navy titulo fw-bold">Exenciones <span class="text-secondary fs-4">| Casos abiertos</span></h3>
            <div class="mb-3">
                <button type="button" class="btn bg-navy rounded-pill px-3 btn-sm fw-bold d-flex align-items-center" id="new_exencion" data-bs-toggle="modal" data-bs-target="#modal_new_exencion">
                    <i class='bx bx-plus fw-bold fs-6 pe-2'></i>
                    <span>Nueva</span>
                </button>
            </div>
        </div>



        <!-- ESTADOS DE EXENCIONES -->
        <ul class="nav nav-tabs d-flex justify-content-center">
            <li class="nav-item">
                <a class="nav-link active" id="list-proceso-list" data-bs-toggle="list" href="#list-proceso" role="tab" aria-controls="list-proceso">
                    <div class="d-flex gap-1 py-1 pe-3">
                        <div class="d-flex align-items-end flex-between-center">
                            <i class='bx bx-loader fs-2'></i>
                        </div>
                        <div class="ms-2">
                            <h6 class="mb-1 text-700 text-nowrap text-secondary" style="font-size:13px">Asignando a Taquilla</h6>
                            <h6 class="mb-0 lh-1 fw-bold text-secondary-emphasis">En Proceso 
                                @if ($count_proceso->total != 0)
                                    <span class="badge text-bg-primary ms-2">{{$count_proceso->total}}</span>
                                @endif
                            </h6>
                        </div>
                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="list-emitidos-list" data-bs-toggle="list" href="#list-emitidos" role="tab" aria-controls="list-emitidos">
                    <div class="d-flex gap-1 py-1 pe-3">
                        <div class="d-flex align-items-end flex-between-center">
                            <i class='bx bx-receipt fs-2'></i> 
                        </div>
                        <div class="ms-2">
                            <h6 class="mb-1 text-700 text-nowrap text-secondary" style="font-size:13px">Retirar de Taquilla</h6>
                            <h6 class="mb-0 lh-1 fw-bold text-secondary-emphasis">Emitidos
                                @if ($count_emitidos->total != 0)
                                    <span class="badge text-bg-primary ms-2">{{$count_emitidos->total}}</span>
                                @endif
                            </h6>
                        </div>
                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="list-recibidos-list" data-bs-toggle="list" href="#list-recibidos" role="tab" aria-controls="list-recibidos">
                    <div class="d-flex gap-1 py-1 pe-3">
                        <div class="d-flex align-items-end flex-between-center">
                            <i class='bx bx-package fs-2'></i>
                        </div>
                        <div class="ms-2">
                            <h6 class="mb-1 text-700 text-nowrap text-secondary" style="font-size:13px">Para entregar al Contribuyente</h6>
                            <h6 class="mb-0 lh-1 fw-bold text-secondary-emphasis">Recibidos
                                @if ($count_recibidos->total != 0)
                                    <span class="badge text-bg-primary ms-2">{{$count_recibidos->total}}</span>
                                @endif
                            </h6>
                        </div>
                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="list-pendientes-list" data-bs-toggle="list" href="#list-pendientes" role="tab" aria-controls="list-pendientes">
                    <div class="d-flex gap-1 py-1 pe-3">
                        <div class="d-flex align-items-end flex-between-center">
                            <i class='bx bx-error-circle fs-2 text-warning'></i>
                        </div>
                        <div class="ms-2">
                            <h6 class="mb-1 text-700 text-nowrap text-secondary" style="font-size:13px">Por verificación de Pago</h6>
                            <h6 class="mb-0 lh-1 fw-bold text-secondary-emphasis">Pendientes
                                @if ($count_pendientes->total != 0)
                                    <span class="badge text-bg-primary ms-2">{{$count_pendientes->total}}</span>
                                @endif
                            </h6>
                        </div>
                    </div>
                </a>
            </li>
        </ul>







        <!-- contenido - nav - option -->
        <div class="tab-content py-3" id="nav-tabContent">
            <!-- CONTENIDO: EXENCIONES EN PROCESO  -->
            <div class="tab-pane fade show active" id="list-proceso" role="tabpanel" aria-labelledby="list-proceso-list">
                <div class="table-response" style="font-size:12.7px">
                    <table id="proceso_exenciones" class="table align-middle border-light-subtle text-center " style="font-size:12.7px">
                        <thead class="bg-primary border-light-subtle">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Fecha Emisión</th>
                                    <th scope="col">Contribuyente</th>
                                    <th scope="col">Total U.C.D.</th>
                                    <th scope="col">Exención (%)</th>
                                    <th scope="col">Detalles</th>
                                    <th scope="col">Taquillero</th>
                                    <th scope="col">Estado</th>
                                    <!-- <th scope="col">Opcion</th> -->
                                </tr>
                        </thead>
                        <tbody>
                            @foreach ($proceso as $process)
                                <tr>
                                    <td>{{$process->id_exencion}}</td>
                                    <td><span class="text-muted fst-italic">{{$process->fecha}}</span></td>
                                    <td>
                                        <a class="info_sujeto_exencion d-flex flex-column" role="button" exencion="{{$process->id_exencion}}" sujeto="{{$process->key_contribuyente}}" data-bs-toggle="modal" data-bs-target="#modal_info_sujeto_exencion">
                                            <span>{{$process->nombre_razon}}</span>
                                            <span>{{$process->identidad_condicion}}-{{$process->identidad_nro}}</span>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="text-navy fw-bold">{{$process->total_ucd}} U.C.D.</span>                                    
                                    </td>
                                    <td>
                                        <span class="badge bg-primary-subtle border border-primary-subtle text-primary-emphasis rounded-pill" style="font-size:12.7px">{{$process->porcentaje_exencion}}%</span>
                                    </td>
                                    <td>
                                        <a class="detalle_solicitud" exencion="" data-bs-toggle="modal" data-bs-target="#modal_detalles_exencion">Ver</a>
                                    </td>
                                    <td>
                                        @if ($process->key_taquilla == NULL)
                                            <span class="text-secondary fst-italic" title="En espera de la asignación de Taquillero">Sin Asignar</span>
                                        @else
                                            <a href="#" class="taquilla" taquilla="{{$process->key_taquilla}}" data-bs-toggle="modal" data-bs-target="#modal_info_taquilla">Taquilla ID {{$process->key_taquilla}} </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($process->key_taquilla == NULL)
                                            <span class="badge bg-dark-subtle border border-dark-subtle text-dark-emphasis rounded-pill" style="font-size:12.7px">
                                                <div class="d-flex align-items-center">
                                                    <i class='bx bx-time-five me-1 fs-6'></i> 
                                                    <span>En espera </span>
                                                </div>
                                            </span>
                                        @else
                                            <span class="badge bg-info-subtle border border-info-subtle text-info-emphasis rounded-pill" style="font-size:12.7px">
                                                <div class="d-flex align-items-center">
                                                    <i class='bx bx-user-check me-1 fs-6' ></i>    
                                                    <span>Taquillero Asignado</span>
                                                </div>
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
               </div>
            </div>


            <!-- CONTENIDO: TIMBRE(S) DE EXENCIONES EMITIDOS-->
            <div class="tab-pane fade" id="list-emitidos" role="tabpanel" aria-labelledby="list-emitidos-list">
                <div class="table-response" style="font-size:12.7px">
                    <table id="emitidos_exenciones" class="table align-middle border-light-subtle text-center " style="font-size:12.7px">
                        <thead class="bg-primary border-light-subtle">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Fecha Emision</th>
                                    <th scope="col">Contribuyente</th>
                                    <th scope="col">Total U.C.D.</th>
                                    <th scope="col">Exención (%)</th>
                                    <th scope="col">Detalles</th>
                                    <th scope="col">Taquillero</th>
                                    <th scope="col">Fecha Impresión</th>   
                                    <th scope="col">Opción</th>                             
                                </tr>
                        </thead>
                        <tbody>
                            @foreach ($emitidos as $emitido)
                                <tr>
                                    <td>{{$emitido->id_exencion}}</td>
                                    <td><span class="text-muted fst-italic">{{$emitido->fecha}}</span></td>
                                    <td>
                                        <a class="info_sujeto_exencion d-flex flex-column" role="button" exencion="{{$emitido->id_exencion}}" sujeto="{{$emitido->key_contribuyente}}" data-bs-toggle="modal" data-bs-target="#modal_info_sujeto_exencion">
                                            <span>{{$emitido->nombre_razon}}</span>
                                            <span>{{$emitido->identidad_condicion}}-{{$emitido->identidad_nro}}</span>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="text-navy fw-bold">{{$emitido->total_ucd}} U.C.D.</span>                                    
                                    </td>
                                    <td>
                                        <span class="badge bg-primary-subtle border border-primary-subtle text-primary-emphasis rounded-pill" style="font-size:12.7px">{{$emitido->porcentaje_exencion}}%</span>
                                    </td>
                                    <td>
                                        <a class="detalle_solicitud" exencion="" data-bs-toggle="modal" data-bs-target="#modal_detalles_exencion">Ver</a>
                                    </td>
                                    <td>
                                        <a href="#" class="taquilla" taquilla="{{$emitido->key_taquilla}}" data-bs-toggle="modal" data-bs-target="#modal_info_taquilla">Taquilla ID {{$emitido->key_taquilla}} </a>
                                    </td>
                                    <td>
                                        <span class="text-muted fst-italic">
                                            @php
                                                echo date("d-m-Y h:i A",strtotime($emitido->fecha_impresion)); 
                                            @endphp
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary exencion_recibida d-inline-flex align-items-center" exencion="{{$emitido->id_exencion}}" type="button" data-bs-toggle="modal" data-bs-target="#modal_exencion_recibida">
                                           <i class='bx bxs-chevron-right'></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


            <!-- CONTENIDO: TIMBRE(S) DE EXENCIONES RECIBIDOS -->
            <div class="tab-pane fade" id="list-recibidos" role="tabpanel" aria-labelledby="list-recibidos-list">
                <div class="table-response" style="font-size:12.7px">
                    <table id="recibidos_exenciones" class="table align-middle border-light-subtle text-center " style="font-size:12.7px">
                        <thead class="bg-primary border-light-subtle">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Fecha Emision</th>
                                    <th scope="col">Contribuyente</th>
                                    <th scope="col">Total U.C.D.</th>
                                    <th scope="col">Exención (%)</th>
                                    <th scope="col">Detalles</th>
                                    <th scope="col">Taquillero</th>
                                    <th scope="col">Fecha Impresión</th>   
                                    <th scope="col">Opción</th>                                     
                                </tr>
                        </thead>
                        <tbody>
                            @foreach ($recibidos as $recibido)
                                <tr>
                                    <td>{{$recibido->id_exencion}}</td>
                                    <td><span class="text-muted fst-italic">{{$recibido->fecha}}</span></td>
                                    <td>
                                        <a class="info_sujeto_exencion d-flex flex-column" role="button" exencion="{{$recibido->id_exencion}}" sujeto="{{$recibido->key_contribuyente}}" data-bs-toggle="modal" data-bs-target="#modal_info_sujeto_exencion">
                                            <span>{{$recibido->nombre_razon}}</span>
                                            <span>{{$recibido->identidad_condicion}}-{{$recibido->identidad_nro}}</span>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="text-navy fw-bold">{{$recibido->total_ucd}} U.C.D.</span>                                    
                                    </td>
                                    <td>
                                        <span class="badge bg-primary-subtle border border-primary-subtle text-primary-emphasis rounded-pill" style="font-size:12.7px">{{$recibido->porcentaje_exencion}}%</span>
                                    </td>
                                    <td>
                                        <a class="detalle_solicitud" exencion="" data-bs-toggle="modal" data-bs-target="#modal_detalles_exencion">Ver</a>
                                    </td>
                                    <td>
                                        <a href="#" class="taquilla" taquilla="{{$recibido->key_taquilla}}" data-bs-toggle="modal" data-bs-target="#modal_info_taquilla">Taquilla ID {{$recibido->key_taquilla}} </a>
                                    </td>
                                    <td>
                                        <span class="text-muted fst-italic">
                                            @php
                                                echo date("d-m-Y h:i A",strtotime($recibido->fecha_impresion)); 
                                            @endphp
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-success timbre_entregado d-inline-flex align-items-center" exencion="{{$recibido->id_exencion}}" type="button" data-bs-toggle="modal" data-bs-target="#modal_timbre_entregado">
                                            <i class='bx bx-check'></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


            <!-- CONTENIDO: TIMBRE(S) DE EXENCIONES RECIBIDOS -->
            <div class="tab-pane fade" id="list-pendientes" role="tabpanel" aria-labelledby="list-pendientes-list">
                <div class="table-response" style="font-size:12.7px">
                    <table id="pendientes_exenciones" class="table align-middle border-light-subtle text-center " style="font-size:12.7px">
                        <thead class="bg-primary border-light-subtle">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Fecha Emision</th>
                                    <th scope="col">Contribuyente</th>
                                    <th scope="col">Total U.C.D.</th>
                                    <th scope="col">Exención (%)</th>
                                    <th scope="col">Detalles</th>
                                    <th scope="col">Taquillero</th>
                                    <th scope="col">Entregado el</th>   
                                    <th scope="col">Verificar Pago</th>                                     
                                </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendientes as $pendiente)
                                <tr>
                                    <td>{{$pendiente->id_exencion}}</td>
                                    <td><span class="text-muted fst-italic">{{$pendiente->fecha}}</span></td>
                                    <td>
                                        <a class="info_sujeto_exencion d-flex flex-column" role="button" exencion="{{$pendiente->id_exencion}}" sujeto="{{$pendiente->key_contribuyente}}" data-bs-toggle="modal" data-bs-target="#modal_info_sujeto_exencion">
                                            <span>{{$pendiente->nombre_razon}}</span>
                                            <span>{{$pendiente->identidad_condicion}}-{{$pendiente->identidad_nro}}</span>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="text-navy fw-bold">{{$pendiente->total_ucd}} UCD</span>                                    
                                    </td>
                                    <td>
                                        <span class="badge bg-primary-subtle border border-primary-subtle text-primary-emphasis rounded-pill" style="font-size:12.7px">{{$pendiente->porcentaje_exencion}}%</span>
                                    </td>
                                    <td>
                                        <a class="detalle_solicitud" exencion="" data-bs-toggle="modal" data-bs-target="#modal_detalles_exencion">Ver</a>
                                    </td>
                                    <td>
                                        <a href="#" class="taquilla" taquilla="{{$pendiente->key_taquilla}}" data-bs-toggle="modal" data-bs-target="#modal_info_taquilla">Taquilla ID {{$pendiente->key_taquilla}} </a>
                                    </td>
                                    <td>
                                        <span class="text-muted fst-italic">
                                            @php
                                                echo date("d-m-Y h:i A",strtotime($pendiente->fecha_impresion)); 
                                            @endphp
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-success verificar_pago d-inline-flex align-items-center" exencion="{{$pendiente->id_exencion}}" type="button" data-bs-toggle="modal" data-bs-target="#modal_verificar_pago">
                                            <i class='bx bx-receipt'></i>
                                        </button>
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
    <!-- ************ NUEVA EXENCION ************** -->
    <div class="modal fade" id="modal_new_exencion" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="content_new_exencion">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- INFO CONTRIBUYENTE EXENCIONES -->
    <div class="modal fade" id="modal_info_sujeto_exencion" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_info_sujeto_exencion">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ********* INFO SUJETO ******** -->
    <div class="modal" id="modal_info_taquilla" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" id="html_info_taquilla">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ********* EXENCION RECIBIDA ******** -->
    <div class="modal" id="modal_exencion_recibida" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_exencion_recibida">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ********* TIMBRE ENTREGADO (EXENCION) ******** -->
    <div class="modal" id="modal_timbre_entregado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_timbre_entregado">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ********* VERIFICAR PAGO ******** -->
    <div class="modal" id="modal_verificar_pago" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_verificar_pago">
                <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <!-- <i class="bx bx-archive" ></i> -->
                        <i class='bx bx-receipt fs-1 text-secondary'></i>
                        <h1 class="modal-title fs-5 text-navy fw-bold">Verificación de Pago</h1>
                        <h5 class="modal-title text-muted" id="" style="font-size:14px">Timbre entregado a <span class="fw-bold">Jurídico</span></h5>
                    </div>
                </div>
                <div class="modal-body" style="font-size:13px">
                    <form action="">
                        
                        <div class="d-flex justify-content-center mt-3 mb-3">
                            <button type="button" class="btn btn-secondary btn-sm me-2" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success btn-sm" exencion="'.$exencion.'" id="btn_exencion_recibida">Aceptar</button>
                        </div> 
                    </form>
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
    </script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
    <script src="{{ asset('jss/datatable.min.js') }}" defer ></script>
    <script src="{{ asset('jss/datatable.bootstrap.js') }}" ></script>
    <script src="{{ asset('jss/toastr.js') }}" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" ></script>
   
    <script type="text/javascript">
        $(document).ready(function () {
            $('#proceso_exenciones').DataTable(
                {
                    // "order": [[ 0, "desc" ]],
                    "language": {
                        "lengthMenu": " Mostrar  _MENU_  Registros por página",
                        "zeroRecords": "No hay Exenciones En Proceso.",
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

            $('#emitidos_exenciones').DataTable(
                {
                    // "order": [[ 0, "desc" ]],
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


            $('#recibidos_exenciones').DataTable(
                {
                    // "order": [[ 0, "desc" ]],
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

            $('#pendientes_exenciones').DataTable(
                {
                    // "order": [[ 0, "desc" ]],
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
        ///////////////////////////////////////AGREGAR CAMPOS A OTRO(S) TRAMITES
            var maxFieldTramite = 3; //Input fields increment limitation
            var c = 1; //Initial field counter is 1

            $(document).on('click', '.add_button_tramite', function(e){ //Once add button is clicked
                if(c < maxFieldTramite){ //Check maximum number of input fields
                    c++; //Increment field counter
                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        type: 'POST',
                        url: '{{route("exenciones.tramites") }}',
                        success: function(response) {
                            $('.tramites').append('<div class="d-flex justify-content-center ">'+
                                        '<div class="row w-100 mt-2">'+
                                            '<div class="col-sm-3">'+
                                                '<select class="form-select form-select-sm ente" nro="'+c+'" id="ente_'+c+'">'+
                                                    response.entes+
                                                '</select>'+
                                            '</div>'+
                                            '<div class="col-sm-4">'+
                                                '<select class="form-select form-select-sm tramite" name="tramite['+c+'][tramite]" nro="'+c+'" id="tramite_'+c+'" required>'+
                                                    '<option value="">Seleccione el tramite </option>'+
                                                    response.tramites+
                                                '</select>'+
                                            '</div>'+
                                            '<div class="col-sm-2" id="div_ucd_'+c+'">'+
                                                '<input type="text" class="form-control form-control-sm ucd_tramite" id="ucd_tramite_'+c+'" nro="'+c+'" disabled>'+
                                            '</div>'+
                                            '<div class="col-sm-2">'+
                                                '<select class="form-select form-select-sm forma" nro="'+c+'" name="tramite['+c+'][forma]" id="forma_'+c+'" required>'+
                                                    '<option value="">Seleccione</option>'+
                                                '</select>'+
                                            '</div>'+
                                            '<div class="col-sm-1">'+
                                                '<a  href="javascript:void(0);" class="btn remove_button_tramite" nro="'+c+'">'+
                                                    '<i class="bx bx-x fs-4"></i>'+
                                                '</a>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'); // Add field html
                        },
                        error: function() {
                        }
                    });
                }
            });

            $(document).on('click', '.remove_button_tramite', function(e){ 
                var nro =  $(this).attr('nro');
                var ente =  $('#ente_'+nro).val();

                if (ente == 4) {
                    var u = 0;
                    $(".ente").each(function(e){
                        var value = $(this).val();
                        if (value == 4) {
                            u++;
                        }
                    });

                    if (u == 1) {
                        $('#content_tamaño').addClass('d-none');
                    }
                    console.log(u);
                }


                e.preventDefault();
                $(this).parent('div').parent('div').remove(); //Remove field html
                c--; //Decrement field counter
                calcular();
            });
        ///////////////////////////////////////////////////////////////////


        //////////////////////////// CONDICIÓN SUJETO
        $(document).on('change','#condicion_sujeto', function(e) {
            e.preventDefault(); 
            var value = $(this).val(); 

            $('#identidad_condicion option').remove();

            if (value == "9" || value == "10") {
                $('#identidad_condicion').append('<option>Seleccione</option>'+
                                                '<option value="V">V</option>'+
                                                '<option value="E">E</option>');
            }else{
                $('#identidad_condicion').append('<option>Seleccione</option>'+
                                                '<option value="J">J</option>'+
                                                '<option value="G">G</option>');
            }

        });

        //////////////////////////// BUSCAR CONTRIBUYENTE
        $(document).on('keyup','#identidad_nro', function(e) {
            e.preventDefault(); 
            var value = $(this).val();
            var condicion = $('#identidad_condicion').val();
            var condicion_sujeto = $('#condicion_sujeto').val();

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("venta.search") }}',
                data: {value:value,condicion:condicion,condicion_sujeto:condicion_sujeto},
                success: function(response) {
                    // console.log(response);               
                    if (response.success) {
                        $('#btns_add_contribuyente').addClass('d-none');
                        $('#nombre').val(response.nombre);
                        $('#nombre').attr('disabled', true);


                        $('.ente').attr('disabled', false);
                        $('.tramite').attr('disabled', false);
                        $('.forma').attr('disabled', false);

                        $('.add_button_tramite').removeClass('disabled');
                        $('.add_button').removeClass('disabled');

                        $('#direccion').attr('disabled', false);
                        $('#tlf_movil').attr('disabled', false);
                        $('#tlf_second').attr('disabled', false);

                        $('#metros').attr('disabled', false);
                        $('#btn_calcular_metrado').removeClass('disabled');

                        $('#solicitud_doc').attr('disabled', false);
                        $('#aprobacion_doc').attr('disabled', false);
                        $('#porcentaje').attr('disabled', false);
                        $('#tipo_pago').attr('disabled', false);


                        $('#btn_submit_exencion').removeClass('disabled');

                    }else{
                        $('#btns_add_contribuyente').removeClass('d-none');
                        $('#nombre').attr('disabled', false);
                        $('#nombre').val('');
                        
                        $('.ente').attr('disabled', true);
                        $('.tramite').attr('disabled', true);
                        $('.forma').attr('disabled', true);

                        $('.add_button_tramite').addClass('disabled');
                        $('.add_button').addClass('disabled');

                        $('#direccion').attr('disabled', true);
                        $('#tlf_movil').attr('disabled', true);
                        $('#tlf_second').attr('disabled', true);

                        $('#metros').attr('disabled', true);
                        $('#btn_calcular_metrado').addClass('disabled');

                        $('#solicitud_doc').attr('disabled', true);
                        $('#aprobacion_doc').attr('disabled', true);
                        $('#porcentaje').attr('disabled', true);
                        $('#tipo_pago').attr('disabled', true);

                        $('#sub_total').html('0');
                        $('#exencion').html('0');
                        $('#total').html('0');

                        $('#html_porcentaje').html('%');

                        $('#btn_submit_exencion').addClass('disabled');
                    }
                },
                error: function() {
                }
            });
            
            
        });

        $(document).on('change','#identidad_condicion', function(e) {
            $('#identidad_nro').val('');

            $('#btns_add_contribuyente').removeClass('d-none');
            $('#nombre').attr('disabled', false);
            $('#nombre').val('');
            
            $('.ente').attr('disabled', true);
            $('.tramite').attr('disabled', true);
            $('.forma').attr('disabled', true);

            $('.add_button_tramite').addClass('disabled');
            $('.add_button').addClass('disabled');

            $('#direccion').attr('disabled', true);
            $('#tlf_movil').attr('disabled', true);
            $('#tlf_second').attr('disabled', true);

            $('#metros').attr('disabled', true);
            $('#btn_calcular_metrado').addClass('disabled');

            $('#solicitud_doc').attr('disabled', true);
            $('#aprobacion_doc').attr('disabled', true);
            $('#porcentaje').attr('disabled', true);
            $('#tipo_pago').attr('disabled', true);

            $('#sub_total').html('0');
            $('#exencion').html('0');
            $('#total').html('0');

            $('#html_porcentaje').html('%');


            $('#btn_submit_exencion').addClass('disabled');
        });

        /////////////////////////// BTN REGISTRO CONTRIBUYENTE
        $(document).on('click','#btn_add_contribuyente', function(e) {
            e.preventDefault();
            var condicion_sujeto = $('#condicion_sujeto').val();
            var condicion = $('#identidad_condicion').val();
            var nro = $('#identidad_nro').val();
            var nombre = $('#nombre').val();

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("venta.add_contribuyente") }}',
                data: {condicion:condicion,nro:nro,nombre:nombre,condicion_sujeto:condicion_sujeto},
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        $('#nombre').attr('disabled', true);
                        $('#btns_add_contribuyente').addClass('d-none');
                        alert('REGISTRO DE CONTRIBUYENTE EXITOSO.');


                        $('.ente').attr('disabled', false);
                        $('.tramite').attr('disabled', false);
                        $('.forma').attr('disabled', false);

                        $('.add_button_tramite').removeClass('disabled');
                        $('.add_button').removeClass('disabled');

                        $('#direccion').attr('disabled', false);
                        $('#tlf_movil').attr('disabled', false);
                        $('#tlf_second').attr('disabled', false);

                        $('#metros').attr('disabled', false);
                        $('#btn_calcular_metrado').removeClass('disabled');

                        $('#solicitud_doc').attr('disabled', false);
                        $('#aprobacion_doc').attr('disabled', false);
                        $('#porcentaje').attr('disabled', false);
                        $('#tipo_pago').attr('disabled', false);


                        $('#btn_submit_exencion').removeClass('disabled');

                    }else{
                        if (response.nota) {
                            alert(response.nota);
                        }else{
                            alert('Disculpe, ha ocurrido un error al registar a el contribuyente.');
                        }
                        ////alert
                    }   
                },
                error: function() {
                }
            });
        });

        /////////////////////////// BTN CANCELAR REGISTRO CONTRIBUYENTE
        $(document).on('click','#btn_cancel_add_c', function(e) {
            e.preventDefault();
            $('#btns_add_contribuyente').addClass('d-none');
            $('#nombre').attr('disabled', true);

            $('#nombre').val('');
            $('#identidad_nro').val('');
        });



        /////////////////////////// MODAL NEW EXENCIÓN
        $(document).on('click','#new_exencion', function(e) {
            e.preventDefault();

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("exenciones.modal_new") }}',
                success: function(response) {
                    // console.log(response);
                    $('#content_new_exencion').html(response);
                },
                error: function() {
                }
            });
        });


        /////////////////////////// VALOR DEL TRAMITE SEGUN EL METRADO Y EL PORCENTAJE
        // METRADO
        $(document).on('click','#btn_calcular_metrado', function(e) {
            e.preventDefault();
            var condicion_sujeto =  $('#condicion_sujeto').val();
            var metros =  $('#metros').val();
            var capital =  0;

            $(".tramite").each(function(e){
                var tramite = $(this).val();
                var nro = $(this).attr('nro');

                var varios_metrado = 0;

                cal_misc(tramite,condicion_sujeto, metros,capital,nro,varios_metrado);
                
            });
        });



        ///////////////////////// CALCULAR EL TOTAL SEGUN EL PORCENTAJE DE EXENCION
        $(document).on('keyup','#porcentaje', function(e) {
            calcular();
        });


         /////////////////////// MODAL INFO SUJETO EXENCION
         $(document).on('click','.info_sujeto_exencion', function(e) {
            e.preventDefault();
            var sujeto = $(this).attr('sujeto');
            var exencion = $(this).attr('exencion');

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("exenciones.sujeto") }}',
                data: {sujeto:sujeto,exencion:exencion},
                success: function(response) {
                    console.log(response);
                    $('#content_info_sujeto_exencion').html(response);
                },
                error: function() {
                }
            });
        });

        ///////////////////////////  INFO TAQUILLA
        $(document).on('click','.taquilla', function(e) {
            e.preventDefault(); 
            var taquilla = $(this).attr('taquilla');

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("asignar.info_taquilla") }}',
                data: {taquilla:taquilla},
                success: function(response) {
                    $('#html_info_taquilla').html(response);                 
                },
                error: function() {
                }
            });
        });


        /////////////////////////// MODAL EXENCION RECIBIDA (JURIDICO)
        $(document).on('click','.exencion_recibida', function(e) {
            e.preventDefault(); 
            var exencion = $(this).attr('exencion');

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("exenciones.modal_recibido") }}',
                data: {exencion:exencion},
                success: function(response) {
                    // console.log(response);
                    $('#content_exencion_recibida').html(response);          
                },
                error: function() {
                }
            });
        });

        /////////////////////////// EXENCION RECIBIDA (JURIDICO)
        $(document).on('click','#btn_exencion_recibida', function(e) {
            e.preventDefault(); 
            var exencion = $(this).attr('exencion');

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("exenciones.recibido") }}',
                data: {exencion:exencion},
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        alert('ACTUALIZACIÓN DE ESTADO EXITOSO.');
                        window.location.href = "{{ route('exenciones')}}";
                    }else{
                        alert('Disculpe, ha ocurrido un error. Vuelva a intentarlo.');
                    }     
                },
                error: function() {
                }
            });
        });


        /////////////////////////// MODAL EXENCION ENTREGADA (CONTRIBUYENTE)
        $(document).on('click','.timbre_entregado', function(e) {
            e.preventDefault(); 
            var exencion = $(this).attr('exencion');

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("exenciones.modal_entregado") }}',
                data: {exencion:exencion},
                success: function(response) {
                    // console.log(response);
                    $('#content_timbre_entregado').html(response);          
                },
                error: function() {
                }
            });
        });

        /////////////////////////// EXENCION ENTREGADA (CONTRIBUYENTE)
        $(document).on('click','#btn_exencion_entregada', function(e) {
            e.preventDefault(); 
            var exencion = $(this).attr('exencion');

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("exenciones.entregado") }}',
                data: {exencion:exencion},
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        alert('ACTUALIZACIÓN DE ESTADO EXITOSO.');
                        window.location.href = "{{ route('exenciones')}}";
                    }else{
                        alert('Disculpe, ha ocurrido un error. Vuelva a intentarlo.');
                    }     
                },
                error: function() {
                }
            });
        });
       

          
    });


    ///////////////// ADD CAMPO FORMA 
    function forma(nro,ucd) {
        // console.log(nro+'/'+ucd);
        ///////////////////////////  ADD CAMPO FORMA(S)
        $('#forma_'+nro+' option').remove();

        if (ucd < 6) {
            $('#forma_'+nro).append('<option>Seleccione</option>'+
                        '<option value="3">TFE-14</option>'+
                        '<option value="4">Estampilla</option>');
        }else{
            $('#forma_'+nro).append('<option>Seleccione</option>'+
                        '<option value="3">TFE-14</option>');
        }

    }


    //////////////// CALCULO METRADO Y PORCENTAJE
    function cal_misc(tramite,condicion_sujeto, metros,capital,nro){
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            type: 'POST',
            url: '{{route("venta.alicuota") }}',
            data: {tramite:tramite,condicion_sujeto:condicion_sujeto,metros:metros,capital:capital},
            success: function(response) {
                console.log(response);

                if (response.success) {
                    switch(response.alicuota) {
                        case 13:
                            /// METRADO
                            $('#content_tamaño').removeClass('d-none');

                            if (response.size == 'small') {
                                $('#size').html('<p class="fs-4 fw-bold mb-0">Pequeña</p>'+
                                                '<p class="text-secondary">*Hasta 150 mts2.</p>');
                            }else if(response.size == 'medium'){
                                $('#size').html('<p class="fs-4 fw-bold mb-0">Mediana</p>'+
                                                '<p class="text-secondary">*Desde 151, Hasta 399 mts2.</p>');
                            }else if(response.size == 'large'){
                                $('#size').html('<p class="fs-4 fw-bold mb-0">Grande</p>'+
                                                '<p class="text-secondary">*Mayor a 400 mts2.</p>');
                            }else{
                                $('#size').html('');
                            }

                            $('#ucd_tramite_'+nro).val(response.valor);
                            forma(nro,response.valor);
                            calcular();
                            
                            break;
                        default:
                            alert('Disculpe, a ocurrido un error. Vuelva a intentarlo.');
                            break;
                    }
                }else{

                }
                
            },
            error: function() {
            }
        });

    }


    ////////////////// CALCULAR TOTAL
     function calcular(){
        var tramites = [];
        $('.tramite').each(function(){
            var t = $(this).val();
            tramites.push(t);
        });

        var metros = $('#metros').val();
        var porcentaje = $('#porcentaje').val();
        // var condicion_sujeto =  $('#condicion_sujeto').val();

        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            type: 'POST',
            url: '{{route("exenciones.total") }}',
            data: {tramites:tramites,metros:metros,porcentaje:porcentaje},
            success: function(response) {
                console.log(response);
                $('#sub_total').html(response.sub_total+' UCD');
                $('#exencion').html(response.exencion+' UCD');
                $('#total').html(response.total+' UCD');

                $('#html_porcentaje').html(porcentaje+'%');

                // $('.debitado').val('');
                // $('.comprobante').val('');

                // $('#debitado').html('0.00');
                // $('#vuelto').html('0.00');
                
            },
            error: function() {
            }
        });

        // console.log(tramites);
    }



    //////////////// NUEVA EXENCION
    function newExencion(){
        var formData = new FormData(document.getElementById("form_new_exencion"));
        // console.log("alo");
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url:'{{route("exenciones.nueva") }}',
            type:'POST',
            contentType:false,
            cache:false,
            processData:false,
            async: true,
            data: formData,
            success: function(response){
                console.log(response);
                if (response.success) {
                    alert('LA EXENCIÓN SE HA REGISTRADO EXITOSAMENTE.');
                    window.location.href = "{{ route('exenciones')}}";
                }else{
                    if (response.nota) {
                        alert(response.nota);
                    }else{
                        alert('Disculpe, ha ocurrido un error. Vuelva a intentarlo.');
                    }
                }
                    
            },
            error: function(error){
                
            }
        });
    }



    


    
    

    </script>


  
@stop