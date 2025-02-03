@extends('adminlte::page')

@section('title', 'Imprimir Timbre')

@section('content_header')
    
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
@stop

@section('content')
    
    <div class="container rounded-4 p-3 px-0" style="background-color:#ffff;">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-3 text-navy titulo fw-bold">Imprimir Timbre <span class="text-secondary fs-4">| Exenciones </span></h3>
        </div>


        <div class="table-response" style="font-size:12.7px">
            <table id="asignar_taq_exencion" class="table align-middle border-light-subtle text-center " style="font-size:12.7px">
                <thead class="bg-primary border-light-subtle">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Asignado</th>
                            <th scope="col">Contribuyente</th>
                            <th scope="col">Total UCD</th>
                            <th scope="col">Exención (%)</th>
                            <th scope="col">Imprimir</th>
                        </tr>
                </thead>
                <tbody>
                    @foreach ($query as $key)
                        <tr>
                            <td>{{$key->id_exencion}}</td>
                            <td><span class="text-muted fst-italic">{{$key->fecha}}</span></td>
                            <td>
                                <a class="info_sujeto_exencion d-flex flex-column" role="button" exencion="{{$key->id_exencion}}" sujeto="{{$key->key_contribuyente}}" data-bs-toggle="modal" data-bs-target="#modal_info_sujeto_exencion">
                                    <span>{{$key->nombre_razon}}</span>
                                    <span>{{$key->identidad_condicion}}-{{$key->identidad_nro}}</span>
                                </a>
                            </td>
                            <td>
                                <span class="text-navy fw-bold">{{$key->total_ucd}} UCD</span>                                    
                            </td>
                            <td>
                                <span class="badge bg-primary-subtle border border-primary-subtle text-primary-emphasis rounded-pill" style="font-size:12.7px">{{$key->porcentaje_exencion}}%</span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-secondary asignado_taquilla d-inline-flex align-items-center" exencion="" type="button" data-bs-toggle="modal" data-bs-target="#modal_venta_exencion">
                                    <i class='bx bx-printer fs-6' ></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>








         
    

        
        

       

        

       
    </div>
    
    

      

    
    
