@extends('adminlte::page')

@section('title', 'Bitácora')

@section('content_header')
    
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>

    <!-- <img src="{{asset('assets/bf-1.svg')}}" class="w-100" alt="..."> -->
@stop

@section('content')
    
    <div class="container rounded-4 p-3" style="background-color:#ffff;">
        <!-- <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-3 text-navy titulo">Bitácora</h3>
        </div> -->

        <!-- <div class="table-responsive" style="font-size:14px">
            <table id="example" class="table border-light-subtle text-center" style="font-size:13px">
                <thead class="">
                    <th>#</th>
                    <th>Usuario</th>
                    <th>Modulo</th>
                    <th>Fecha</th> 
                    <th>Accción</th>
                </thead>
                <tbody class="border-light-subtle "> 
                    
                </tbody> 
                
            </table>
            
        </div> -->

        <!-- GRAFICAS: RECAUDACIÓN ANUAL (UCD - TALONARIOS)-->
        <div class="row">
            <div class="col-xxl-12">
                <div class="card shadow-none">
                    <div class="card-header d-flex justify-content-between bg-white">
                        <span>Recaudación</span>
                        <!-- <div>
                            <input type="month" placeholder="Default input" aria-label="default input example">
                        </div> -->
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- gráfica:recaudado - año -->
                            <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12">
                                <div id="chart_recaudado_anual">
                                </div>

                            </div>
                            <!-- card: racaudado - talonarios -->
                            <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-12 col-sm-12 col-12">
                                <div class="border px-2 py-4 rounded-5 h-100 text-center">
                                    <h6 class="text-navy mb-3">Recaudado</h6>
                                    <div class="mb-5">
                                        <h2 class="text-primary">9.600</h2>
                                        <h6 class="text-secondary" style="font-size:13px">UCD</h6>
                                    </div>

                                    <div class="">
                                        <h2 class="" style="color:#319500">590</h2>
                                        <h6 class="text-secondary" style="font-size:13px">Talonarios</h6>
                                    </div>
                                </div>
                            </div>
                            <!-- gráfica:recaudado - talonarios -->
                            <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12">
                                <div id="chart_talonarios_anual">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CARD: TABLE DESCRIPCION RECAUDACIÓN ANUAL -->
        <div class="card shadow-none">
            <div class="card-body">
                <div class="row">
                    <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-7 col-sm-12 col-12">
                        <div class="table-responsive">
                            <table class="table border-light-subtle text-center table-sm" id="example" style="font-size:13px">
                                <tr>
                                    <th>Mes</th>
                                    <th>UCD Recaudado</th>
                                    <th>Talonarios Emitidos</th>
                                    <th>Año</th>
                                </tr>
                                <tr>
                                    <td>Enero</td>
                                </tr>
                                <tr>
                                    <td>Febrero</td>
                                </tr>
                                <tr>
                                    <td>Marzo</td>
                                </tr>
                                <tr>
                                    <td>Abril</td>
                                </tr>
                                <tr>
                                    <td>Mayo</td>
                                </tr>
                                <tr>
                                    <td>Junio</td>
                                </tr>
                                <tr>
                                    <td>Julio</td>
                                </tr>
                                <tr>
                                    <td>Agosto</td>
                                </tr>
                                <tr>
                                    <td>Septiembre</td>
                                </tr>
                                <tr>
                                    <td>Octubre</td>
                                </tr>
                                <tr>
                                    <td>Noviembre</td>
                                </tr>
                                <tr>
                                    <td>Diciembre</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12">
                        <div class="border px-2 py-4 rounded-5 h-100 text-center">
                            <div id="chart_nro_contribuyentes">
                            </div>

                            <div class="row mt-5">
                                <div class="col-sm-4">
                                    <div class="border py-2">
                                        <h3 class="text-primary">24</h3>
                                        <p class="mb-0 text-muted" style="font-size:14px">Privadas</p>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="border py-2">
                                        <h3 class="text-primary">12</h3>
                                        <p class="mb-0 text-muted"  style="font-size:13px">Artesanales</p>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="border py-2">
                                        <h3 class="text-primary">10</h3>
                                        <p class="mb-0 text-muted"  style="font-size:13px">Gubernamentales</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                
            </div>
        </div>

        <div class="card shadow-none">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="overflow-y-auto">

                            <div class="table-responsive">
                                <table id="contribuyentes" class="table" style="font-size:13px">
                                    <thead>
                                        <th></th>
                                        <th>Empresa</th>
                                        <th>R.I.F.</th>
                                    </thead>
                                    <tbody>
                                        <tr class="">
                                            <td class="w-25">
                                                <img src="{{asset('assets/user2.png')}}" class="img-4x rounded-circle flex-shrink-0 me-3 w-50" alt="Avatar">
                                            </td>
                                            <td>Aramica, S.A</td>
                                            <td>G-200108240</td>
                                        </tr>
                                    </tbody>
                                </table> 
                            </div>
                           
                        </div>
                    </div>
                    <div class="col-sm-8">

                    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#example').DataTable(
                {
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
                }
            );
            $('#contribuyentes').DataTable(
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

    //////////////////OPCIONES: CHART RECAUDADO UCD ANUAL
    var options_1 = {
        chart: {
            type: 'area'
        },
        dataLabels: {
            enabled: false,
        },
        series: [{
            name: 'UCD',
            data: [300,40,45,50,49,60,70,91,125,300,40,45],
        }],
        fill: {
            type: "gradient",
            gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.7,
            opacityTo: 0.9,
            stops: [0, 90, 100]
            }
        },
        xaxis: {
            categories: ['En.','Feb.','Mzo.','Abr.','My.','Jun.','Jul.','Ag.','Sept.','Oct.','Nov.','Dic.']
        }
    }

    //////////////////OPCIONES: CHART TALONARIOS ANUAL
    var options_2 = {
        chart: {
            type: 'area'
        },
        dataLabels: {
            enabled: false,
        },
        series: [{
            name: 'UCD',
            data: [300,40,45,50,49,60,70,91,125,300,40,45]
        }],
        colors: ['#319500'],
        fill: {
            type: "gradient",
            gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.7,
            opacityTo: 0.9,
            stops: [0, 90, 100]
            }
        },
        xaxis: {
            categories: ['En.','Feb.','Mzo.','Abr.','My.','Jun.','Jul.','Ag.','Sept.','Oct.','Nov.','Dic.']
        }
    }

    //////////////////OPCIONES: CHART NRO CONTRIBUYENTES (TIPOS)
    var options_3 = {
        series: [44, 55, 67],
        chart: {
        height: 300,
        type: 'radialBar',
    },
    plotOptions: {
        radialBar: {
        dataLabels: {
            name: {
            fontSize: '22px',
            },
            value: {
            fontSize: '16px',
            },
            total: {
            show: true,
            label: 'Contribuyentes',
            formatter: function (w) {
                // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
                return 249
            }
            }
        }
        }
    },
    theme: {
        palette: 'palette1' // upto palette10
    },
    labels: ['Artesanales', 'Privadas', 'Gubernamentales'],
    };


    /////////////////CHART: RECAUDADO UCD ANUAL
    var chart1 = new ApexCharts(document.querySelector("#chart_recaudado_anual"), options_1);
    /////////////////CHART:TALONARIOS ANUAL
    var chart2 = new ApexCharts(document.querySelector("#chart_talonarios_anual"), options_2);
    /////////////////CHART:TALONARIOS ANUAL
    var chart3 = new ApexCharts(document.querySelector("#chart_nro_contribuyentes"), options_3);

    chart1.render();
    chart2.render();
    chart3.render();



    $(document).ready(function () {

       
          

    });

    

</script>


  
@stop