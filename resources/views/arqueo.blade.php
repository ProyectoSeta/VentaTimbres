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
                    <span class="display-6 fw-bold text-navy">Recaudación | Taquilla</span>
                    <div class="text-muted fs-4">{{$hoy_view}}</div>
                </div>
                <div class="col-md-6">
                    <div class="display-6 fw-semibold"><span class="text-body-tertiary me-2">Total</span> 15.000,00 Bs.</div>
                </div>
            </div>

            {{-- DETALLE TOTAL --}}
            <div class="bg_arqueo" style="background-image: url({{asset('assets/fondo2.png')}});">
                <div class="row d-flex align-items-center text-center">
                    <div class="col-md-6">
                        <h5 class="fw-semibold ">Punto</h5>
                        <h4 class="">11.800,00 Bs.</h4>
                    </div>
                    {{-- <div class="col-md-4">
                        <canvas id="pct_venta"></canvas>
                    </div> --}}
                    <div class="col-md-6">
                        <div class="">
                            <h5 class="">Efectivo</h5>
                            <h4 class="">3.200,00 Bs.</h4>
                        </div>
                        <div class="">
                            <table class="table table-sm table-borderless lh-1">
                                <tr>
                                    <th>En taquilla:</th>
                                    <td>500,00 Bs.</td>
                                </tr>
                                <tr>
                                    <th>En boveda:</th>
                                    <td>2.700,00 Bs.</td>
                                </tr>
                            </table>
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
                            <div class="fs-4 fw-semibold text-secondary">13.000,00 Bs.</div>  
                            <span class="text-muted">252 Unidades</span>
                            <a href="">Ver detalles</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="bg-body-tertiary me-md-3 px-3 px-md-5 py-4 pb-5 text-center overflow-hidden rounded-4">
                        <div class="">
                            <h2 class="fs-4 fw-semibold">Estampillas | <span class="fs-6">Timbre Movil</span></h2>
                        </div>
                        <div class="d-flex flex-column">
                            <div class="fs-4 fw-semibold text-secondary">2.000,00 Bs.</div>  
                            <span class="text-muted">50 Unidades</span>
                            <a href="">Ver detalles</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive py-3 pt-5 px-4"  style="font-size:12.7px">
                <table class="table table-sm border-light-subtle text-center" id="table_venta_taquilla"  style="font-size:13px">
                    <thead>
                        <tr>
                            <th>Hora</th>
                            <th>Contribuyente</th>
                            <th>Total U.C.D.</th>
                            <th>Total Bs.</th>
                            <th>Timbres</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ventas as $venta)
                            <tr>
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
                                    <span class="fw-bold text-muted">{{$venta->total_ucd}} U.C.D.</span>
                                </td>
                                <td>
                                    <span class="fw-bold text-navy">{{$venta->total_bolivares}} Bs.</span>
                                </td>
                                <td>
                                    <a href="" class="timbres" venta="{{$venta->id_venta}}" data-bs-toggle="modal" data-bs-target="#modal_timbres">Ver</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


            

        </section>
    </main>





    {{-- MODALES --}}
    <!-- INFO CONTRIBUYENTE EXENCIONES -->
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="content_timbres">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

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
        });
    </script>
  
@stop