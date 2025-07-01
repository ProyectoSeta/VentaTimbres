@extends('adminlte::page')

@section('title', 'Venta')

@vite(['resources/sass/app.scss', 'resources/js/app.js'])
@section('content')
    <div class="mx-3">

        <div class="row">
            <!-- VENTA -->
            <div class="col-lg-12">
                <!-- TOTALES -->
                <div class="row align-items-center mb-2">
                    <div class="col-lg-3 p-1">
                        <div class="rounded-3 px-3 py-2 bg-navy text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="d-flex flex-column titulo mb-0">
                                    <span class="fs-5 fw-bold pb-0 mb-0 ">| Hoy ({{$moneda}})</span>
                                </p>
                                <span class="fs-4 fw-semibold">{{$ucd_hoy}} bs.</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 p-1">
                        <div class="rounded-3 px-3 py-2" style="background:#d9e9ff">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="d-flex flex-column titulo mb-0">
                                    <span class="fs-3 fw-bold text-navy pb-0 mb-0">U.C.D.</span>
                                </p>
                                <span class="fs-2 text-navy fw-bold" id="ucd">0 </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 p-1">
                        <div class="bg-warning-subtle rounded-3 px-3 py-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="d-flex flex-column titulo mb-0">
                                    <span class="fs-3 fw-bold text-navy pb-0 mb-0">Bolivares</span>
                                </p>
                                <span class="fs-2 text-navy fw-bold" id="bolivares">0,00</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <form id="form_agregar_tramite" method="post" onsubmit="event.preventDefault(); addTramite()">
                    <!-- DATOS CONTRIBUYENTE -->
                    <div class="mb-3 border text-navy rounded-3 p-2 py-3 position-relative mt-4 pt-4" style="font-size:13px">
                        <div class="position-absolute top-0 start-50 translate-middle bg-white px-3 titulo fs-5 fw-bold">Contribuyente</div>
                        <div class="d-flex justify-content-center">
                            <div class="row w-100">
                                <!-- <h5 class="titulo fw-bold text-navy mb-3">Contribuyente | <span class="text-secondary fs-6">Datos</span></h5> -->
                                <!-- Tipo Contribuyente -->
                                <div class="col-sm-3">
                                    <div class="row d-flex a">
                                        <div class="col-lg-4 pt-2">
                                            <label class="form-label" for="condicion_sujeto">Condición</label><span class="text-danger">*</span>
                                        </div>
                                        <div class="col-lg-8">
                                            <select class="form-select form-select-sm" id="condicion_sujeto" aria-label="Small select example" name="condicion_sujeto">
                                                <option>Seleccione</option>
                                                <option value="9">Natural</option>
                                                <option value="10">Firma Personal</option>
                                                <option value="11">Empresa o Ente</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- ci o rif -->
                                <div class="col-sm-4">
                                    <div class="row">
                                        <div class="col-lg-3 pt-2">
                                            <label class="form-label" for="identidad_condicion">C.I / R.I.F</label><span class="text-danger">*</span>
                                        </div>
                                        <div class="col-lg-9">
                                            <div class="row">
                                                <div class="col-4">
                                                    <select class="form-select form-select-sm" id="identidad_condicion" aria-label="Small select example" name="identidad_condicion">
                                                        <option>Seleccione</option>
                                                    </select>
                                                </div>
                                                <div class="col-8">
                                                    <input type="number" id="identidad_nro" class="form-control form-control-sm" name="identidad_nro" required placeholder="Ej: 7521004">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- nombre o razon -->
                                <div class="col-sm-5">
                                    <div class="row">
                                        <div class="col-lg-4 pt-2">
                                            <label class="form-label" for="nombre">Nombre / Razón Social</label><span class="text-danger">*</span>
                                        </div>
                                        <div class="col-lg-8">
                                            <input type="text" id="nombre" class="form-control form-control-sm" name="nombre" disabled required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center mt-3 mb-3 d-none" id="btns_add_contribuyente">
                            <button type="button" class="btn btn-secondary btn-sm me-3" id="btn_cancel_add_c">Cancelar</button>
                            <button type="button" class="btn btn-success btn-sm" id="btn_add_contribuyente">Registrar</button>
                        </div>
                    </div>

                    <!-- TRAMITES -->
                    <div class="mb-3 border rounded-3 p-2 pt-3 pb-1 position-relative mt-4" style="font-size:13px">
                        <div class="position-absolute top-0 start-50 translate-middle bg-white px-3 titulo fs-5 fw-bold">Selección del Tramite</div>
                        <div class="d-flex flex-column">
                            <input type="hidden" name="total_ucd" id="total_ucd" value="0">
                            <input type="hidden" name="total_bs" id="total_bs" value="0">
                            <input type="hidden" name="nro" id="nro" value="1">

                            <div class="d-flex justify-content-center tramites pb-1">
                                <div class="row w-100 ">
                                    <div class="col-sm-2">
                                        <label class="form-label" for="ente">Ente</label><span class="text-danger">*</span>
                                        <select class="form-select form-select-sm ente" nro="1" id="ente_1" disabled>
                                            @foreach ($entes as $ente)
                                                <option value="{{$ente->id_ente}}">{{$ente->ente}}</option>
                                            @endforeach
                                            
                                        </select>
                                    </div>
                                    <div class="col-sm-5">
                                        <label class="form-label" for="tramite">Tramite</label><span class="text-danger">*</span>
                                        <select class="form-select form-select-sm tramite" name="tramite[tramite]" nro="1" id="tramite_1" disabled>
                                            <option value="">Seleccione el tramite </option>
                                            @foreach ($tramites as $tramite)
                                                <option value="{{$tramite->id_tramite}}">{{$tramite->tramite}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-2" id="div_ucd_1">
                                        <label class="form-label" for="ucd_tramite">U.C.D.</label><span class="text-danger">*</span>
                                        <input type="text" class="form-control form-control-sm ucd_tramite" id="ucd_tramite_1" nro="1" disabled required>
                                        <span class="text-end text-muted d-none" id="html_folios">+ <span class="fw-bold text-navy" id="ucd_folios">3 UCD</span> (Folios)</span>
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="form-label" for="forma">Forma</label><span class="text-danger">*</span>
                                        <select class="form-select form-select-sm forma" nro="1" name="tramite[forma]" id="forma_1" required>
                                            <option value="">Seleccione</option>
                                        </select>
                                        <input type="hidden" name="tramite[detalle]" id="detalle_est"> 
                                    </div>
                                    <div class="col-sm-1 d-flex align-items-end">
                                        <button class="btn btn-secondary btn-sm" type="submit">Agregar</button>
                                    </div>
                                </div>
                            </div>

                            <!-- ADJUNTO -->
                            <div class="d-flex flex-column align-items-center m-0 p-0">
                                <!-- Folios -->
                                <div class="w-50 mt-2 d-none border p-3 rounded-3 mb-2" style="background:#f4f7f9; font-size:12.7px" id="content_folios">
                                    <div class="text-muted mb-2">*NOTA: El anexo de cada folio tiene un valor de 1 UCD.</div>
                                    <div class="d-flex align-items-center">
                                        <label class="form-label" for="folios">Ingrese el número de Folios:</label>
                                        <input type="number" id="folios" class="form-control form-control-sm w-50 ms-2" name="folios">
                                    </div>
                                </div>

                                <!-- tamaño de empresa -->
                                <div class="w-75 mt-2 d-none border p-3 rounded-3 mb-2" style="background:#f4f7f9; font-size:12.7px" id="content_tamaño">
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

                                        <div class="col-md-6 text-center pt-0" id="size">
                                            
                                        </div>
                                    </div>
                                </div>

                                <!-- Capital o Monto de la operación -->
                                <div class="w-75 mt-2 d-none border p-3 rounded-3 mb-2" style="background:#f4f7f9; font-size:12.7px" id="content_capital">
                                    <p class="text-muted my-0 pb-0">*Ingrese el Capital o Monto total de la Operación.</p>
                                    <div class="row d-flex align-items-center px-3">
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

                                        <div class="col-md-6 text-center pt-0" id="size">
                                            <p class="fs-4 fw-bold mb-0" id="pct_monto">0,00 Bs.</p>
                                            <p class="text-muted fw-bold fs-6"><span class="p_porcentaje"></span>del monto total.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 

                        
                    </div>
                </form>
                

            
                <form id="form_venta" method="post" onsubmit="event.preventDefault(); venta()">
                    <div class="row"  style="font-size:13px">
                        <div class="col-sm-8">
                            <input type="hidden" name="contribuyente" id="contribuyente">
                            <table class="table text-center"  style="font-size:13px">
                                <thead>
                                    <tr class="table-dark">
                                        <th>#</th>
                                        <th width="45%">Tramite</th>
                                        <th>Anexo</th>
                                        <th>UCD</th>
                                        <th>Forma</th>
                                        <th>Bs.</th>
                                        <th width="10%"></th>
                                    </tr>
                                </thead>
                                <tbody id="tamites_table">
                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-4">
                            <!-- DEBITO - DIFERENCIA - VUELTO -->
                            <div class="">
                                <div class="d-flex flex-column">
                                    <div class="bg-primary-subtle rounded-3 px-3 py-1 mb-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <p class="d-flex flex-column titulo mb-0">
                                                <span class="fs-5 fw-bold text-navy">Debitado</span>
                                            </p>
                                            <span class="fs-5 text-navy fw-bold" id="debitado">0,00</span>
                                        </div>
                                    </div>
                                    <div class="bg-body-secondary rounded-3 px-3 py-1 mb-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <p class="d-flex flex-column titulo mb-0">
                                                <span class="fs-5 fw-bold text-navy">Diferencia</span>
                                            </p>
                                            <span class="fs-5 text-navy fw-bold" id="diferencia">0,00</span>
                                        </div>
                                    </div>
                                    <div class="bg-body-secondary rounded-3 px-3 py-1">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <p class="d-flex flex-column titulo mb-0">
                                                <span class="fs-5 fw-bold text-navy">Vuelto</span>
                                            </p>
                                            <span class="fs-5 text-navy fw-bold" id="vuelto">0,00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- CIERRA DEBITO -->
                            <!-- PAGO -->
                            <div class="my-3 border rounded-3 p-2 py-3" style="font-size:13px">
                                <div class="d-flex flex-column pago_timbre">
                                    <div class="d-flex justify-content-center" >
                                        <div class="row w-100">
                                            <div class="col-lg-5">
                                                <label class="form-label" for="metodo">Metodo</label><span class="text-danger">*</span>
                                                <select class="form-select form-select-sm metodo" aria-label="Small select example" i="1" name="pago[1][metodo]" disabled>
                                                    <option value="5">Punto</option>
                                                    <option value="20">Transferencia</option>
                                                    <option value="6">Efectivo Bs.</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="form-label" for="debitado">Monto</label><span class="text-danger">*</span>
                                                <input type="number" step="0.01" id="debitado_1" class="form-control form-control-sm debitado" name="pago[1][debitado]" disabled required>
                                            </div>
                                            <div class="col-lg-1 pt-4">
                                                <a  href="javascript:void(0);" class="btn add_button disabled border-0 p-0" title="Agregar monto en Efectivo">
                                                    <i class="bx bx-plus pt-2 fs-4" style="color:#038ae4"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- CIERRA PAGO -->
                        </div>
                    </div>

                    <!-- BUTTONS -->
                    <div class="d-flex justify-content-center mt-3 mb-3">
                        <button type="submit" class="btn btn-success btn-sm me-3" disabled id="btn_submit_venta" ciclo="1">Realizar Venta</button>
                        <a class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modal_venta_realizada" >Cancelar</a>
                    </div>

                </form>

                


                

                <!-- <p class="text-muted text-end fw-bold mb-2 p-0" style="font-size:13px"><span style="color:red">*</span> Campos requeridos.</p> -->
                       

            </div><!--  cierra div.col-lg-12 -->
        </div><!--  cierra div.row -->


        




       
    </div>
    
    
<!-- ***************************************************   MODALES   ***************************************************** -->
    <div class="modal fade" id="modal_papel_dañado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_ver_solicitud">
                <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                    <i class='bx bx-error-circle fs-2 text-danger me-2'></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Papel Dañado</h1>
                    </div>
                </div>
                <div class="modal-body px-4" style="font-size:13px">
                    <div class="my-2">
                        <label class="form-label" for="">Motivo: </label><span class="text-danger">*</span>
                        <input type="" id="" class="form-control form-control-sm" name=""  required>
                    </div>
                    <p class="text-muted text-end"><span style="color:red">*</span> Campos requeridos.</p>
                    
                    <table class="table my-4">
                        <tr>
                            <th>Correlativo Dañado:</th>
                            <td><span class="text-danger fw-bold">A-8001002</span></td>
                        </tr>
                        <tr>
                            <th>Correlativo Nuevo:</th>
                            <td><span class="text-danger fw-bold">A-8001003</span></td>
                        </tr>
                    </table>

                    
                    <div class="d-flex justify-content-center mt-3 mb-3">
                        <button type="button" class="btn btn-secondary btn-sm me-3" id="" >Cancelar</button>
                        <button type="submit" class="btn btn-success btn-sm" id="" >Aceptar</button>
                    </div> 
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <div class="modal fade" id="modal_timbre_impreso" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content" id="content_timbre_impreso">
                <div class="modal-header">
                    <!-- <i class='bx bx-error-circle fs-2  me-2'></i> -->
                    <h1 class="modal-title fs-5 fw-bold text-navy">Timbre Fiscal | <span class="text-muted">Emitido</span></h1>
                </div>
                <div class="modal-body px-4 py-3" style="font-size:13px">
                    <div class="">
                        <div class="row d-flex align-items-center">
                            <div class="col-lg-12">
                                <div class="d-flex justify-content-between align-items-center my-3">
                                    <div class="w-25 d-flex justify-content-center">
                                        <img src="{{asset('assets/aragua.png')}}" class="img-fluid" alt="" width="90px">
                                    </div>
                                    <div class="text-center w-50 px-3">
                                        <span class="fw-bold">TIMBRE FISCAL ELECTRÓNICO</span><br>
                                        <span class="fw-bold">FORMA 14-TFE</span><br>
                                        <span>PARA ABONAR A LAS CUENTAS DEL GOBIERNO BOLIVARIANO DE VENEZUELA</span>
                                    </div>
                                    <div class="w-25">
                                        <img src="{{asset('assets/logo_seta.png')}}" class="img-fluid" alt="" width="120px">
                                    </div>
                                </div>
                                
                                <div class="text-danger fw-bold fs-4 text-end" id="">A-8001002</div>
                                
                                <!-- <div class="text-center mb-3 fw-bold titulo">
                                    <div class="my-0 py-0 TEXT">Venta Timbre Fiscal</div>
                                    <div class="my-0 py-0 text-navy fs-5">FORMA 14-TFE</div>
                                </div> -->

                                <div class="fw-bold px-3">
                                    <p class="mb-0">
                                        <span>FECHA DE EMISIÓN: </span>
                                        <span class="text-muted">13/03/2024</span>
                                    </p>
                                    <p class="mb-0">
                                        <span>CÉDULA DE IDENTIDAD: </span>
                                        <span class="text-muted">V123456</span>
                                    </p>
                                    <p class="mb-0">
                                        <span>NOMBRE O RAZÓN SOCIAL: </span>
                                        <span class="text-muted">PRUEBA UNO</span>
                                    </p>
                                    <p class="mb-0">
                                        <span>TAQUILLA: </span>
                                        <span class="text-muted">004</span>
                                    </p>
                                    <p class="mb-0">
                                        <span>ENTE: </span>
                                        <span class="text-muted">Registro</span>
                                    </p>
                                    <p class="mb-0">
                                        <span>TRÁMITE: </span>
                                        <span class="text-muted">Registro de Título Universitario</span>
                                    </p>
                                    <p class="mb-0">
                                        <span>CANTIDAD DE UCD: </span>
                                        <span class="text-muted">2</span>
                                    </p>
                                    <p class="mb-0">
                                        <span>MONTO A PAGAR: </span>
                                        <span class="text-muted">Bs. 81,92</span>
                                    </p>
                                </div>

                
                                
                                <div class="d-flex justify-content-end flex-column text-center mb-2 mt-4">
                                    <div>
                                        <img src="{{asset('assets/qrcode_G1.png')}}" class="img-fluid" alt="" width="120px">
                                        <div class="d-flex justify-content-end flex-column text-center">
                                            <p class="text-secondary fw-bold mt-2 mb-0 ">VALIDO HASTA</p>
                                            <p class="text-secondary">23/03/2024</p>
                                        </div>
                                       
                                    </div>
                                </div>
                                
            
                                <div class="fs-6 text-secondary text-center titulo ">
                                    <p class="">GOBIERNO BOLIVARIANO DEL ESTADO ARAGUA</p>
                                </div>
                                
                                    
                                </div>
                            </div>

                            <!--  -->

                            <!-- <div class="col-lg-4">
                                <div class="d-flex justify-content-center">
                                    <img src="{{asset('assets/timbre.png')}}" class="img-fluid mt-3" alt="" width="180px">
                                </div>

                                <div class="text-end mt-3">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#modal_papel_dañado">¿Papel dañado?</a>
                                </div>
                            </div> -->
                        </div>

                        <!-- cerrar modal -->
                        <!-- <div class="d-flex justify-content-center my-3">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Listo</button>
                        </div> -->
                    </div>
                    
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <div class="modal fade" id="modal_venta_realizada" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" id="content_venta_realizada">
                
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <div class="modal fade" id="modal_detalle_estampillas" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="content_detalle_estampillas">
                
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>
    

    

<!-- *********************************************************************************************************************** -->

@stop





@section('css')
    
    <link rel="stylesheet" href="{{asset('assets/style.css')}}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
@stop

@section('js')
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
    <script src="{{ asset('jss/datatable.min.js') }}" defer ></script>
    <script src="{{ asset('jss/datatable.bootstrap.js') }}" ></script>
    <script src="{{ asset('jss/toastr.js') }}" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" ></script>
   

    <script type="text/javascript">
        $(document).ready(function () {
            ////ACTUALIZAR INVENTARIO
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("venta.update_inv_taquilla") }}',
                success: function(response) {
                    // console.log(response);
                },
                error: function() {
                }
            });

            


            ///////////////////////////////////////AGREGAR CAMPOS A OTRO(S) PAGO
                var maxFieldPago = 2; //Input fields increment limitation
                var x = 1; //Initial field counter is 1

                $(document).on('click', '.add_button', function(e){ //Once add button is clicked
                    if(x < maxFieldPago){ //Check maximum number of input fields
                        x++; //Increment field counter
                        $('.pago_timbre').append('<div class="d-flex justify-content-center mt-2" >'+
                            '<div class="row w-100">'+
                                '<div class="col-sm-5">'+
                                    '<select class="form-select form-select-sm metodo" name="pago[2][metodo]" i="2">'+
                                        '<option value="5">Punto</option>'+
                                        '<option value="20">Transferencia</option>'+
                                        '<option value="6">Efectivo Bs.</option>'+
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-6">'+
                                    '<input type="number" step="0.01" id="debitado_2" class="form-control form-control-sm debitado" name="pago[2][debitado]"  required>'+
                                '</div>'+
                                '<div class="col-sm-1  pt-1">'+
                                    '<a  href="javascript:void(0);" class="btn remove_button p-0" >'+
                                        '<i class="bx bx-x fs-4"></i>'+
                                    '</a>'+
                                '</div>'+
                            '</div>'+
                        '</div>'); // Add field html
                        $('#debitado_1').val(''); 
                    }
                });

                $(document).on('click', '.remove_button', function(e){ //Once remove button is clicked
                    e.preventDefault();
                    $(this).parent('div').parent('div').remove(); //Remove field html
                    x--; //Decrement field counter
                    $('#btn_submit_venta').attr('disabled', true);
                });
            ///////////////////////////////////////////////////////////////////

            ///////////////////////////////////////AGREGAR CAMPOS A OTRO(S) DETALLE ESTAMPILLAS
                var maxFieldeEst = 10; //Input fields increment limitation
                var h = 1; //Initial field counter is 1

                $(document).on('click', '.add_button_estampilla', function(e){ //Once add button is clicked
                    if(h < maxFieldeEst){ //Check maximum number of input fields
                        h++; //Increment field counter
                        $.ajax({
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            type: 'POST',
                            url: '{{route("venta.add_estampilla") }}',
                            success: function(response) {
                                // console.log(response);
                                $('#content_detalle_est').append('<div class="d-flex justify-content-center pb-1">'+
                                        '<div class="row">'+
                                            '<div class="col-5">'+
                                                '<select class="form-select form-select-sm ucd_est" aria-label="Small select example"id="ucd_est_'+h+'" nro="'+h+'"  name="detalle['+h+'][ucd]" required>'+
                                                    response+
                                                '</select>'+
                                            '</div>'+
                                            '<div class="col-5">'+
                                                '<input type="number" class="form-control form-control-sm cant_est" id="cant_est_1" nro="1" name="detalle['+h+'][cantidad]" required>'+
                                            '</div>'+
                                            '<div class="col-sm-1">'+
                                                '<a  href="javascript:void(0);" class="btn remove_button_estampillas" nro="'+h+'">'+
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

                $(document).on('click', '.remove_button_estampillas', function(e){ //Once remove button is clicked
                    e.preventDefault();
                    $(this).parent('div').parent('div').remove(); //Remove field html
                    h--; //Decrement field counter
                });
            //////////////////////////////////////////////////////////////////
                

            //////////////////////////////////////QUITAR TRAMITE
            $(document).on('click', '.remove_tramite', function(e){ //Once remove button is clicked
                e.preventDefault();
                var nro =  $(this).attr('nro');
                var ucd =  $('#total_ucd').val();
                var bs =  $('#total_bs').val();
                var tramite = $('input[type=hidden]#tramite_'+nro).val();
                // console.log(tramite);
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("venta.quitar") }}',
                    data: {ucd:ucd,bs:bs,tramite:tramite},
                    success: function(response) {
                        // console.log(response);
                        if (response.success) {
                            ///TOTALES
                            $('#ucd').html(response.ucd); 
                            $('#bolivares').html(response.format_bs); 
                            $('#debitado_1').val(response.bs); 

                            // UPDATE CAMPOS
                            $('#total_ucd').val(response.ucd);
                            $('#total_bs').val(response.bs);

                            /////ELIMINAR TR
                            $('#tr_'+nro).remove(); //Remove field html
                        }else{

                        }
                    },
                    error: function() {
                    }
                });
            
            });

            ////////////////////////// CONDICIÓN SUJETO
            $(document).on('change','#condicion_sujeto', function(e) {
                e.preventDefault(); 
                var value = $(this).val(); 

                $('#identidad_condicion option').remove();

                if (value == "9") {
                    ///NATURAL
                    $('#identidad_condicion').append('<option>Seleccione</option>'+
                                                    '<option value="V">V</option>'+
                                                    '<option value="E">E</option>'+
                                                    '<option value="P">P</option>');
                }else if(value == "10"){
                    ///FIRMA PERSONAL
                     $('#identidad_condicion').append('<option>Seleccione</option>'+
                                                    '<option value="V">V</option>'+
                                                    '<option value="E">E</option>');
                }
                else{
                    ///ENTE O JURIDICO
                    $('#identidad_condicion').append('<option>Seleccione</option>'+
                                                    '<option value="J">J</option>'+
                                                    '<option value="G">G</option>'+
                                                    '<option value="C">C</option>');
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

                            $('.metodo').attr('disabled', false);
                            $('.comprobante').attr('disabled', false);
                            $('.debitado').attr('disabled', false);

                            $('.add_button_tramite').removeClass('disabled');
                            $('.add_button').removeClass('disabled');

                            // $('#btn_submit_venta').attr('disabled', false);

                        }else{
                            if (response.alert == 'false') {
                                $('#btns_add_contribuyente').removeClass('d-none');
                                $('#nombre').attr('disabled', false);
                                $('#nombre').val('');
                                
                                $('.ente').attr('disabled', true);
                                $('.tramite').attr('disabled', true);
                                $('.forma').attr('disabled', true);

                                $('.metodo').attr('disabled', true);
                                $('.comprobante').attr('disabled', true);
                                $('.debitado').attr('disabled', true);

                                $('.add_button_tramite').addClass('disabled');
                                $('.add_button').addClass('disabled');

                                $('#btn_submit_venta').attr('disabled', true);
                            }else{
                                alert(response.nota);
                                window.location.href = "{{ route('venta')}}";
                            }
                            
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

                $('.metodo').attr('disabled', true);
                $('.comprobante').attr('disabled', true);
                $('.debitado').attr('disabled', true);

                $('.add_button_tramite').addClass('disabled');
                $('.add_button').addClass('disabled');

                $('#btn_submit_venta').attr('disabled', true);
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
                        // console.log(response);
                        if (response.success) {
                            $('#nombre').attr('disabled', true);
                            $('#btns_add_contribuyente').addClass('d-none');
                            alert('REGISTRO DE CONTRIBUYENTE EXITOSO.');


                            $('.ente').attr('disabled', false);
                            $('.tramite').attr('disabled', false);
                            $('.forma').attr('disabled', false);

                            $('.metodo').attr('disabled', false);
                            $('.comprobante').attr('disabled', false);
                            $('.debitado').attr('disabled', false);

                            $('.add_button_tramite').removeClass('disabled');
                            $('.add_button').removeClass('disabled');

                            $('#btn_submit_venta').attr('disabled', false);


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

            //////////////////////////// TRAMITES SEGUN EL ENTE
            $(document).on('change','.ente', function(e) {
                e.preventDefault(); 
                var nro =  $(this).attr('nro');
                var value = $(this).val();

                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("venta.tramites") }}',
                    data: {value:value},
                    success: function(response) {
                        $('#tramite_'+nro).html(response);
                    },
                    error: function() {
                    }
                });
            });







            $(document).on('keyup','#folios', function(e) {
                var value = $(this).val();

                $('#html_folios').removeClass('d-none');

                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("venta.folios") }}',
                    data: {value:value},
                    success: function(response) {
                        // console.log(response);
                        $('#ucd_folios').html(response+' UCD');
                        // calcular();
                    },
                    error: function() {
                    }
                });

            });


            //////////////////////////// VALOR DEL TRAMITE SELECCIONADO
            $(document).on('change','.tramite', function(e) {
                e.preventDefault(); 
                var nro =  $(this).attr('nro');
                var value = $(this).val();

                var condicion_sujeto =  $('#condicion_sujeto').val();

                var ente =  $('#ente_'+nro).val();
                var metros = $('#metros').val();
                var capital = $('#capital').val();

                $('#ucd_tramite_'+nro).val('');
                $('#forma_'+nro+' option').remove();
                $('#forma_'+nro).append('<option>Seleccione</option>');

                if (value == '') {
                    $('#ucd_tramite_'+nro).val('0');
                }else{
                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        type: 'POST',
                        url: '{{route("venta.alicuota") }}',
                        data: {tramite:value,condicion_sujeto:condicion_sujeto,metros:metros,capital:capital},
                        success: function(response) {
                            // console.log(response);
                            if (response.success) {
                                
                                switch(response.alicuota) {
                                    case 7:
                                        /// UCD
                                        $('#ucd_tramite_'+nro).val(response.valor);
                                        forma(nro,response.valor);
                                        // calcular();

                                        if (response.folios == true) {
                                            $('#content_folios').removeClass('d-none');
                                            $('#content_capital').addClass('d-none');
                                            $('#content_tamaño').addClass('d-none');
                                        }else{
                                            $('#content_capital').addClass('d-none');
                                            $('#content_folios').addClass('d-none');
                                            $('#content_tamaño').addClass('d-none');
                                            $('#html_folios').addClass('d-none');
                                        }
                                        
                                        break;
                                    case 8:
                                        /// PORCENTAJE
                                        $('#capital').val('0');
                                        $('#pct_monto').html('0,00 Bs.');

                                        $('#content_capital').removeClass('d-none');
                                        $('#content_folios').addClass('d-none');
                                        $('#content_tamaño').addClass('d-none');
                                        $('#html_folios').addClass('d-none');

                                        $('.p_porcentaje').html(response.porcentaje+'%');

                                        break;
                                    case 13:
                                        /// METRADO
                                        $('#content_tamaño').removeClass('d-none');
                                        $('#content_folios').addClass('d-none');
                                        $('#content_capital').addClass('d-none');
                                        $('#html_folios').addClass('d-none');
                                        
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
            });


            



            // ///////////////////////// DETALLE DE LOS TIMBRES HA VENDER (ESTAMPILLAS Y FORMA 14)
            $(document).on('change','.forma', function(e) {
                var value = $(this).val();
                var nro =  $(this).attr('nro');
                var condicion_sujeto =  $('#condicion_sujeto').val();
                var folios = $('#folios').val();

                if (value == 4) {
                    ////ESTAMPILLAS
                    var tramite =  $('#tramite_'+nro).val();

                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        type: 'POST',
                        url: '{{route("venta.estampillas") }}',
                        data: {tramite:tramite,condicion_sujeto:condicion_sujeto,nro:nro,folios:folios},
                        success: function(response) {
                            $('#modal_detalle_estampillas').modal('show');
                            $('#content_detalle_estampillas').html(response);
                        },
                        error: function() {
                        }
                    });
                }else{
                    ////TFE14

                }
                
            });

            /////////////////////////// CERRAR MODAL DETALLE
            $(document).on('click','#btn_cancelar_detalle_est', function(e) {
                e.preventDefault();
                var nro =  $(this).attr('nro');

                $('#forma_'+nro+' option').remove();
                $('#forma_'+nro).append('<option>Seleccione</option>'+
                            '<option value="3">TFE-14</option>'+
                            '<option value="4">Estampilla</option>');
            });
            // /////////////////////////////////////////////////////////////////////////////////
    




            //////////////////////////// VALOR DEL TRAMITE SEGUN EL METRADO Y EL PORCENTAJE
            // METRADO
            $(document).on('click','#btn_calcular_metrado', function(e) {
                e.preventDefault();
                var condicion_sujeto =  $('#condicion_sujeto').val();
                var metros =  $('#metros').val();
                var capital =  $('#capital').val();

                $(".tramite").each(function(e){
                    var tramite = $(this).val();
                    var nro = $(this).attr('nro');

                    var varios_metrado = 0;

                    cal_misc(tramite,condicion_sujeto, metros,capital,nro,varios_metrado);
                    
                });
            });


            // PORCENTAJE       
            $(document).on('click','#btn_calcular_porcentaje', function(e) {
                e.preventDefault();
                var condicion_sujeto =  $('#condicion_sujeto').val();
                var metros =  $('#metros').val();
                var capital =  $('#capital').val();

                $(".tramite").each(function(e){
                    var tramite = $(this).val();
                    var nro = $(this).attr('nro');

                    cal_misc(tramite,condicion_sujeto, metros,capital,nro);
                    
                    
                });
            });


            


            //////////////////////////// CALCULAR DEBITO
            $(document).on('keyup','.debitado', function(e) {
                var id = $(this).attr('id');
                var value = $(this).val();
                var otro_debito = 0;

                if (id == 'debitado_1') {
                    otro_debito = $("#debitado_2").val();
                }else{
                    otro_debito = $("#debitado_1").val();
                }

                var tramites = [];
                $('.tramite_in').each(function(){
                    var t = $(this).val();
                    tramites.push(t);
                });
                
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("venta.debitado") }}',
                    data: {value:value,tramites:tramites,otro_debito:otro_debito},
                    success: function(response) {
                        // console.log(response);
                        $('#debitado').html(response.debito);
                        $('#diferencia').html(response.diferencia);
                        $('#vuelto').html(response.vuelto);

                        if (response.submit) {
                            $('#btn_submit_venta').attr('disabled', false);
                        }else{
                            $('#btn_submit_venta').attr('disabled', true);
                        }
                    },
                    error: function() {
                    }
                });
               
                
            });
            

            



            ////DESHABILITAR BTNS DE IMPRIMIR AL DAR CLICK
            $(document).on('mouseup','.btn_imprimir_tfe', function(e) {
                e.preventDefault();
                var i = $(this).attr('i');
                setTimeout('deshabilitar_print('+i+');',2000);
    
            });

            ////DESHABILITAR BTNS DE REALIZAR VENTA
            // $(document).on('mouseup','#btn_submit_venta', function(e) {
            //     $('#btn_submit_venta').attr('disabled',true);
            // });
           


            
        });

        ///////FUNCION DESHABILITAR BTN DE IMPRIMIR TIMBRE
        function deshabilitar_print(i){
                console.log(i);
                $('#print_'+i).addClass('disabled');
        }

        ///////////////// ADD CAMPO FORMA 
        function forma(nro,ucd) {
            // console.log(nro+'/'+ucd);
            ///////////////////////////  ADD CAMPO FORMA(S)
            $('#forma_'+nro+' option').remove();

            if (ucd < 11) {
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
                    // console.log(response);

                    if (response.success) {
                        switch(response.alicuota) {
                            case 7:
                                /// UCD
                                $('#ucd_tramite_'+nro).val(response.valor);
                                forma(nro,response.valor);
                                // calcular();
                                
                                break;
                            case 8:
                                /// PORCENTAJE
                                if (response.valor_format == undefined) {
                                    $('#div_ucd_'+nro).html('<label class="form-label" for="ucd_tramite">Bs.</label><span class="text-danger">*</span>'+
                                        '<input type="text" class="form-control form-control-sm ucd_tramite" id="ucd_tramite_'+nro+'" nro="'+nro+'" value="0" disabled required>');
                                    $('#pct_monto').html('0 Bs.');
                                }else{
                                   $('#div_ucd_'+nro).html('<label class="form-label" for="ucd_tramite">Bs.</label><span class="text-danger">*</span>'+
                                        '<input type="text" class="form-control form-control-sm ucd_tramite" id="ucd_tramite_'+nro+'" nro="'+nro+'" value="'+response.valor_format+'" disabled required>');
                                    $('#pct_monto').html(response.valor_format+' Bs.');
                                }
                                
                                forma(nro,response.valor);
                                // calcular();

                                break; 
                                
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
                                // calcular();
                                
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


        //////////////// VENTA DE TIMBRES
        function venta(){
            var ciclo = $('#btn_submit_venta').attr('ciclo');
            if (ciclo == 1) {
                var formData = new FormData(document.getElementById("form_venta"));
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url:'{{route("venta.venta") }}',
                    type:'POST',
                    contentType:false,
                    cache:false,
                    processData:false,
                    async: true,
                    data: formData,
                    success: function(response){
                        // console.log(response);
                        if (response.success) {
                            $('#modal_venta_realizada').modal('show');
                            $('#content_venta_realizada').html(response.html);

                            // 

                            
                        }else{
                            if (response.nota) {
                                alert(response.nota);
                            }else{
                                alert('Disculpe, ha ocurrido un error');
                            }

                            window.location.href = "{{ route('venta')}}";
                        }
                        
                    },
                    error: function(error){
                        
                    }
                });
            }else{
                $(document).on('mouseup','#btn_submit_venta', function(e) {
                    $('#btn_submit_venta').attr('disabled',true);
                });
            }

            $('#btn_submit_venta').attr('ciclo',2);
            
        }



        function detalleEst(){
            var formData = new FormData(document.getElementById("form_detalle_est"));
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url:'{{route("venta.est_detalle") }}',
                type:'POST',
                contentType:false,
                cache:false,
                processData:false,
                async: true,
                data: formData,
                success: function(response){
                    // console.log(response);
                    if (response.success) {
                        $('#modal_detalle_estampillas').modal('hide');
                        $('#detalle_est').val(response.detalle);
                    }else{
                        if (response.nota) {
                            alert(response.nota);
                        }else{
                            alert('Disculpe, ha ocurrido un error');
                        }
                    }

                },
                error: function(error){
                    
                }
            });
        }


        function addTramite(){
            var formData = new FormData(document.getElementById("form_agregar_tramite"));
            var bs = $('#total_bs').val();
            var ucd = $('#total_ucd').val();

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url:'{{route("venta.agregar") }}',
                type:'POST',
                contentType:false,
                cache:false,
                processData:false,
                async: true,
                data: formData,
                success: function(response){
                    console.log(response);
                    if (response.success) {
                        /////ADD TR
                        $('#tamites_table').append(response.tr);

                        ///TOTALES
                        $('#ucd').html(response.ucd); 
                        $('#bolivares').html(response.format_bs); 
                        $('#debitado_1').val(response.bs); 
                        $('#btn_submit_venta').attr('disabled', false);

                        // UPDATE CAMPOS
                        $('#total_ucd').val(response.ucd);
                        $('#total_bs').val(response.bs);
                        $('#nro').val(response.nro);
                        $('#contribuyente').val(response.contribuyente);

                        //////LIMPIAR 
                        $('#ente_1').html('@foreach ($entes as $ente)'+
                                                '<option value="{{$ente->id_ente}}">{{$ente->ente}}</option>'+
                                            '@endforeach');
                        $('#tramite_1').html('<option value="">Seleccione el tramite </option>'+
                                                '@foreach ($tramites as $tramite)'+
                                                    '<option value="{{$tramite->id_tramite}}">{{$tramite->tramite}}</option>'+
                                                '@endforeach');
                        $('#ucd_tramite_1').val('0');
                        $('#forma_1').html('<option value="">Seleccione</option>');    
                        $('#detalle_est').val('');        
                        
                        // OCULTAR ANEXOS
                        $('#content_capital').addClass('d-none');
                        $('#content_folios').addClass('d-none');
                        $('#content_tamaño').addClass('d-none');
                        $('#html_folios').addClass('d-none');
                    }else{
                        if (response.nota != '') {
                            alert(response.nota);
                        }else{

                        }
                    }

                },
                error: function(error){
                    
                }
            });
        }

    </script>
  
@stop