<!--****************** MODALES **************************-->
    <!-- ************ ASIGNAR TAQUILLERO ************* -->
    <div class="modal fade" id="modal_venta_exencion" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" id="content_venta_exencion">
                <div class="modal-header p-2 pt-3 ps-3">
                    <h1 class="modal-title fs-5 fw-bold text-navy">Venta | <span class="text-muted">Exención</span></h1>
                </div> 
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    <form id="form_venta" method="post" onsubmit="event.preventDefault(); venta()">
                        <!-- *************** DATOS CONTRIBUYENTE ******************-->
                        <div class="mb-2" style="font-size:13px">
                            <div class="d-flex justify-content-center">
                                <div class="row w-100">
                                    <h5 class="titulo fw-bold text-navy my-3">Contribuyente | <span class="text-secondary fs-6">Datos</span></h5>
                                    <!-- Tipo Contribuyente -->
                                    <div class="col-sm-3">
                                        <label class="form-label" for="condicion_sujeto">Condición</label><span class="text-danger">*</span>
                                        <select class="form-select form-select-sm" id="condicion_sujeto" aria-label="Small select example" name="condicion_sujeto">
                                            <option>Seleccione</option>
                                            <option value="9">Natural</option>
                                            <option value="10">Firma Personal</option>
                                            <option value="11">Ente</option>
                                        </select>
                                    </div>
                                    <!-- ci o rif -->
                                    <div class="col-sm-5">
                                        <label class="form-label" for="identidad_condicion">C.I / R.I.F</label><span class="text-danger">*</span>
                                        <div class="row">
                                            <div class="col-5">
                                                <select class="form-select form-select-sm" id="identidad_condicion" aria-label="Small select example" name="identidad_condicion">
                                                    <option>Seleccione</option>
                                                </select>
                                            </div>
                                            <!-- <div class="col-1">-</div> -->
                                            <div class="col-7">
                                                <input type="number" id="identidad_nro" class="form-control form-control-sm" name="identidad_nro" required >
                                                <p class="text-end text-muted fw-bold mb-0" style="font-size:12px;">Ejemplo: 7521004</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- nombre o razon -->
                                    <div class="col-sm-4">
                                        <label class="form-label" for="nombre">Nombre / Razon Social</label><span class="text-danger">*</span>
                                        <input type="text" id="nombre" class="form-control form-control-sm" name="nombre" disabled required>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center mt-3 mb-3 d-none" id="btns_add_contribuyente">
                                <button type="button" class="btn btn-secondary btn-sm me-3" id="btn_cancel_add_c">Cancelar</button>
                                <button type="button" class="btn btn-success btn-sm" id="btn_add_contribuyente">Registrar</button>
                            </div>
                        </div>

                        <!-- **************** DATOS TRAMITE **************** -->
                        <div class="mb-4" style="font-size:13px">
                            <div class="d-flex flex-column tramites">
                                <div class="d-flex justify-content-center">
                                    <div class="row w-100">
                                        <h5 class="titulo fw-bold text-navy my-3">Tramite | <span class="text-secondary fs-6">Datos</span></h5>
                                        <div class="col-sm-3">
                                            <label class="form-label" for="ente">Ente</label><span class="text-danger">*</span>
                                            <select class="form-select form-select-sm ente" nro="1" id="ente_1" disabled>
                                               
                                                
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="form-label" for="tramite">Tramite</label><span class="text-danger">*</span>
                                            <select class="form-select form-select-sm tramite" name="tramite[1][tramite]" nro="1" id="tramite_1" disabled>
                                                <option value="">Seleccione el tramite </option>
                                                    
                                            </select>
                                        </div>
                                        <div class="col-sm-2" id="div_ucd_1">
                                            <label class="form-label" for="ucd_tramite">UCD</label><span class="text-danger">*</span>
                                            <input type="text" class="form-control form-control-sm ucd_tramite" id="ucd_tramite_1" nro="1" disabled required>
                                        </div>
                                        <div class="col-sm-2">
                                            <label class="form-label" for="forma">Timbre</label><span class="text-danger">*</span>
                                            <select class="form-select form-select-sm forma" nro="1" name="tramite[1][forma]"id="forma_1" required>
                                                <option value="">Seleccione</option>
                                            </select>
                                            <p class="text-end my-0 text-muted" id="cant_timbre_1"></p>
                                        </div>
                                        <div class="col-sm-1 pt-4">
                                            <a  href="javascript:void(0);" class="btn add_button_tramite disabled border-0">
                                                <i class="bx bx-plus fs-4" style="color:#038ae4"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- tamaño de empresa -->
                            <div class="mx-3 mt-4 d-none border p-3 rounded-3" style="background:#f4f7f9;" id="content_tamaño">
                                <p class="text-muted my-0 pb-0">*Ingrese el tamaño de la Empresa.</p>
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-6 d-flex justify-content-center align-items-end">
                                        <div class="">
                                            <label class="form-label" for="metros">Tamaño de la empresa (Mts2):</label><span class="text-danger">*</span>
                                            <div class="d-flex align-items-center">
                                                <input type="number" id="metros" class="form-control form-control-sm me-2" name="metros">
                                                <span class="fw-bold">Mts2</span>
                                            </div>
                                        </div>
                                        <!-- btn calcular -->
                                        <div class="ms-3">
                                            <button type="button" class="btn btn-secondary btn-sm" id="btn_calcular_metrado">Calcular</button>
                                        </div>
                                    </div>

                                    <div class="col-md-6 text-center pt-4" id="size">
                                        
                                    </div>
                                </div>
                            </div>


                            <!-- Capital o Monto de la operación -->
                            <div class="mx-3 mt-4 d-none border p-3 rounded-3" style="background:#f4f7f9;" id="content_capital">
                                <p class="text-muted my-0 pb-0">*Ingrese el Capital o Monto total de la Operación.</p>
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-6 d-flex align-items-end justify-content-center">
                                        <div class="">
                                            <p class="fs-4 fw-bold mb-0 me-4 p_porcentaje">
                                                
                                            </p>
                                        </div>
                                        <div class="pb-1 me-4"> de</div>
                                        <div class="">
                                            <label class="form-label" for="capital">Monto (Bs.):</label><span class="text-danger">*</span>
                                            <div class="d-flex align-items-center">
                                                <input type="number" id="capital" class="form-control form-control-sm me-2" name="capital">
                                                <span class="fw-bold">Bs.</span>
                                            </div>
                                        </div>
                                        <!-- btn calcular -->
                                        <div class="ms-3">
                                            <button type="button" class="btn btn-secondary btn-sm" id="btn_calcular_porcentaje">Calcular</button>
                                        </div>
                                    </div>

                                    <div class="col-md-6 text-center pt-4" id="size">
                                        <p class="fs-4 fw-bold mb-0" id="pct_monto">0,00 Bs.</p>
                                        <p class="text-muted fw-bold fs-6"><span class="p_porcentaje"></span> del monto total.</p>
                                    </div>
                                </div>
                            </div>



                        </div>



                        <!-- totales -->
                        <div class="w-75">
                            <div class="d-flex justify-content-end flex-column">
                                <div class="bg-light rounded-3 px-3 py-2 mb-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="d-flex flex-column titulo mb-0">
                                            <span class="fs-3 fw-bold text-navy">UCD</span>
                                            <span class="fw-bold text-muted" style="font-size:13px">Unidad de Cuenta Dinámica</span>
                                        </p>
                                        <span class="fs-2 text-navy fw-bold" id="ucd">0 </span>
                                    </div>
                                </div>
                                <div class="bg-light rounded-3 px-3 py-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="d-flex flex-column titulo mb-0">
                                            <span class="fs-3 fw-bold text-navy">Bolivares</span>
                                        </p>
                                        <span class="fs-2 text-navy fw-bold" id="bolivares">0,00</span>
                                    </div>
                                </div>
                            </div>
                        </div>


                       
                        

                        <p class="text-muted text-end fw-bold mt-3" style="font-size:13px"><span style="color:red">*</span> Campos requeridos.</p>

                        <div class="d-flex justify-content-center mt-3 mb-3">
                            <a class="btn btn-secondary btn-sm me-3" data-bs-toggle="modal" data-bs-target="#modal_venta_realizada" >Cancelar</a>
                            <button type="submit" class="btn btn-success btn-sm" id="btn_submit_venta">Realizar Venta</button>
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
            $('#asignar_taq_exencion').DataTable(
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