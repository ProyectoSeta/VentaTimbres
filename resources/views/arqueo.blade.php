@extends('adminlte::page')

@section('title', 'Arqueo Taquilla')

@section('content_header')
    
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
@stop

@section('content')
    <main>
        <section id="" class="py-4">
            <!-- RECAUDACION HOY -->
            <div class="row text-center d-flex align-items-center my-3 mb-5"  >
                <div class="col-md-6">
                    <span class="display-6 fw-bold text-navy">Recaudación | TAQ{{$id_taquilla}}</span>
                    <div class="text-muted fs-4">{{$hoy_view}}</div>
                </div>
                <div class="col-md-6">
                    <div class="display-6 fw-bold text-navy"><span class="text-body-tertiary me-3">Total</span>@php echo(number_format($arqueo->recaudado, 2, ',', '.')) @endphp Bs.</div>
                </div>
            </div>

            {{-- DETALLE TOTAL --}}
            <div class="bg_arqueo" style="background-image: url({{asset('assets/fondo2.png')}});">
                <div class="row d-flex align-items-center text-center mb-5">
                    <div class="col-md-4">
                        <h5 class="fw-bold fs-3">Punto</h5>
                        <h4 class="fw-semibold">@php echo(number_format($arqueo->punto, 2, ',', '.')) @endphp Bs.</h4>
                        @can('arqueo.cierre_punto')
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modal_cierre_punto" id="cierre_punto"  fecha="{{$fecha}}" taquilla="{{$id_taquilla}}">Cierre de Punto</a>
                        @endcan
                    </div>

                    <div class="col-md-4">
                        <h5 class="fw-bold fs-3">Transferencia</h5>
                        <h4 class="fw-semibold">@php echo(number_format($arqueo->transferencia, 2, ',', '.')) @endphp Bs.</h4>
                        @can('arqueo.cierre_punto')
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modal_cierre_cuenta" id="cierre_cuenta"  fecha="{{$fecha}}" taquilla="{{$id_taquilla}}">Cierre de Cuenta</a>
                        @endcan
                    </div>
                    
                    <div class="col-md-4">
                        <div class="">
                            <h5 class="fw-bold fs-3">Efectivo</h5>
                            <h4 class="fw-semibold">@php echo(number_format($arqueo->efectivo, 2, ',', '.')) @endphp Bs.</h4>
                        </div>
                        <div class="">
                            <table class="table table-sm table-borderless lh-1 pb-0 mb-0">
                                <tr>
                                    <th>En taquilla:</th>
                                    <td>@php echo(number_format($efectivo_taq, 2, ',', '.')) @endphp Bs.</td>
                                </tr>
                                <tr>
                                    <th>En boveda:</th>
                                    <td>@php echo(number_format($bs_boveda, 2, ',', '.')) @endphp Bs.</td>
                                </tr>
                            </table>
                            @if ($fondo_caja != 0 || $fondo_caja != NULL)
                                <span class="text-end fw-bold"  style="font-size:13.4px"><span class="text-danger">IMPORTANTE: </span>- @php echo(number_format($fondo_caja, 2, ',', '.')) @endphp Bs. por Fondo de Caja.</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- DETALLE ESTAMPILLA - TFE --}}
            <div class="row g-0">
                <div class="col-md-6">
                    <div class="bg-body-tertiary me-md-3 px-3 px-md-5 py-4 pb-5 text-center overflow-hidden rounded-4">
                        <div class="">
                            <h2 class="fs-4 text-navy fw-semibold">FORMA 14 | <span class="fs-6 text-muted">Timbre Fiscal Electrónico</span></h2>
                        </div>
                        <div class="d-flex flex-column">
                            <div class="fs-4 fw-semibold text-secondary">@php echo(number_format($arqueo->recaudado_tfe, 2, ',', '.')) @endphp Bs.</div>  
                            <span class="text-muted">{{$arqueo->cantidad_tfe}} Unidades</span>
                            @can('arqueo.detalle_forma')
                                <a href="#" class="detalle_forma" data-bs-toggle="modal" data-bs-target="#modal_detalle_formas" forma="3" fecha="{{$fecha}}" taquilla="{{$id_taquilla}}">Ver detalles</a>
                            @endcan
                            
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="bg-body-tertiary me-md-3 px-3 px-md-5 py-4 pb-5 text-center overflow-hidden rounded-4">
                        <div class="">
                            <h2 class="fs-4  text-navy fw-semibold">Estampillas | <span class="fs-6 text-muted">Timbre Movil</span></h2>
                        </div>
                        <div class="d-flex flex-column">
                            <div class="fs-4 fw-semibold text-secondary">@php echo(number_format($arqueo->recaudado_est, 2, ',', '.')) @endphp Bs.</div>  
                            <span class="text-muted">{{$arqueo->cantidad_est}} Unidades</span>
                            @can('arqueo.detalle_forma')
                                <a href="#" class="detalle_forma" data-bs-toggle="modal" data-bs-target="#modal_detalle_formas" forma="4" fecha="{{$fecha}}" taquilla="{{$id_taquilla}}">Ver detalles</a>
                            @endcan
                            
                        </div>
                    </div>
                </div>
            </div>


            <!-- BTN DESCARGAR REPORTE -->
            @can('pdf_cierre_taquilla')
                <div class="d-flex justify-content-center align-items-center flex-column">
                    <div class="fs-5 fw-semibold titulo text-navy mb-2">Descargar Reporte</div>
                    <a href="{{ route('pdf_cierre_taquilla', ['id' => $arqueo->id] ) }}" class="btn btn-sm btn-secondary d-inline-flex align-items-center"  role="button">
                        Reporte
                    </a>
                </div>
            @endcan
            

            <div class="table-responsive py-3 pt-5 px-4"  style="font-size:12.7px">
                <table class="table table-sm border-light-subtle text-center" id="table_venta_taquilla"  style="font-size:13px">
                    <thead>
                        <tr>
                            <th>ID Venta</th>
                            <th>Hora</th>
                            <th>Contribuyente</th>
                            <th>Total U.C.D.</th>
                            <th>Total Bs.</th>
                            @can('arqueo.detalle_venta')
                                <th>Detalle</th>
                            @endcan
                            @can('arqueo.timbres')
                                <th>Timbres</th>
                            @endcan
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ventas as $venta)
                            <tr>
                                <td class="text-muted">{{$venta->id_venta}}</td>
                                @php
                                    $hora = date("h:i A",strtotime($venta->hora));
                                @endphp
                                <td>{{$hora}}</td>
                                <td>
                                    <a class="info_sujeto" role="button" sujeto="{{$venta->key_contribuyente}}" data-bs-toggle="modal" data-bs-target="#modal_info_sujeto">
                                        <span>{{$venta->identidad_condicion}} - {{$venta->identidad_nro}}</span>
                                    </a>
                                </td>
                                <td>
                                    @if ($venta->total_ucd == 0)
                                        <span class="fst-italic text-muted">No Aplica</span>
                                    @else
                                        <span class="fw-bold text-muted">{{$venta->total_ucd}} U.C.D.</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="fw-bold text-navy">@php echo(number_format($venta->total_bolivares, 2, ',', '.')) @endphp Bs.</span>
                                </td>
                                @can('arqueo.detalle_venta')
                                    <td>
                                        <a role="button" class="detalle_venta" venta="{{$venta->id_venta}}" data-bs-toggle="modal" data-bs-target="#modal_detalle_venta">Ver</a>
                                    </td>
                                @endcan
                                
                                @can('arqueo.timbres')
                                    <td>
                                        <a role="button" class="timbres" venta="{{$venta->id_venta}}" data-bs-toggle="modal" data-bs-target="#modal_timbres">Ver</a>
                                    </td>
                                @endcan
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


            

        </section>
    </main>





