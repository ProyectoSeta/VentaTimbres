@extends('adminlte::page')

@section('title', 'Inventario Papel')

@section('content_header')
    
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
@stop

@section('content')
    
    <div class="container rounded-4 p-3" style="background-color:#ffff;">
        <div class="d-flex justify-content-center align-items-center mb-2">
            <h3 class="mb-3 text-navy titulo fw-bold fs-2">Estampillas | Undidad Tributaria</h3>
        </div>

        <div class="row my-5">
            <div class="col-sm-6 border-end zoom_text px-5">
                <div class="text-center">
                    <h2 class="fw-bold titulo text-nay " style="color: #004cbd"><span class="text-muted">Lote | </span>20 U.T. </h2>
                </div>
                <div class="">
                    <div class="row">
                        <div class="col-lg -8 d-flex flex-column">
                            <div class=" fs-3 text-navy fw-bold" >Disponible en Inventario</div>
                            <div class="text-secondary">Para asignar a Taquilla</div>
                        </div>
                        <div class="col-lg -4">
                            <div class="fs-1 text-primary fw-bold bg-primary-subtle text-center rounded-4  px-2">75.000 <span class="fs-5">Und.</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 px-5 zoom_text"> 
                <div class="text-center">
                    <h2 class="fw-bold titulo text-nay" style="color: #004cbd"><span class="text-muted">Lote | </span>50 U.T.</h2>
                </div>
                <div class="">
                    <div class="row">
                        <div class="col-lg -8 d-flex flex-column">
                            <div class=" fs-3 text-navy fw-bold" >Disponible en Inventario</div>
                            <div class="text-secondary">Para asignar a Taquilla</div>
                        </div>
                        <div class="col-lg -4">
                            <div class="fs-1 text-primary fw-bold bg-primary-subtle text-center rounded-4 px-2">60.000 <span class="fs-5">Und.</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="fs-4 titulo fw-semibold text-muted text-center">Asignadas a Taquillas</div>

        <div class="table-responsive" style="font-size:12.7px">
            <table id="papel_f14_emitidos" class="table text-center border-light-subtle" style="font-size:12.7px">
                <thead>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Cantidad</th>
                    <th>Desde</th>
                    <th>Hasta</th>
                    <th>Detalle</th>  <!-- fecha entrega, emitidos en ucd, user -->
                    <th>Estado</th>  
                </thead>
                <tbody id="" class="border-light-subtle"> 
                           
                </tbody> 
            </table>
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
            $('#papel_f14_emitidos').DataTable(
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


        });
    </script>

<script type="text/javascript">
    $(document).ready(function () {
        
      


    });

  


  

    

</script>


  
@stop