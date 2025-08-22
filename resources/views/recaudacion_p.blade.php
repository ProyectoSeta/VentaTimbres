@extends('adminlte::page')

@section('title', 'Recaudación')

@section('content_header')
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
@stop

@section('content')
<main>
    <!-- SELECCION DEL MES -->
    <div class=" py-2 px-3 rounded-3" style="background: #00559fe3;">
        <div class="row">
            <div class="col-sm-6">
                <label for="mes_recaudado" class="form-label fs-6 text-white fw-semibold"><span class="text-danger">*</span> Por favor seleccione el Mes correspondiente:</label>
            </div>
            <div class="col-sm-6">
                <select class="form-select form-select-sm" aria-label="Default select example" name="" id="mes_recaudado">
                    <option selected>Open this select menu</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div>
        </div>
    </div>


    
    <!-- content -->
    <div class="" id="content_recaudacion" style="font-size:13px">
        <!-- CONTENT RECAUDACION MENSUAL -->
        <!-- TOTAL  -->
        <div class="row text-center d-flex align-items-center my-3 pt-3 mb-5 bg_arqueo" style="background-image: url({{asset('assets/fondo2.png')}});">
            <div class="col-md-6">
                <span class="display-6 fw-bold text-navy">Total Recaudado</span>
                <div class="text-muted fs-4">Julio 2025</div>  
            </div>
            <div class="col-md-6">
                <div class="display-6 fw-bold text-navy"><span class="text-body-tertiary me-3">Total</span>1.025.451,02 Bs.</div>
            </div>
        </div>

        <div class="row border-bottom pb-3">
            <div class="col-sm-6">
                <div class="text-center">
                    <div class="">
                        <div class="fs-2 text-secondary  titulo">Recaudado por<span class="text-navy fw-semibold"> Forma 14</span></div>
                    </div>
                    <div class=" fw-bold fs-1 text-navy">542.132,41 Bs.</div>
                </div>

                <div class="d-flex justify-content-center my-3">
                    <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_forma14" aria-expanded="false" aria-controls="collapse_forma14">
                        Detalles de la Recaudación
                    </button>   
                </div>
            </div>
            <div class="col-sm-6">
                <div class="text-center">
                    <div class="">
                        <div class="fs-2 text-secondary  titulo">Recaudado por<span class="text-navy fw-semibold"> Estampillas</span></div>
                    </div>
                    <div class="fw-bold fs-1 text-navy">542.132,41 Bs.</div>
                </div>

                <div class="d-flex justify-content-center my-3">
                    <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_estampillas" aria-expanded="false" aria-controls="collapse_estampillas">
                        Detalles de la Recaudación
                    </button>   
                </div>
            </div>
        </div>

        <!-- TABLES RECUADADO FORMAS-->
        <div class="">
            <!-- FORMA 14 -->
            <div class="collapse" id="collapse_forma14">
                <div class="table-responsive py-3 pt-5 px-4"  style="font-size:12.7px">
                    <table class="table table-sm border-light-subtle text-center" id="table_detalle_f14"  style="font-size:13px">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Nro. Timbre</th>
                                <th>Serial</th>
                                <th>Contribuyente</th>
                                <th>Tramite</th>
                                <th>U.C.D</th>
                                <th>Total Bs.</th>
                                <th>ID Venta</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>


            <!-- ESTAMPILLAS -->
            <div class="collapse" id="collapse_estampillas">
                <div class="table-responsive py-3 pt-5 px-4"  style="font-size:12.7px">
                    <table class="table table-sm border-light-subtle text-center" id="table_detalle_est"  style="font-size:13px">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Nro. Timbre</th>
                                <th>Serial</th>
                                <th>Contribuyente</th>
                                <th>Tramite</th>
                                <th>U.C.D</th>
                                <th>Total Bs.</th>
                                <th>ID Venta</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>






        <!-- RECAUDADO POR ENTES -->
        <div class="row text-center my-4">
            <div class="col-sm-6">
                <div class="fs-2 text-secondary  titulo">Recaudado por<span class="text-navy fw-semibold"> Entes</span></div>
            </div>
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-4">
                        <label for="" class="form-label fs-6"><span class="text-danger">* </span>Seleccione el Ente: </label>
                    </div>
                    <div class="col-8">
                        <select class="form-select form-select-sm" aria-label="Small select example">
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                </div>
            </div>


            <div id="content_ente">
                <!-- ENTE : TOTAL -->
                <div class="row text-center d-flex align-items-center my-3 pt-3 ">
                    <div class="col-md-6">
                        <span class="fs-2 fw-bold text-muted">CORPOSALUD</span>
                    </div>
                    <div class="col-md-6">
                        <div class="fs-2 fw-bold text-navy"><span class="text-body-tertiary me-3">Total</span>1.025.451,02 Bs.</div>
                    </div>
                </div>


                <div class="table-responsive py-3 pt-5 px-4"  style="font-size:12.7px">
                        <table class="table table-sm border-light-subtle text-center" id="table_detalle_ente"  style="font-size:13px">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Nro. Timbre</th>
                                    <th>Contribuyente</th>
                                    <th>Tramite</th>
                                    <th>Forma</th>
                                    <th>U.C.D</th>
                                    <th>Total Bs.</th>
                                    <th>ID Venta</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>


        </div>








        






    </div>
    

    

</main>
    
<!-- *********************************  MODALES ******************************* -->
  

<!-- ************************************************************************** -->






@stop

@section('footer')


    

  
        
@stop



@section('css')
    
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
            $('#table_detalle_f14').DataTable(
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

             $('#table_detalle_est').DataTable(
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

             $('#table_detalle_ente').DataTable(
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
  
@stop