{{-- ********************************************* MODALES ***********************************************--}}
    <!-- INFO CONTRIBUYENTE -->
    <div class="modal fade" id="modal_info_sujeto" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_info_sujeto">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- DETALLE TIMBRES -->
    <div class="modal fade" id="modal_timbres" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-l">
            <div class="modal-content" id="content_timbres">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- DETALLE VENTA -->
    <div class="modal fade" id="modal_detalle_venta" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="content_detalle_venta">
                
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- DETALLE FORMAS -->
    <div class="modal fade" id="modal_detalle_formas" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="content_detalle_formas">
                
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- CIERRE PUNTO -->
    <div class="modal fade" id="modal_cierre_punto" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_cierre_punto">
                                
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- CIERRE CUENTA (TRANSFERENCIAS) -->
    <div class="modal fade" id="modal_cierre_cuenta" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_cierre_cuenta">
                                
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>
{{-- **************************************************************************************************--}}



@stop

@section('footer')        
@stop



@section('css')
    {{-- <script src="path/to/chartjs/dist/chart.umd.js"></script> --}}
    <link rel="stylesheet" href="{{asset('assets/style.css')}}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
@stop

@section('js')
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
    <script src="{{ asset('jss/toastr.js') }}" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" ></script>
    <script src="{{ asset('jss/datatable.min.js') }}" defer ></script>
    <script src="{{ asset('jss/datatable.bootstrap.js') }}" ></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#table_venta_taquilla').DataTable(
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
            /////////////////////// MODAL INFO SUJETO
            $(document).on('click','.info_sujeto', function(e) {
                e.preventDefault();
                var sujeto = $(this).attr('sujeto');

                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("arqueo.contribuyente") }}',
                    data: {sujeto:sujeto},
                    success: function(response) {
                        console.log(response);
                        $('#content_info_sujeto').html(response);
                    },
                    error: function() {
                    }
                });
            });

            /////////////////////// TIMBRES
            $(document).on('click','.timbres', function(e) {
                e.preventDefault();
                var venta = $(this).attr('venta');

                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("arqueo.timbres") }}',
                    data: {venta:venta},
                    success: function(response) {
                        console.log(response);
                        $('#content_timbres').html(response);
                    },
                    error: function() {
                    }
                });
            });

            /////////////////////// DETALLE VENTA
            $(document).on('click','.detalle_venta', function(e) {
                e.preventDefault();
                var venta = $(this).attr('venta');

                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("arqueo.detalle_venta") }}',
                    data: {venta:venta},
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            $('#content_detalle_venta').html(response.html);
                        }else{
                            alert('Disculpe, vuelva a cargar la pagina.');
                        }
                        
                    },
                    error: function() {
                    }
                });
            });

            /////////////////////// MODAL DETALLE FORMA class="detalle_forma"
            $(document).on('click','.detalle_forma', function(e) {
                e.preventDefault();
                var forma = $(this).attr('forma');
                var fecha = $(this).attr('fecha');
                var taquilla = $(this).attr('taquilla');

                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("arqueo.detalle_forma") }}',
                    data: {forma:forma,fecha:fecha,taquilla:taquilla},
                    success: function(response) {
                        console.log(response);
                        $('#content_detalle_formas').html(response);
                        $('#table_detalle_forma').DataTable(
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
                    },
                    error: function() {
                    }
                });
            });

            /////////////////////// CIERRE PUNTO
            $(document).on('click','#cierre_punto', function(e) {
                e.preventDefault();
                var taquilla = $(this).attr('taquilla');
                var fecha = $(this).attr('fecha');

                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("arqueo.cierre_punto") }}',
                    data: {taquilla:taquilla,fecha:fecha},
                    success: function(response) {
                        console.log(response);
                        $('#content_cierre_punto').html(response);
                        $('#table_cierre_punto').DataTable(
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
                    },
                    error: function() {
                    }
                });
            });


            /////////////////////// CIERRE CUENTA
            $(document).on('click','#cierre_cuenta', function(e) {
                e.preventDefault();
                var taquilla = $(this).attr('taquilla');
                var fecha = $(this).attr('fecha');

                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("arqueo.cierre_cuenta") }}',
                    data: {taquilla:taquilla,fecha:fecha},
                    success: function(response) {
                        console.log(response);
                        $('#content_cierre_cuenta').html(response);
                        $('#table_cierre_cuenta').DataTable(
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
                    },
                    error: function() {
                    }
                });
            });

        });
    </script>
  
@stop