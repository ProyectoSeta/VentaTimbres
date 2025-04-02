@extends('adminlte::page')

@section('title', 'Venta')

@vite(['resources/sass/app.scss', 'resources/js/app.js'])
@section('content')
    <div class="mx-3">

        <div class="row">
            <!-- VENTA -->
            <div class="col-lg-12">
                <!-- UCD HOY -->
                <!-- <div class="d-flex justify-content-center align-items-center mt-3 pb-3" style="font-size:14px">
                    <div class="d-flex bg-navy rounded-4">
                        <div class="bg-primary rounded-start-4 py-2 px-3 fs-6 fw-bold">
                            <span>U.C.D. Hoy   </span>
                        </div>
                        <div class="py-2 px-3 fs-6 fw-bold text-end">
                            <span>{{$ucd}} bs. ({{$moneda}})</span>
                        </div> 
                    </div>
                </div> -->

                <!-- TOTALES -->
                
                <div class="row d-flex align-items-end mb-2">
                    <div class="col-lg-5 p-1">
                        <div class="rounded-3 px-3 py-2" style="background:#d9e9ff">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="d-flex flex-column titulo mb-0">
                                    <span class="fs-3 fw-bold text-navy pb-0 mb-0">U.C.D.</span>
                                    <!-- <span class="fw-bold text-muted" style="font-size:13px">Unidad de Cuenta Dinámica</span> -->
                                </p>
                                <span class="fs-2 text-navy fw-bold" id="ucd">0 </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 p-1">
                        <div class="bg-warning-subtle rounded-3 px-3 py-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="d-flex flex-column titulo mb-0">
                                    <span class="fs-3 fw-bold text-navy pb-0 mb-0">Bolivares</span>
                                    <!-- <span class="fw-bold text-muted" style="font-size:13px">A pagar</span> -->
                                </p>
                                <span class="fs-2 text-navy fw-bold" id="bolivares">0,00</span>
                            </div>
                        </div>
                    </div>
                </div>
                

                <!-- FORM -->
                    <!-- <form id="form_venta" method="post" onsubmit="event.preventDefault(); venta()"> -->
                        <!-- DATOS CONTRIBUYENTE -->
                        <div class="mb-3 border text-navy rounded-3 p-2 py-3 position-relative mt-4 pt-4" style="font-size:13px">
                            <div class="position-absolute top-0 start-50 translate-middle bg-white px-3 titulo fs-5">Contribuyente</div>
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
                                            <div class="col-3 pt-2">
                                                <label class="form-label" for="identidad_condicion">C.I / R.I.F</label><span class="text-danger">*</span>
                                            </div>
                                            <div class="col-9">
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
                                            <div class="col-4 pt-2">
                                                <label class="form-label" for="nombre">Nombre / Razón Social</label><span class="text-danger">*</span>
                                            </div>
                                            <div class="col-8">
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
                        <!-- <h5 class="titulo fw-bold text-navy mb-3 ms-3">Tramite | <span class="text-secondary fs-6">Datos</span></h5> -->
                        <div class="mb-3 border rounded-3 p-2 py-3" style="font-size:13px">
                            <div class="d-flex flex-column">
                                <form action="">
                                    <div class="d-flex justify-content-center pb-1">
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
                                                <select class="form-select form-select-sm tramite" name="tramite[1][tramite]" nro="1" id="tramite_1" disabled>
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
                                                <select class="form-select form-select-sm forma" nro="1" name="tramite[1][forma]"id="forma_1" required>
                                                    <option value="">Seleccione</option>
                                                </select>
                                                <input type="hidden" name="tramite[1][detalle]" id="detalle_1"> 
                                                <!-- <p class="text-end my-0 text-muted" id="cant_timbre_1"></p> -->
                                            </div>
                                            <div class="col-sm-1 d-flex align-items-end">
                                                <!-- <a  href="javascript:void(0);" class="btn add_button_tramite disabled border-0">
                                                    <i class="bx bx-plus fs-4" style="color:#038ae4"></i>
                                                </a> -->
                                                <button class="btn btn-secondary btn-sm" type="submit">Agregar</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                
                            </div> 
                        </div>

                        <!-- ADJUNTO -->
                        <div class="d-flex flex-column align-items-center m-0 p-0">
                            <!-- Folios -->
                            <div class="w-50 mt-2 d-none border p-3 rounded-3" style="background:#f4f7f9; font-size:12.7px" id="content_folios">
                                <div class="text-muted mb-2">*NOTA: El anexo de cada folio tiene un valor de 1 UCD.</div>
                                <div class="d-flex align-items-center">
                                    <label class="form-label" for="folios">Ingrese el número de Folios:</label>
                                    <input type="number" id="folios" class="form-control form-control-sm w-50 ms-2" name="folios" required>
                                </div>
                            </div>

                            <!-- tamaño de empresa -->
                            <div class="w-75 mt-2 d-none border p-3 rounded-3" style="background:#f4f7f9; font-size:12.7px" id="content_tamaño">
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
                            <div class="w-75 mt-2 d-none border p-3 rounded-3" style="background:#f4f7f9; font-size:12.7px" id="content_capital">
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

                        <!-- PAGO -->
                        <h5 class="titulo fw-bold text-center text-navy mb-3 ms-3 mt-3"> <span class="text-secondary fs-6">DETALLE VENTA</span></h5>
                        <div class="row"  style="font-size:13px">
                            <div class="col-sm-8">
                                <form action="">
                                    <table class="table text-center"  style="font-size:13px">
                                        <thead>
                                            <tr class="table-dark">
                                                <th>#</th>
                                                <th>Tramite</th>
                                                <th>Anexo</th>
                                                <th>UCD | Bs.</th>
                                                <th>Forma</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Título Universitario</td>
                                                <td>
                                                    <span class="text-muted fst-italic">No aplica</span>
                                                </td>
                                                <td>
                                                    <span class="">2 UCD</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <span>Est 1 UCD</span>
                                                        <span>Est 1 UCD</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                            <div class="col-sm-4">
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
                            </div>
                            
                            
                        </div>





                        <!-- <div class="mb-3 border rounded-3 p-2 py-3" style="font-size:13px">
                            <div class="d-flex flex-column pago_timbre">
                                <div class="d-flex justify-content-center" >
                                    <div class="row w-100">
                                        <div class="col-sm-4">
                                            <label class="form-label" for="metodo">Metodo de Pago</label><span class="text-danger">*</span>
                                            <select class="form-select form-select-sm metodo" aria-label="Small select example" i="1" name="pago[1][metodo]" disabled>
                                                <option value="5">Punto</option>
                                                <option value="6">Efectivo Bs.</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <label class="form-label" for="comprobante">No. Comprobante</label><span class="text-danger">*</span>
                                            <input type="number" class="form-control form-control-sm comprobante" name="pago[1][comprobante]" id="comprobante_1" disabled required>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="form-label" for="debitado">Monto Debitado </label><span class="text-danger">*</span>
                                            <input type="number" step="0.01" id="debitado_1" class="form-control form-control-sm debitado" name="pago[1][debitado]" disabled required>
                                        </div>
                                        <div class="col-sm-1 pt-4">
                                            <a  href="javascript:void(0);" class="btn add_button disabled border-0" title="Agregar monto en Efectivo">
                                                <i class="bx bx-plus fs-4" style="color:#038ae4"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <!-- <p class="text-muted text-end fw-bold mb-2 p-0" style="font-size:13px"><span style="color:red">*</span> Campos requeridos.</p> -->
                       
                    <!-- </form> -->
                <!-- CIERRA FORM -->

            </div>
            <!-- DETALLES VENTA -->
            <div class="">
                <!-- DEBITO -->
                <!-- <h5 class="titulo fw-bold text-success fs-4 mt-4 mb-3">Debito</h5> -->
                
                 

                <!-- DETALLE -->
                <!-- <div class="border rounded-3 my-3" style="font-size:12px">
                    <div class="d-flex flex-column text-center fw-semibold lh-sm my-2" style="font-size:12px">
                        <span class="fw-bold">Servicio Tributario de Aragua (SETA)</span>
                        <span>Detalle de la Venta</span>
                        <span>Tramites | Formas</span>
                    </div>

                    <div class="mx-3">
                        <table class="table table-sm table-borderles lh-sm"  style="font-size:12px">
                            <thead class="text-center">
                               <tr>
                                    <th>Tramite</th>
                                    <th>Detalle</th>
                                    <th>Total UCD</th>
                                </tr> 
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Protocolización</td>
                                    <td>
                                        <div class="d-flex flex-column lh-sm">
                                            <span>TFE 14 (10 UCD)</span>
                                        </div>
                                    </td>
                                    <th>10 UDC</th>
                                </tr>
                                <tr>
                                    <td>Sellado de Libro</td>
                                    <td>
                                        <div class="d-flex flex-column lh-sm">
                                            <span>Est (5 UCD)</span>
                                            <span>Est (5 UCD)</span>
                                        </div>
                                    </td>
                                    <th>10 UDC</th>
                                </tr>
                            </tbody>
                            
                        </table>
                    </div>
                </div> -->


                <!-- BUTTONS -->
                <!-- <div class="d-flex justify-content-center mt-3 mb-3">
                    <button type="submit" class="btn btn-success btn-sm me-3" disabled id="btn_submit_venta">Realizar Venta</button>
                    <a class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modal_venta_realizada" >Cancelar</a>
                </div> -->
            </div>
        </div>


        




       
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
    

    

    <!-- <div class="modal fade" id="modal_timbre_impreso" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content" id="content_timbre_impreso">
                <div class="modal-header">
                    
                    <h1 class="modal-title fs-5 fw-bold text-navy">Timbre Fiscal</h1>
                </div>
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    <div class="">
                        <div class="row d-flex align-items-center">
                            <div class="col-lg-12">
                                <div class="d-flex justify-content-between align-items-center my-3">
                                    <div>
                                        <img src="{{asset('assets/logo_seta.png')}}" class="img-fluid" alt="" width="120px">
                                    </div>
                                    <div>
                                        <span class="text-danger fw-bold fs-4 text-end" id="">A-8001002</span>
                                    </div>
                                </div>

                                <div class="text-center mb-3 fw-bold titulo">
                                    <div class="my-0 py-0 TEXT">Venta Timbre Fiscal</div>
                                    <div class="my-0 py-0 text-navy fs-5">FORMA 14-TFE</div>
                                </div>

                                
                                <div style="font-size:14px">
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="fw-bold my-0 py-0">
                                                <span class="text-navy">Contribuyente:</span>
                                                <span class="text-muted">Marina Rodríguez</span>
                                            </p>
                                            <p class="fw-bold my-0 py-0">
                                                <span class="text-navy">C.I/R.I.F:</span>
                                                <span class="text-muted">V8456201</span>
                                            </p>
                                        </div>
                                        <div class="col-6 text-end">
                                            <p class="fw-bold my-0 py-0">
                                                <span class="text-navy">Emisión:</span>
                                                <span class="text-muted">2024-05-10</span>
                                            </p>
                                            <p class="fw-bold my-0 py-0">
                                                <span class="text-navy">No. Planilla:</span>
                                                <span class="text-muted">999904520</span>
                                            </p>
                                        </div>
                                    </div>
                
                                    <div class="my-3 fs-5">
                                        <p class="text-muted fw-bold">
                                            Monto Bs.: 80.7
                                        </p>
                                    </div>
                
                                    <div class="">
                                        <div class="row">
                                            <div class="col-6 d-flex justify-content-center align-items-center text-center">
                                                <p class="fs-1 titulo">2 UCD</p>
                                            </div>
                                            <div class="col-6 d-flex justify-content-center flex-column text-center">
                                                <div>
                                                    <img src="{{asset('assets/qrcode_G1.png')}}" class="img-fluid" alt="" width="120px">
                                                    <p class="text-secondary fw-bold mt-2">Serial: 8001cd3a8f41</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                
                                    <div class="fs-6 text-secondary text-center titulo ">
                                        <p class="">GOBIERNO BOLIVARIANO DEL ESTADO ARAGUA</p>
                                    </div>
                                
                                    
                                </div>
                            </div>

                            

                            <div class="col-lg-4">
                                <div class="d-flex justify-content-center">
                                    <img src="{{asset('assets/timbre.png')}}" class="img-fluid mt-3" alt="" width="180px">
                                </div>

                                <div class="text-end mt-3">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#modal_papel_dañado">¿Papel dañado?</a>
                                </div>
                            </div> 
                        </div>

                        
                        <div class="d-flex justify-content-center my-3">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Listo</button>
                        </div>
                    </div>
                    
                </div>
            </div>  
        </div>  
    </div> -->
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
            // ////ACTUALIZAR INVENTARIO
            // $.ajax({
            //     headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            //     type: 'POST',
            //     url: '{{route("venta.update_inv_taquilla") }}',
            //     success: function(response) {
            //         console.log(response);
            //     },
            //     error: function() {
            //     }
            // });

            // ///////////////////////////////////////AGREGAR CAMPOS A OTRO(S) TRAMITES
            //     var maxFieldTramite = 3; //Input fields increment limitation
            //     var c = 1; //Initial field counter is 1

            //     $(document).on('click', '.add_button_tramite', function(e){ //Once add button is clicked
            //         if(c < maxFieldTramite){ //Check maximum number of input fields
            //             c++; //Increment field counter
            //             $('.tramites').append('<div class="d-flex justify-content-center ">'+
            //                                 '<div class="row w-100 mt-2">'+
            //                                     '<div class="col-sm-3">'+
            //                                         '<select class="form-select form-select-sm ente" nro="'+c+'" id="ente_'+c+'">'+
            //                                             '@foreach ($entes as $ente)'+
            //                                                 '<option value="{{$ente->id_ente}}">{{$ente->ente}}</option>'+
            //                                             '@endforeach'+
                                                        
            //                                         '</select>'+
            //                                     '</div>'+
            //                                     '<div class="col-sm-4">'+
            //                                         '<select class="form-select form-select-sm tramite" name="tramite['+c+'][tramite]" nro="'+c+'" id="tramite_'+c+'" required>'+
            //                                             '<option value="">Seleccione el tramite </option>'+
            //                                                 '@foreach ($tramites as $tramite)'+
            //                                                     '<option value="{{$tramite->id_tramite}}">{{$tramite->tramite}}</option>'+
            //                                                 '@endforeach'+
            //                                         '</select>'+
            //                                     '</div>'+
            //                                     '<div class="col-sm-2" id="div_ucd_'+c+'">'+
            //                                         '<input type="text" class="form-control form-control-sm ucd_tramite" id="ucd_tramite_'+c+'" nro="'+c+'" disabled>'+
            //                                     '</div>'+
            //                                     '<div class="col-sm-2">'+
            //                                         '<select class="form-select form-select-sm forma" nro="'+c+'" name="tramite['+c+'][forma]" id="forma_'+c+'" required>'+
            //                                             '<option value="">Seleccione</option>'+
            //                                         '</select>'+
            //                                         '<input type="hidden" name="tramite[1][detalle]" id="detalle_'+c+'">'+
            //                                         // '<p class="text-end my-0 text-muted" id="cant_timbre_'+c+'"></p>'+
            //                                     '</div>'+
            //                                     '<div class="col-sm-1">'+
            //                                         '<a  href="javascript:void(0);" class="btn remove_button_tramite" nro="'+c+'">'+
            //                                             '<i class="bx bx-x fs-4"></i>'+
            //                                         '</a>'+
            //                                     '</div>'+
            //                                 '</div>'+
            //                             '</div>'); // Add field html
            //         }
            //     });

            //     $(document).on('click', '.remove_button_tramite', function(e){ 
            //         var nro =  $(this).attr('nro');
            //         var ente =  $('#ente_'+nro).val();
            //         var detalle =  $('#detalle_'+nro).val();

            //         if (ente == 4) {
            //             var u = 0;
            //             $(".ente").each(function(e){
            //                 var value = $(this).val();
            //                 if (value == 4) {
            //                     u++;
            //                 }
            //             });

            //             if (u == 1) {
            //                 $('#content_tamaño').addClass('d-none');
            //             }
            //         }

            //         //////ACTUALIZAR INV TAQUILLA
            //         $.ajax({
            //             headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            //             type: 'POST',
            //             url: '{{route("venta.delete_tramite") }}',
            //             data: {detalle:detalle},
            //             success: function(response) {
            //                 console.log(response);
            //             },
            //             error: function() {
            //             }
            //         });

            //         e.preventDefault();
            //         $(this).parent('div').parent('div').remove(); //Remove field html
            //         c--; //Decrement field counter
            //         calcular();
            //     });
            // ///////////////////////////////////////////////////////////////////


            // ///////////////////////////////////////AGREGAR CAMPOS A OTRO(S) PAGO
            //     var maxFieldPago = 2; //Input fields increment limitation
            //     var x = 1; //Initial field counter is 1

            //     $(document).on('click', '.add_button', function(e){ //Once add button is clicked
            //         if(x < maxFieldPago){ //Check maximum number of input fields
            //             x++; //Increment field counter
            //             $('.pago_timbre').append('<div class="d-flex justify-content-center mt-2" >'+
            //                 '<div class="row w-100">'+
            //                     '<div class="col-sm-4">'+
            //                         '<label class="form-label" for="">Metodo de Pago</label><span class="text-danger">*</span>'+
            //                         '<select class="form-select form-select-sm metodo" name="pago[2][metodo]" >'+
            //                             '<option value="6">Efectivo Bs.</option>'+
            //                         '</select>'+
            //                     '</div>'+
            //                     '<div class="col-sm-3">'+
            //                         '<label class="form-label" for="">No. Comprobante</label><span class="text-danger">*</span>'+
            //                         '<input type="number" class="form-control form-control-sm comprobante" name="pago[2][comprobante]" disabled>'+
            //                     '</div>'+
            //                     '<div class="col-sm-4">'+
            //                         '<label class="form-label" for="">Monto Debitado </label><span class="text-danger">*</span>'+
            //                         '<input type="number" step="0.01" id="debitado_2" class="form-control form-control-sm debitado" name="pago[2][debitado]"  required>'+
            //                     '</div>'+
            //                     '<div class="col-sm-1  pt-4">'+
            //                         '<a  href="javascript:void(0);" class="btn remove_button" >'+
            //                             '<i class="bx bx-x fs-4"></i>'+
            //                         '</a>'+
            //                     '</div>'+
            //                 '</div>'+
            //             '</div>'); // Add field html
            //         }
            //     });

            //     $(document).on('click', '.remove_button', function(e){ //Once remove button is clicked
            //         e.preventDefault();
            //         $(this).parent('div').parent('div').remove(); //Remove field html
            //         x--; //Decrement field counter
            //     });
            // ///////////////////////////////////////////////////////////////////

            // ///////////////////////////////////////AGREGAR CAMPOS A OTRO(S) DETALLE ESTAMPILLAS
            //     var maxFieldeEst = 10; //Input fields increment limitation
            //     var h = 1; //Initial field counter is 1

            //     $(document).on('click', '.add_button_estampilla', function(e){ //Once add button is clicked
            //         if(h < maxFieldeEst){ //Check maximum number of input fields
            //             h++; //Increment field counter
            //             $('#content_detalle_est').append('<div class="d-flex justify-content-center pb-1">'+
            //                             '<div class="row">'+
            //                                 '<div class="col-5">'+
            //                                     '<select class="form-select form-select-sm ucd_est" aria-label="Small select example"id="ucd_est_'+h+'" nro="'+h+'"  name="detalle['+h+'][ucd]" required>'+
            //                                         '<option value="1">1 UCD</option>'+
            //                                         '<option value="2">2 UCD</option>'+
            //                                         '<option value="3">3 UCD</option>'+
            //                                         '<option value="3">5 UCD</option>'+
            //                                     '</select>'+
            //                                 '</div>'+
            //                                 '<div class="col-5">'+
            //                                     '<input type="number" class="form-control form-control-sm cant_est" id="cant_est_1" nro="1" name="detalle['+h+'][cantidad]" required>'+
            //                                 '</div>'+
            //                                 '<div class="col-sm-1">'+
            //                                     '<a  href="javascript:void(0);" class="btn remove_button_estampillas" nro="'+h+'">'+
            //                                         '<i class="bx bx-x fs-4"></i>'+
            //                                     '</a>'+
            //                                 '</div>'+
            //                             '</div>'+
            //                         '</div>'); // Add field html
            //         }
            //     });

            //     $(document).on('click', '.remove_button_estampillas', function(e){ //Once remove button is clicked
            //         e.preventDefault();
            //         $(this).parent('div').parent('div').remove(); //Remove field html
            //         h--; //Decrement field counter
            //     });
            // //////////////////////////////////////////////////////////////////

            // //////////////////////////// BUSCAR CONTRIBUYENTE
            // $(document).on('keyup','#identidad_nro', function(e) {  
            //     e.preventDefault(); 
            //     var value = $(this).val();
            //     var condicion = $('#identidad_condicion').val();
            //     var condicion_sujeto = $('#condicion_sujeto').val();

            //     $.ajax({
            //         headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            //         type: 'POST',
            //         url: '{{route("venta.search") }}',
            //         data: {value:value,condicion:condicion,condicion_sujeto:condicion_sujeto},
            //         success: function(response) {
            //             // console.log(response);               
            //             if (response.success) {
            //                 $('#btns_add_contribuyente').addClass('d-none');
            //                 $('#nombre').val(response.nombre);
            //                 $('#nombre').attr('disabled', true);


            //                 $('.ente').attr('disabled', false);
            //                 $('.tramite').attr('disabled', false);
            //                 $('.forma').attr('disabled', false);

            //                 $('.metodo').attr('disabled', false);
            //                 $('.comprobante').attr('disabled', false);
            //                 $('.debitado').attr('disabled', false);

            //                 $('.add_button_tramite').removeClass('disabled');
            //                 $('.add_button').removeClass('disabled');

            //                 $('#btn_submit_venta').attr('disabled', false);

            //             }else{
            //                 $('#btns_add_contribuyente').removeClass('d-none');
            //                 $('#nombre').attr('disabled', false);
            //                 $('#nombre').val('');
                            
            //                 $('.ente').attr('disabled', true);
            //                 $('.tramite').attr('disabled', true);
            //                 $('.forma').attr('disabled', true);

            //                 $('.metodo').attr('disabled', true);
            //                 $('.comprobante').attr('disabled', true);
            //                 $('.debitado').attr('disabled', true);

            //                 $('.add_button_tramite').addClass('disabled');
            //                 $('.add_button').addClass('disabled');

            //                 $('#btn_submit_venta').attr('disabled', true);
            //             }
            //         },
            //         error: function() {
            //         }
            //     });
                
            
            // });


            // $(document).on('change','#identidad_condicion', function(e) {
            //     $('#identidad_nro').val('');

            //     $('#btns_add_contribuyente').removeClass('d-none');
            //     $('#nombre').attr('disabled', false);
            //     $('#nombre').val('');
                
            //     $('.ente').attr('disabled', true);
            //     $('.tramite').attr('disabled', true);
            //     $('.forma').attr('disabled', true);

            //     $('.metodo').attr('disabled', true);
            //     $('.comprobante').attr('disabled', true);
            //     $('.debitado').attr('disabled', true);

            //     $('.add_button_tramite').addClass('disabled');
            //     $('.add_button').addClass('disabled');

            //     $('#btn_submit_venta').attr('disabled', true);
            // });

            // /////////////////////////// BTN REGISTRO CONTRIBUYENTE
            // $(document).on('click','#btn_add_contribuyente', function(e) {
            //     e.preventDefault();
            //     var condicion_sujeto = $('#condicion_sujeto').val();
            //     var condicion = $('#identidad_condicion').val();
            //     var nro = $('#identidad_nro').val();
            //     var nombre = $('#nombre').val();

            //     $.ajax({
            //         headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            //         type: 'POST',
            //         url: '{{route("venta.add_contribuyente") }}',
            //         data: {condicion:condicion,nro:nro,nombre:nombre,condicion_sujeto:condicion_sujeto},
            //         success: function(response) {
            //             // console.log(response);
            //             if (response.success) {
            //                 $('#nombre').attr('disabled', true);
            //                 $('#btns_add_contribuyente').addClass('d-none');
            //                 alert('REGISTRO DE CONTRIBUYENTE EXITOSO.');


            //                 $('.ente').attr('disabled', false);
            //                 $('.tramite').attr('disabled', false);
            //                 $('.forma').attr('disabled', false);

            //                 $('.metodo').attr('disabled', false);
            //                 $('.comprobante').attr('disabled', false);
            //                 $('.debitado').attr('disabled', false);

            //                 $('.add_button_tramite').removeClass('disabled');
            //                 $('.add_button').removeClass('disabled');

            //                 $('#btn_submit_venta').attr('disabled', false);


            //             }else{
            //                 if (response.nota) {
            //                     alert(response.nota);
            //                 }else{
            //                     alert('Disculpe, ha ocurrido un error al registar a el contribuyente.');
            //                 }
            //                 ////alert
            //             }   
            //         },
            //         error: function() {
            //         }
            //     });
            // });


            // /////////////////////////// BTN CANCELAR REGISTRO CONTRIBUYENTE
            // $(document).on('click','#btn_cancel_add_c', function(e) {
            //     e.preventDefault();
            //     $('#btns_add_contribuyente').addClass('d-none');
            //     $('#nombre').attr('disabled', true);

            //     $('#nombre').val('');
            //     $('#identidad_nro').val('');
            // });

            // //////////////////////////// TRAMITE: PROTOCOLIZACIÓN
            // $(document).on('change','.tramite', function(e) {
            //     var value = $(this).val();
            //     if (value == 1 || value == 2) {
            //         $('#content_folios').removeClass('d-none');
            //     }
            // });

            // $(document).on('keyup','#folios', function(e) {
            //     var value = $(this).val();

            //     $('#html_folios').removeClass('d-none');

            //     $.ajax({
            //         headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            //         type: 'POST',
            //         url: '{{route("venta.folios") }}',
            //         data: {value:value},
            //         success: function(response) {
            //             console.log(response);
            //             $('#ucd_folios').html(response+' UCD');
            //             calcular();
            //         },
            //         error: function() {
            //         }
            //     });

            // });


            // //////////////////////////// VALOR DEL TRAMITE SELECCIONADO
            // $(document).on('change','.tramite', function(e) {
            //     e.preventDefault(); 
            //     var nro =  $(this).attr('nro');
            //     var value = $(this).val();

            //     var condicion_sujeto =  $('#condicion_sujeto').val();
            //     var ente =  $('#ente_'+nro).val();
            //     var metros = $('#metros').val();
            //     var capital = $('#capital').val();

            //     $('#ucd_tramite_'+nro).val('');
            //     $('#forma_'+nro+' option').remove();
            //     $('#forma_'+nro).append('<option>Seleccione</option>');

            //     if (value == '') {
            //         $('#ucd_tramite_'+nro).val('0');
            //     }else{

            //         var tramites = [];
            //         var condicion_folios = 0;
            //         $('.tramite').each(function(){
            //             var t = $(this).val();
            //             tramites.push(t);

            //             if (t == 1 || t == 2) {
            //                 condicion_folios = 1;
            //             }

            //         });


            //         $.ajax({
            //             headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            //             type: 'POST',
            //             url: '{{route("venta.alicuota") }}',
            //             data: {tramites:tramites,tramite:value,condicion_sujeto:condicion_sujeto,metros:metros,capital:capital},
            //             success: function(response) {
            //                 // console.log(response);
            //                 if (response.success) {
            //                     if (response.no_porcentaje > 1 || response.no_metrado > 1) {
            //                         alert('Solo se puede escoger un tramite relacionado con los metros y el porcentaje de la gestión, por venta.');
            //                         // $("#tramite_"+nro+" option[value='']").attr("selected",true);
            //                         $('#tramite_'+nro)[0].selectedIndex = 0;
            //                     }else{
            //                         switch(response.alicuota) {
            //                             case 7:
            //                                 /// UCD
            //                                 $('#ucd_tramite_'+nro).val(response.valor);
            //                                 forma(nro,response.valor);
            //                                 calcular();
                                            
            //                                 break;
            //                             case 8:
            //                                 /// PORCENTAJE
            //                                 $('#capital').val('0');
            //                                 $('#pct_monto').html('0,00 Bs.');

            //                                 $('#content_capital').removeClass('d-none');
            //                                 $('.p_porcentaje').html(response.porcentaje+'%');

            //                                 break;
            //                             case 13:
            //                                 /// METRADO
            //                                 $('#content_tamaño').removeClass('d-none');
                                            
            //                                 break;
            //                             default:
            //                                 alert('Disculpe, a ocurrido un error. Vuelva a intentarlo.');
            //                                 break;
            //                         }
            //                     }

            //                     //////////////////////  AGREGAR CLASE D-NONE SI EL CASO LO AMERITA
            //                     if (response.no_porcentaje == 0) {
            //                         $('#content_capital').addClass('d-none');
            //                     }else if(response.no_metrado == 0){
            //                         $('#content_tamaño').addClass('d-none');
            //                     }

                                
            //                 }else{

            //                 }
                            
            //             },
            //             error: function() {
            //             }
            //         });

            //         if (condicion_folios == 0) {
            //             $('#content_folios').addClass('d-none');
            //             $('#html_folios').addClass('d-none');
            //         }

            //     }
            // });


            // //////////////////////////// TRAMITES SEGUN EL ENTE
            // $(document).on('change','.ente', function(e) {
            //     e.preventDefault(); 
            //     var nro =  $(this).attr('nro');
            //     var value = $(this).val();

            //     $.ajax({
            //         headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            //         type: 'POST',
            //         url: '{{route("venta.tramites") }}',
            //         data: {value:value},
            //         success: function(response) {
            //             $('#tramite_'+nro).html(response);
            //         },
            //         error: function() {
            //         }
            //     });
            // });



            // ///////////////////////// DETALLE DE LOS TIMBRES HA VENDER (ESTAMPILLAS Y FORMA 14)
            // $(document).on('change','.forma', function(e) {
            //     var value = $(this).val();
            //     var nro =  $(this).attr('nro');
            //     var condicion_sujeto =  $('#condicion_sujeto').val();
            //     var folios = $('#folios').val();

            //     if (value == 4) {
            //         ////ESTAMPILLAS
            //         var tramite =  $('#tramite_'+nro).val();

            //         $.ajax({
            //             headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            //             type: 'POST',
            //             url: '{{route("venta.estampillas") }}',
            //             data: {tramite:tramite,condicion_sujeto:condicion_sujeto,nro:nro,folios:folios},
            //             success: function(response) {
            //                 $('#modal_detalle_estampillas').modal('show');
            //                 $('#content_detalle_estampillas').html(response);
            //             },
            //             error: function() {
            //             }
            //         });
            //     }else{
            //         ////TFE14

            //     }
                
            // });

            // /////////////////////////// CERRAR MODAL DETALLE
            // $(document).on('click','#btn_cancelar_detalle_est', function(e) {
            //     e.preventDefault();
            //     var nro =  $(this).attr('nro');

            //     $('#forma_'+nro+' option').remove();
            //     $('#forma_'+nro).append('<option>Seleccione</option>'+
            //                 '<option value="3">TFE-14</option>'+
            //                 '<option value="4">Estampilla</option>');
            // });
            // /////////////////////////////////////////////////////////////////////////////////
    



            // //////////////////////////// MONTO TOTAL
            // $(document).on('change','.tramite', function(e) {
            //     calcular();
            // });


            // //////////////////////////// VALOR DEL TRAMITE SEGUN EL METRADO Y EL PORCENTAJE
            // // METRADO
            // $(document).on('click','#btn_calcular_metrado', function(e) {
            //     e.preventDefault();
            //     var condicion_sujeto =  $('#condicion_sujeto').val();
            //     var metros =  $('#metros').val();
            //     var capital =  $('#capital').val();

            //     $(".tramite").each(function(e){
            //         var tramite = $(this).val();
            //         var nro = $(this).attr('nro');

            //         var varios_metrado = 0;

            //         cal_misc(tramite,condicion_sujeto, metros,capital,nro,varios_metrado);
                    
            //     });
            // });


            // // PORCENTAJE       
            // $(document).on('click','#btn_calcular_porcentaje', function(e) {
            //     e.preventDefault();
            //     var condicion_sujeto =  $('#condicion_sujeto').val();
            //     var metros =  $('#metros').val();
            //     var capital =  $('#capital').val();

            //     $(".tramite").each(function(e){
            //         var tramite = $(this).val();
            //         var nro = $(this).attr('nro');

            //         cal_misc(tramite,condicion_sujeto, metros,capital,nro);
                    
                    
            //     });
            // });


            


            // //////////////////////////// CALCULAR DEBITO
            // $(document).on('keyup','.debitado', function(e) {
            //     var id = $(this).attr('id');
            //     var value = $(this).val();
            //     var metros = $('#metros').val();
            //     var otro_debito = 0;

            //     var condicion_sujeto =  $('#condicion_sujeto').val();

            //     if (id == 'debitado_1') {
            //         otro_debito = $("#debitado_2").val();
            //     }else{
            //         otro_debito = $("#debitado_1").val();
            //     }

            //     var tramites = [];
            //     $('.tramite').each(function(){
            //         var t = $(this).val();
            //         tramites.push(t);
            //     });
                
            //     $.ajax({
            //         headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            //         type: 'POST',
            //         url: '{{route("venta.debitado") }}',
            //         data: {value:value,tramites:tramites,otro_debito:otro_debito,metros:metros,condicion_sujeto:condicion_sujeto},
            //         success: function(response) {
            //             console.log(response);
            //             $('#debitado').html(response.debito);
            //             $('#diferencia').html(response.diferencia);
            //             $('#vuelto').html(response.vuelto);

            //             if (response.submit) {
            //                 $('#btn_submit_venta').attr('disabled', false);
            //             }else{
            //                 $('#btn_submit_venta').attr('disabled', true);
            //             }
            //         },
            //         error: function() {
            //         }
            //     });
               
                
            // });
            

            // //////////////////////////// DESABILITAR CAMPO NO COMPROBANTE
            // $(document).on('change','.metodo', function(e) {
            //     e.preventDefault(); 
            //     var value = $(this).val();
            //     var i = $(this).attr('i');
            //     console.log(value+'/'+i);
            //     if (value == '6') {
            //         $('#comprobante_'+i).attr('disabled', true);
            //         $('#comprobante_'+i).val('');
            //     }else{
            //         $('#comprobante_'+i).attr('disabled', false);
            //     }
               
            // });


            // //////////////////////////// CONDICIÓN SUJETO
            // $(document).on('change','#condicion_sujeto', function(e) {
            //     e.preventDefault(); 
            //     var value = $(this).val(); 

            //     $('#identidad_condicion option').remove();

            //     if (value == "9" || value == "10") {
            //         $('#identidad_condicion').append('<option>Seleccione</option>'+
            //                                         '<option value="V">V</option>'+
            //                                         '<option value="E">E</option>');
            //     }else{
            //         $('#identidad_condicion').append('<option>Seleccione</option>'+
            //                                         '<option value="J">J</option>'+
            //                                         '<option value="G">G</option>');
            //     }

            // });


            //////////////////ESTAMPILLA 10UCD Y DISPONIBILIDAD DE TIMBRE
                // $(document).on('change','.forma', function(e) {
                //     var value = $(this).val();
                //     var nro =  $(this).attr('nro');

                //     var ucd =  $('#ucd_tramite_'+nro).val();
                //     var array = [];
                
                //     if (value == 4  && ucd == 10) {
                //         $('#cant_timbre_'+nro).html('2 Und.');
                //         var cant = 2;
                //     }else{
                //         $('#cant_timbre_'+nro).html('1 Und.');
                //         var cant = 1;
                //     }

                //     $('.ucd_tramite').each(function(e){
                //         var ucd_each = $(this).val();
                //         var nro_each = $(this).attr('nro');
                //         var forma_each =  $('#forma_'+nro_each).val();

                //         if (ucd_each == ucd && nro_each != nro && forma_each == value) {
                //             if (forma_each == 4  && ucd_each == 10) {
                //                 cant = cant + 2;  
                //             }else{
                //                 cant++;
                //             }
                //         }
                //     });


                //     var objeto = {
                //         ucd: ucd,
                //         forma: value,
                //         cantidad: cant
                //     };
                //     array.push(objeto);
                                

                //     $.ajax({
                //         headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                //         type: 'POST',
                //         url: '{{route("venta.disponibilidad") }}',
                //         data: {array:array},
                //         success: function(response) {
                //             // console.log(response);
                //             if (response.success) {
                                
                //             }else{
                //                 alert(response.nota);
                //                 forma(nro,ucd)
                //             }
                            
                //         },
                //         error: function() {
                //         }
                //     });

                // });
        });


        // ////////////////// CALCULAR TOTAL
        // function calcular(){
        //     var tramites = [];
        //     $('.tramite').each(function(){
        //         var t = $(this).val();
        //         tramites.push(t);
        //     });

        //     var metros = $('#metros').val();
        //     var folios = $('#folios').val();
        //     var capital = $('#capital').val();
        //     var condicion_sujeto =  $('#condicion_sujeto').val();

        //     $.ajax({
        //         headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        //         type: 'POST',
        //         url: '{{route("venta.total") }}',
        //         data: {tramites:tramites,metros:metros,condicion_sujeto:condicion_sujeto,capital:capital,folios:folios},
        //         success: function(response) {
        //             console.log(response);
        //             $('#ucd').html(response.ucd);
        //             $('#bolivares').html(response.bolivares);
        //             $('#diferencia').html(response.bolivares);

        //             $('.debitado').val('');
        //             $('.comprobante').val('');

        //             $('#debitado').html('0.00');
        //             $('#vuelto').html('0.00');
                    
        //         },
        //         error: function() {
        //         }
        //     });

        //     // console.log(tramites);
        // }


        // ///////////////// ADD CAMPO FORMA 
        // function forma(nro,ucd) {
        //     // console.log(nro+'/'+ucd);
        //     ///////////////////////////  ADD CAMPO FORMA(S)
        //     $('#forma_'+nro+' option').remove();

        //     if (ucd < 11) {
        //         $('#forma_'+nro).append('<option>Seleccione</option>'+
        //                     '<option value="3">TFE-14</option>'+
        //                     '<option value="4">Estampilla</option>');
        //     }else{
        //         $('#forma_'+nro).append('<option>Seleccione</option>'+
        //                     '<option value="3">TFE-14</option>');
        //     }

        // }


        // //////////////// CALCULO METRADO Y PORCENTAJE
        // function cal_misc(tramite,condicion_sujeto, metros,capital,nro){
        //     $.ajax({
        //         headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        //         type: 'POST',
        //         url: '{{route("venta.alicuota") }}',
        //         data: {tramite:tramite,condicion_sujeto:condicion_sujeto,metros:metros,capital:capital},
        //         success: function(response) {
        //             // console.log(response);

        //             if (response.success) {
        //                 switch(response.alicuota) {
        //                     case 7:
        //                         /// UCD
        //                         $('#ucd_tramite_'+nro).val(response.valor);
        //                         forma(nro,response.valor);
        //                         calcular();
                                
        //                         break;
        //                     case 8:
        //                         /// PORCENTAJE
        //                         if (response.valor_format == undefined) {
        //                             $('#div_ucd_'+nro).html('<label class="form-label" for="ucd_tramite">Bs.</label><span class="text-danger">*</span>'+
        //                                 '<input type="text" class="form-control form-control-sm ucd_tramite" id="ucd_tramite_'+nro+'" nro="'+nro+'" value="0" disabled required>');
        //                             $('#pct_monto').html('0 Bs.');
        //                         }else{
        //                            $('#div_ucd_'+nro).html('<label class="form-label" for="ucd_tramite">Bs.</label><span class="text-danger">*</span>'+
        //                                 '<input type="text" class="form-control form-control-sm ucd_tramite" id="ucd_tramite_'+nro+'" nro="'+nro+'" value="'+response.valor_format+'" disabled required>');
        //                             $('#pct_monto').html(response.valor_format+' Bs.');
        //                         }
                                
        //                         forma(nro,response.valor);
        //                         calcular();

        //                         break; 
                                
        //                     case 13:
        //                         /// METRADO
        //                         $('#content_tamaño').removeClass('d-none');

        //                         if (response.size == 'small') {
        //                             $('#size').html('<p class="fs-4 fw-bold mb-0">Pequeña</p>'+
        //                                             '<p class="text-secondary">*Hasta 150 mts2.</p>');
        //                         }else if(response.size == 'medium'){
        //                             $('#size').html('<p class="fs-4 fw-bold mb-0">Mediana</p>'+
        //                                             '<p class="text-secondary">*Desde 151, Hasta 399 mts2.</p>');
        //                         }else if(response.size == 'large'){
        //                             $('#size').html('<p class="fs-4 fw-bold mb-0">Grande</p>'+
        //                                             '<p class="text-secondary">*Mayor a 400 mts2.</p>');
        //                         }else{
        //                             $('#size').html('');
        //                         }

        //                         $('#ucd_tramite_'+nro).val(response.valor);
        //                         forma(nro,response.valor);
        //                         calcular();
                                
        //                         break;
        //                     default:
        //                         alert('Disculpe, a ocurrido un error. Vuelva a intentarlo.');
        //                         break;
        //                 }
        //             }else{

        //             }
                    
        //         },
        //         error: function() {
        //         }
        //     });

        // }


        // //////////////// VENTA DE TIMBRES
        // function venta(){
        //     var formData = new FormData(document.getElementById("form_venta"));
        //     // console.log("alo");
        //     $.ajax({
        //         headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        //         url:'{{route("venta.venta") }}',
        //         type:'POST',
        //         contentType:false,
        //         cache:false,
        //         processData:false,
        //         async: true,
        //         data: formData,
        //         success: function(response){
        //             console.log(response);
        //             if (response.success) {
        //                 $('#modal_venta_realizada').modal('show');
        //                 $('#content_venta_realizada').html(response.html);
        //             }else{
        //                 if (response.nota) {
        //                     alert(response.nota);
        //                 }else{
        //                     alert('Disculpe, ha ocurrido un error');
        //                 }
        //             }
                       
        //         },
        //         error: function(error){
                    
        //         }
        //     });
        // }



        // function detalleEst(){
        //     var formData = new FormData(document.getElementById("form_detalle_est"));
        //     $.ajax({
        //         headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        //         url:'{{route("venta.est_detalle") }}',
        //         type:'POST',
        //         contentType:false,
        //         cache:false,
        //         processData:false,
        //         async: true,
        //         data: formData,
        //         success: function(response){
        //             console.log(response);
        //             if (response.success) {
        //                 $('#modal_detalle_estampillas').modal('hide');
        //                 $('#detalle_'+response.nro).val(response.detalle);
        //             }else{
        //                 if (response.nota) {
        //                     alert(response.nota);
        //                 }else{
        //                     alert('Disculpe, ha ocurrido un error');
        //                 }
        //             }

        //         },
        //         error: function(error){
                    
        //         }
        //     });
        // }

    </script>
  
@stop