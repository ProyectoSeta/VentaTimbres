@extends('adminlte::page')

@section('title', 'Cierre Diario')

@section('content_header')
    
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
@stop

@section('content')
    <div class="container rounded-4 p-3 px-0">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-3 text-navy titulo fw-bold">Cierre Diario | <span class="text-secondary fs-4">{{$hoy_view}}</span></h3>
                
            </div>
            
            @if ($condicion == 'true')
                @can('cierre.registro_cierre')
                    <div class="mb-3">
                        <button type="button" id="btn_realizar_cierre" class="btn bg-navy rounded-pill px-3 btn-sm fw-bold d-flex align-items-center">
                            <span>Realizar cierre</span>
                        </button>
                    </div>
                @endcan
            @else
                <div class="text-center">
                    <div class="text-muted fst-italic mb-2">Cierre Realizado.</div>
                    <a href="{{ route('cierre_diario') }}" class="btn bg-navy rounded-pill px-3 text-center btn-sm fw-bold">
                       Ver Cierre
                    </a>
                </div>
            @endif
            
        </div>


        <div class="row">
            <div class="col-lg-12">
                <!-- TAQUILLAS APERTURADAS HOY -->
                <div class="table-responsive"  style="font-size:12.7px">
                    <table id="table_cierre_taquillas_aperturadas" class="table text-center border-light-subtle" style="font-size:13px">
                        <thead>
                            <tr>
                                <th>ID Taquilla</th>
                                <th>Ubicación</th>
                                <th>Taquillero</th>
                                <th>Hora Apertura</th>
                                <th>Apertura Taquillero</th>
                                <th>Cierre Taquilla</th>
                                @can('cierre.arqueo')
                                    <th>Arqueo</th>
                                @endcan
                            </tr> 
                        </thead>
                        <tbody>
                            @foreach ($aperturas as $apertura)
                                <tr>
                                    <td>{{$apertura->id_taquilla}}</td>
                                    <td>{{$apertura->ubicacion}}</td>
                                    <td>{{$apertura->taquillero}}</td>
                                    <td>
                                        <span class="badge bg-primary-subtle border border-primary-subtle text-primary-emphasis rounded-pill" style="font-size:12.7px">{{$apertura->hora_apertura}}</span>
                                    </td>
                                    <td>
                                        @if ($apertura->apertura_taquillero == null)
                                            <span class="fst-italic fw-bold text-muted">Taquillero sin Aperturar.</span>
                                        @else
                                            <span class="badge bg-info-subtle border border-info-subtle text-info-emphasis rounded-pill" style="font-size:12.7px">{{$apertura->apertura_taquillero}}</span>                                            
                                        @endif
                                    </td>
                                    <td>
                                        @if ($apertura->cierre_taquilla == null)
                                            <span class="fst-italic fw-bold text-muted">Sin cierrar.</span>
                                        @else
                                            <span class="badge bg-secondary-subtle border border-secondary-subtle text-secondary-emphasis rounded-pill" style="font-size:12.7px">{{$apertura->cierre_taquilla}}</span> 
                                        @endif
                                    </td>
                                    @can('cierre.arqueo')
                                        <td>
                                            @if ($apertura->cierre_taquilla == null)
                                                <span class="fst-italic fw-bold text-muted">Sin cierrar.</span>
                                            @else
                                                <a href="{{ route('cierre.arqueo', ['id' => $apertura->id_taquilla, 'fecha' => $hoy]) }}">Ver</a>
                                            @endif
                                        </td>
                                    @endcan
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="">
                <!-- ESTADO DE TAQUILLAS -->

            </div>
        </div>



        

    </div>






<!-- {{-- ********************************************* MODALES ***********************************************--}} -->
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
<!-- {{-- **************************************************************************************************--}}s -->



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
            $('#table_cierre_taquillas_aperturadas').DataTable(
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
            /////////////////////// COMPROBAR: REALIZAR CIERRE
            $(document).on('click','#btn_realizar_cierre', function(e) {
                e.preventDefault();
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("cierre.comprobar") }}',
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            var taquillas = response.taquillas;

                            $.ajax({
                                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                type: 'POST',
                                url: '{{route("cierre.registro_cierre") }}',
                                data: {taquillas:taquillas},
                                success: function(response) {
                                    console.log(response);
                                    if (response.success) {
                                        alert('CIERRE DIARIO EXITOSO');
                                        window.location.href = "{{ route('cierre_diario')}}";
                                    }else{
                                        alert('Disculpe, ha ocurrido un error. Vuelva a intentarlo.');
                                        window.location.href = "{{ route('cierre')}}";
                                    }
                                },
                                error: function() {
                                }
                            });
                            // 
                        }else{
                            alert(response.nota);
                        }
                    },
                    error: function() {
                    }
                });
            });
 

        });
    </script>
  
@stop