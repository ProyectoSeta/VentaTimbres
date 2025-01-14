@extends('adminlte::page')

@section('title', 'Taquillas Inventario')

@section('content_header')
    
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <!-- <script src="{{asset('vendor/sweetalert.js') }}"></script> -->
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>

    <!-- <img src="{{asset('assets/bf-1.svg')}}" class="w-100" alt="..."> -->
@stop

@section('content')
    
    <div class="container rounded-4 p-3 px-0" style="background-color:#ffff;">
       
        <div class="">
            @foreach ($taquillas as $taquilla)
                @if ($taquilla->salto == true)
                    <h2 class="text-navy fw-bold titulo mb-3 text-center"><span class="text-secondary">
                        @if ($taquilla->sede == 'Principal Maracay')
                            Sede
                        @else
                            Foránea
                        @endif
                         
                        | </span>{{$taquilla->sede}}
                    </h2>
                    <div class="row align-items-md-stretch">
                @else
                    @if ($taquilla->fin == false)
                        @if ($taquilla->cant_taquillas == 1)
                        <div class="col-lg-12 mb-5">
                            <div class="border h-100 rounded-4 d-flex justify-content-between px-3 py-3">
                                <!-- titulo -->
                                <div class="">
                                    <div class="text-navy d-flex justify-content-betwee flex-column">
                                        <h2 class="fw-bold titulo">Taquilla</h2>
                                        <h2 class="fw-bold text-primary titulo">ID 00{{$taquilla->id_taquilla}}</h2>
                                    </div>

                                    <div class="d-flex justify-content-between ">
                                        <span class="fs-6 me-1">Taquillero</span>
                                        <span class="fs-6 fw-bold text-navy">{{$taquilla->taquillero}}</span>
                                    </div>
                                </div>
                                <!-- inventario -->
                                <div class="d-flex">
                                    <div class="row d-flex justify-content-center  mb-0">
                                        <div class="col-sm-6 text-center">
                                            <h5 class="fw-bold">TFE 14</h5>
                                            <div class="border rounded-4 p-3 detalle_timbres">
                                                <h3 class="text-navy fw-bold">{{$taquilla->cantidad_tfe}}</h3>
                                                <span style="font-size:13px">Unidades</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 text-center">
                                        <h5 class="fw-bold">Estampillas</h5>
                                            <div class="border rounded-4 p-3 detalle_timbres" role="button" taquilla="{{$taquilla->id_taquilla}}" data-bs-toggle="modal" data-bs-target="#modal_detalle_timbres">
                                                <h3 class="text-navy fw-bold">{{$taquilla->cantidad_estampillas}}</h3>
                                                <span style="font-size:13px">Unidades</span>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- cierra inventario -->
                            </div><!-- cierra border -->
                        </div>  
                        @else
                        <div class="col-lg-6 mb-5">
                            <div class="border h-100 rounded-4 d-flex justify-content-between px-3 py-3">
                                <!-- titulo -->
                                <div class="">
                                    <div class="text-navy d-flex justify-content-betwee flex-column">
                                        <h2 class="fw-bold titulo">Taquilla</h2>
                                        <h2 class="fw-bold text-primary titulo">ID 00{{$taquilla->id_taquilla}}</h2>
                                    </div>

                                    <div class="d-flex justify-content-between ">
                                        <span class="fs-6 me-1">Taquillero</span>
                                        <span class="fs-6 fw-bold text-navy">{{$taquilla->taquillero}}</span>
                                    </div>
                                </div>
                                <!-- inventario -->
                                <div class="d-flex">
                                    <div class="row d-flex justify-content-center  mb-0">
                                        <div class="col-sm-6 text-center">
                                            <h5 class="fw-bold">TFE 14</h5>
                                            <div class="border rounded-4 p-3 detalle_timbres">
                                                <h3 class="text-navy fw-bold">{{$taquilla->cantidad_tfe}}</h3>
                                                <span style="font-size:13px">Unidades</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 text-center">
                                        <h5 class="fw-bold">Estampillas</h5>
                                            <div class="border rounded-4 p-3 detalle_timbres" role="button" taquilla="{{$taquilla->id_taquilla}}" data-bs-toggle="modal" data-bs-target="#modal_detalle_timbres">
                                                <h3 class="text-navy fw-bold">{{$taquilla->cantidad_estampillas}}</h3>
                                                <span style="font-size:13px">Unidades</span>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- cierra inventario -->
                            </div><!-- cierra border -->
                        </div>
                        @endif
                    @else
                        </div>
                    @endif
                @endif
            @endforeach


            </div>
        </div>

        

       
    </div>
    
    

      

    
    
<!--****************** MODALES **************************-->
    
    <!-- ************  DETALLE TIMBRES ************** -->
    <div class="modal fade" id="modal_detalle_timbres" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content" id="content_detalle_timbres">
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
    </script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
    <script src="{{ asset('jss/datatable.min.js') }}" defer ></script>
    <script src="{{ asset('jss/datatable.bootstrap.js') }}" ></script>
    <script src="{{ asset('jss/toastr.js') }}" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" ></script>
   
    <script type="text/javascript">
        $(document).ready(function () {
            $('#example').DataTable(
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
        /////////////////////////// MODAL DETALLE TIMBRES
        $(document).on('click','.detalle_timbres', function(e) {
            e.preventDefault();
            var taquilla = $(this).attr('taquilla');

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("inventario_taquillas.detalle") }}',
                data: {taquilla:taquilla},
                success: function(response) {
                    // console.log(response);
                    $('#content_detalle_timbres').html(response);
                },
                error: function() {
                }
            });
        });

              
    });


   


    

    </script>


  
@stop