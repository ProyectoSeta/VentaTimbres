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
            <h2 class="text-navy fw-bold titulo mb-3 text-center"><span class="text-secondary">Sede | </span>Principal </h2>
            <div class="row col-lg-6 align-items-md-stretch">
                <div class="col">
                    <div class="border h-100 rounded-4 d-flex justify-content-between px-3 py-3">
                        <!-- titulo -->
                        <div class="">
                            <div class="text-navy d-flex justify-content-betwee flex-column">
                                <h2 class="fw-bold titulo">Taquilla</h2>
                                <h2 class="fw-bold text-primary titulo">ID 001</h2>
                            </div>

                            <div class="d-flex justify-content-between ">
                                <span class="fs-6">Taquillero</span>
                                <span class="fs-6">Victor Acosta</span>
                            </div>
                        </div>
                        <!-- inventario -->
                        <div class="d-flex">
                            <div class="row d-flex justify-content-center  mb-0">
                                <div class="col-sm-6 text-center">
                                    <h5 class="fw-bold">TFE 14</h5>
                                    <div class="border rounded-4 p-3" role="button">
                                        <h3 class="text-navy fw-bold">1222</h3>
                                        <span style="font-size:13px">Unidades</span>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-center">
                                <h5 class="fw-bold">Estampillas</h5>
                                    <div class="border rounded-4 p-3" role="button">
                                        <h3 class="text-navy fw-bold">114</h3>
                                        <span style="font-size:13px">Unidades</span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- cierra inventario -->
                    </div><!-- cierra border -->
                </div>
                <div class="col">
                    <div class="border h-100 rounded-4 d-flex justify-content-between px-3 py-3">
                        <!-- titulo -->
                        <div class="">
                            <div class="text-navy d-flex justify-content-betwee flex-column">
                                <h2 class="fw-bold titulo">Taquilla</h2>
                                <h2 class="fw-bold text-primary titulo">ID 002</h2>
                            </div>

                            <div class="d-flex justify-content-between ">
                                <span class="fs-6">Taquillero</span>
                                <span class="fs-6">Victor Acosta</span>
                            </div>
                        </div>
                        <!-- inventario -->
                        <div class="d-flex">
                            <div class="row d-flex justify-content-center  mb-0">
                                <div class="col-sm-6 text-center">
                                    <h5 class="fw-bold">TFE 14</h5>
                                    <div class="border rounded-4 p-3" role="button">
                                        <h3 class="text-navy fw-bold">1222</h3>
                                        <span style="font-size:13px">Unidades</span>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-center">
                                <h5 class="fw-bold">Estampillas</h5>
                                    <div class="border rounded-4 p-3" role="button">
                                        <h3 class="text-navy fw-bold">114</h3>
                                        <span style="font-size:13px">Unidades</span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- cierra inventario -->
                    </div><!-- cierra border -->
                </div>
            </div>
        </div>

        

       
    </div>
    
    

      

    
    
<!--****************** MODALES **************************-->
    



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
        

              
    });


   


    

    </script>


  
@stop