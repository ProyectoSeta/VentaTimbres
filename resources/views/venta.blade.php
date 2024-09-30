@extends('adminlte::page')

@section('title', 'Venta')


@section('content')
    <div class="mx-3">
        <div class="d-flex justify-content-center align-items-center mt-3 pb-3" style="font-size:14px">
            <ul class="nav nav-pills titulo px-3 w-100 d-flex" id="pills-tab" role="tablist">                 
                <li class="nav-item me-3" role="presentation">
                    <a class="nav-link active" id="pills-f14-tab" data-bs-toggle="pill" data-bs-target="#pills-f14" type="button" role="tab" aria-controls="pills-f14" aria-selected="true">
                        <div class="d-flex gap-1 pe-2">
                            <div class="ms-2">
                                <h6 class="mb-1 text-700 text-nowrap" style="font-size:13px">Timbre</h6>
                                <h6 class="mb-0 lh-1 fw-bold">Forma 14</h6>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-tmovil-tab" data-bs-toggle="pill" data-bs-target="#pills-tmovil" type="button" role="tab" aria-controls="pills-tmovil" aria-selected="false">
                        <div class="d-flex gap-1 pe-2">
                            <div class="ms-2">
                                <h6 class="mb-1 text-700 text-nowrap " style="font-size:13px">Timbre</h6>
                                <h6 class="mb-0 lh-1 fw-bold ">Movil</h6>
                            </div>
                        </div>
                    </a>
                </li>
            </ul>

            <!-- UCD HOY -->
            <div class="w-50">
                <div class="d-flex bg-navy rounded-4">
                    <div class="bg-primary rounded-start-4 py-2 px-3 fs-6 fw-bold">
                        <span>UCD Hoy   </span>
                    </div>
                    <div class="py-2 px-3 fs-6 fw-bold text-end">
                        <span>40.93 bs. (EUR)</span>
                    </div> 
                </div>
            </div>
        </div>





        <div class="tab-content" id="pills-tabContent">
            <!-- FORMA 14 -->
            <div class="tab-pane fade show active " id="pills-f14" role="tabpanel" aria-labelledby="pills-f14-tab" tabindex="0">
                <div class="row">
                    <div class="col-xl-8 pe-5" id="">
                        <form id="form_venta_f14" method="post" onsubmit="event.preventDefault(); ventaF14()">
                            <!-- *************** DATOS CONTRIBUYENTE ******************-->
                            <div class="mb-2" style="font-size:13px">
                                <div class="d-flex justify-content-center">
                                    <div class="row w-100">
                                        <h5 class="titulo fw-bold text-navy my-3">Contribuyente | <span class="text-secondary fs-6">Datos</span></h5>
                                        <div class="col-sm-6">
                                            <label class="form-label" for="identidad_condicion">C.I / R.I.F</label><span class="text-danger">*</span>
                                            <div class="row">
                                                <div class="col-4">
                                                    <select class="form-select form-select-sm" id="identidad_condicion" aria-label="Small select example" name="identidad_condicion">
                                                        <option value="V">V</option>
                                                        <option value="E">E</option>
                                                        <option value="J">J</option>
                                                        <option value="G">G</option>
                                                    </select>
                                                </div>
                                                <div class="col-1">-</div>
                                                <div class="col-7">
                                                    <input type="number" id="identidad_nro" class="form-control form-control-sm" name="identidad_nro" required >
                                                    <p class="text-end text-muted fw-bold mb-0" style="font-size:12px;">Ejemplo: 7521004</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
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
                                                <select class="form-select form-select-sm ente" nro="1" disabled>
                                                    @foreach ($entes as $ente)
                                                        <option value="{{$ente->id_ente}}">{{$ente->ente}}</option>
                                                    @endforeach
                                                    
                                                </select>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="form-label" for="tramite">Tramite</label><span class="text-danger">*</span>
                                                <select class="form-select form-select-sm tramite" name="tramite[]" nro="1" id="tramite_1" disabled>
                                                    <option value="">Seleccione el tramite </option>
                                                        @foreach ($tramites as $tramite)
                                                            <option value="{{$tramite->id_tramite}}">{{$tramite->tramite}}</option>
                                                        @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-2">
                                                <label class="form-label" for="ucd_tramite">UCD</label><span class="text-danger">*</span>
                                                <input type="text" class="form-control form-control-sm ucd_tramite" id="ucd_tramite_1" disabled required>
                                            </div>
                                            <div class="col-sm-1 pt-4">
                                                <a  href="javascript:void(0);" class="btn add_button_tramite disabled border-0">
                                                    <i class="bx bx-plus fs-4" style="color:#038ae4"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>


                            <!-- ************************ PAGO *****************************-->
                            <div class="mb-2" style="font-size:13px">
                                <div class="d-flex flex-column pago_timbre">
                                    <div class="d-flex justify-content-center" >
                                        <div class="row w-100">
                                            <h5 class="titulo fw-bold text-navy my-3">Pago | <span class="text-secondary fs-6">Timbre Fiscal</span></h5>
                                            <div class="col-sm-4">
                                                <label class="form-label" for="metodo">Metodo de Pago</label><span class="text-danger">*</span>
                                                <select class="form-select form-select-sm metodo" aria-label="Small select example" i="1" name="metodo_one" disabled>
                                                    <option value="punto">Punto</option>
                                                    <option value="efectivo">Efectivo Bs.</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="form-label" for="comprobante">No. Comprobante</label><span class="text-danger">*</span>
                                                <input type="number" class="form-control form-control-sm comprobante" name="comprobante_one" id="comprobante_1" disabled required>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="form-label" for="debitado">Monto Debitado </label><span class="text-danger">*</span>
                                                <input type="number" step="0.01" id="debitado_1" class="form-control form-control-sm debitado" name="debitado_one" disabled required>
                                            </div>
                                            <div class="col-sm-1 pt-4">
                                                <a  href="javascript:void(0);" class="btn add_button disabled border-0">
                                                    <i class="bx bx-plus fs-4" style="color:#038ae4"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            

                            <p class="text-muted text-end fw-bold mt-3" style="font-size:13px"><span style="color:red">*</span> Campos requeridos.</p>

                            <div class="d-flex justify-content-center mt-3 mb-3">
                                <a class="btn btn-secondary btn-sm me-3" data-bs-toggle="modal" data-bs-target="#modal_timbre_impreso" >Cancelar</a>
                                <button type="submit" class="btn btn-success btn-sm" id="btn_submit_venta" >Realizar Venta</button>
                            </div>
                        </form>
                    </div>
                    <!-- ******************************* -->
                    <div class="col-xl-4 pb-3 px-3">
                        <div class="">
                            <h5 class="titulo fw-bold text-success fs-4 mt-4 mb-3">Total a Pagar</h5>
                            <div class="d-flex flex-column">
                                <div class="bg-light rounded-3 px-3 py-2 mb-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="d-flex flex-column titulo mb-0">
                                            <span class="fs-3 fw-bold text-navy">UCD</span>
                                            <span class="fw-bold text-muted" style="font-size:13px">Unidad de cuenta dinamica</span>
                                        </p>
                                        <span class="fs-1 text-navy fw-bold" id="ucd">0 </span>
                                    </div>
                                </div>
                                <div class="bg-light rounded-3 px-3 py-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="d-flex flex-column titulo mb-0">
                                            <span class="fs-3 fw-bold text-navy">Bolivares</span>
                                        </p>
                                        <span class="fs-1 text-navy fw-bold" id="bolivares">0.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  -->
                        <div class="">
                            <h5 class="titulo fw-bold text-success fs-4 mt-4 mb-3">Cancelado</h5>
                            <div class="d-flex flex-column">
                                <div class="bg-body-secondary rounded-3 px-3 py-1 mb-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="d-flex flex-column titulo mb-0">
                                            <span class="fs-5 fw-bold text-navy">Debitado</span>
                                        </p>
                                        <span class="fs-4 text-navy fw-bold" id="debitado">0.00</span>
                                    </div>
                                </div>
                                <div class="bg-body-secondary rounded-3 px-3 py-1 mb-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="d-flex flex-column titulo mb-0">
                                            <span class="fs-5 fw-bold text-navy">Diferencia</span>
                                        </p>
                                        <span class="fs-4 text-navy fw-bold" id="diferencia">0.00</span>
                                    </div>
                                </div>
                                <div class="bg-body-secondary rounded-3 px-3 py-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="d-flex flex-column titulo mb-0">
                                            <span class="fs-5 fw-bold text-navy">Vuelto</span>
                                        </p>
                                        <span class="fs-4 text-navy fw-bold" id="vuelto">0.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TIMBRE MOVIL -->
            <div class="tab-pane fade" id="pills-tmovil" role="tabpanel" aria-labelledby="pills-tmovil-tab" tabindex="0">
                
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="content_timbre_impreso">
                <div class="modal-header">
                    <!-- <i class='bx bx-error-circle fs-2  me-2'></i> -->
                    <h1 class="modal-title fs-5 fw-bold text-navy">Timbre Fiscal</h1>
                </div>
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    <div class="">
                        <div class="row d-flex align-items-center">
                            <div class="col-lg-8">
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

                                <!-- datos de la venta -->
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

                            <!--  -->

                            <div class="col-lg-4">
                                <div class="d-flex justify-content-center">
                                    <img src="{{asset('assets/timbre.png')}}" class="img-fluid mt-3" alt="" width="180px">
                                </div>

                                <div class="text-end mt-3">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#modal_papel_dañado">¿Papel dañado?</a>
                                </div>
                            </div>
                        </div>

                        <!-- cerrar modal -->
                        <div class="d-flex justify-content-center my-3">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Listo</button>
                        </div>
                    </div>
                    
                </div>
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
            ///////////////////////////////////////AGREGAR CAMPOS A OTRO(S) PAGO
            var maxFieldTramite = 4; //Input fields increment limitation
            var c = 1; //Initial field counter is 1

            $(document).on('click', '.add_button_tramite', function(e){ //Once add button is clicked
                if(c < maxFieldTramite){ //Check maximum number of input fields
                    c++; //Increment field counter
                    $('.tramites').append('<div class="d-flex justify-content-center ">'+
                                        '<div class="row w-100 mt-2">'+
                                            '<div class="col-sm-3">'+
                                                '<label class="form-label" for="ente">Ente</label><span class="text-danger">*</span>'+
                                                '<select class="form-select form-select-sm ente" nro="'+c+'">'+
                                                    '@foreach ($entes as $ente)'+
                                                        '<option value="{{$ente->id_ente}}">{{$ente->ente}}</option>'+
                                                    '@endforeach'+
                                                    
                                                '</select>'+
                                            '</div>'+
                                            '<div class="col-sm-6">'+
                                                '<label class="form-label" for="tramite">Tramite</label><span class="text-danger">*</span>'+
                                                '<select class="form-select form-select-sm tramite" name="tramite[]" nro="'+c+'" id="tramite_'+c+'" required>'+
                                                    '<option value="">Seleccione el tramite </option>'+
                                                        '@foreach ($tramites as $tramite)'+
                                                            '<option value="{{$tramite->id_tramite}}">{{$tramite->tramite}}</option>'+
                                                        '@endforeach'+
                                                '</select>'+
                                            '</div>'+
                                            '<div class="col-sm-2">'+
                                                '<label class="form-label" for="ucd_tramite">UCD</label><span class="text-danger">*</span>'+
                                                '<input type="text" class="form-control form-control-sm ucd_tramite" id="ucd_tramite_'+c+'" disabled>'+
                                            '</div>'+
                                            '<div class="col-sm-1 pt-4">'+
                                                '<a  href="javascript:void(0);" class="btn remove_button_tramite" >'+
                                                    '<i class="bx bx-x fs-4"></i>'+
                                                '</a>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'); // Add field html
                }
            });

            $(document).on('click', '.remove_button_tramite', function(e){ //Once remove button is clicked
                e.preventDefault();
                $(this).parent('div').parent('div').remove(); //Remove field html
                c--; //Decrement field counter
            });
            ///////////////////////////////////////////////////////////////////


            ///////////////////////////////////////AGREGAR CAMPOS A OTRO(S) PAGO
                var maxFieldPago = 2; //Input fields increment limitation
                var x = 1; //Initial field counter is 1

                $(document).on('click', '.add_button', function(e){ //Once add button is clicked
                    if(x < maxFieldPago){ //Check maximum number of input fields
                        x++; //Increment field counter
                        $('.pago_timbre').append('<div class="d-flex justify-content-center mt-2" >'+
                            '<div class="row w-100">'+
                                '<div class="col-sm-4">'+
                                    '<label class="form-label" for="">Metodo de Pago</label><span class="text-danger">*</span>'+
                                    '<select class="form-select form-select-sm metodo" name="metodo_two" >'+
                                        '<option value="">Punto</option>'+
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-3">'+
                                    '<label class="form-label" for="">No. Comprobante</label><span class="text-danger">*</span>'+
                                    '<input type="number" class="form-control form-control-sm comprobante" name="comprobante_two" required>'+
                                '</div>'+
                                '<div class="col-sm-4">'+
                                    '<label class="form-label" for="">Monto Debitado </label><span class="text-danger">*</span>'+
                                    '<input type="number" step="0.01" id="debitado_2" class="form-control form-control-sm debitado" name="debitado_two"  required>'+
                                '</div>'+
                                '<div class="col-sm-1  pt-4">'+
                                    '<a  href="javascript:void(0);" class="btn remove_button" >'+
                                        '<i class="bx bx-x fs-4"></i>'+
                                    '</a>'+
                                '</div>'+
                            '</div>'+
                        '</div>'); // Add field html
                    }
                });

                $(document).on('click', '.remove_button', function(e){ //Once remove button is clicked
                    e.preventDefault();
                    $(this).parent('div').parent('div').remove(); //Remove field html
                    x--; //Decrement field counter
                });
            ///////////////////////////////////////////////////////////////////

            //////////////////////////// BUSCAR CONTRIBUYENTE
            $(document).on('keyup','#identidad_nro', function(e) {
                e.preventDefault(); 
                var value = $(this).val();
                var condicion = $('#identidad_condicion').val();

                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("venta.search") }}',
                    data: {value:value,condicion:condicion},
                    success: function(response) {
                        // console.log(response);               
                        if (response.success) {
                            $('#btns_add_contribuyente').addClass('d-none');
                            $('#nombre').val(response.nombre);
                            $('#nombre').attr('disabled', true);

                            $('.ente').attr('disabled', false);
                            $('.tramite').attr('disabled', false);

                            $('.metodo').attr('disabled', false);
                            $('.comprobante').attr('disabled', false);
                            $('.debitado').attr('disabled', false);

                            $('.add_button_tramite').removeClass('disabled');
                            $('.add_button').removeClass('disabled');

                            $('#btn_submit_venta').attr('disabled', false);

                        }else{
                            $('#btns_add_contribuyente').removeClass('d-none');
                            $('#nombre').attr('disabled', false);
                            $('#nombre').val('');
                            
                            $('.ente').attr('disabled', true);
                            $('.tramite').attr('disabled', true);

                            $('.metodo').attr('disabled', true);
                            $('.comprobante').attr('disabled', true);
                            $('.debitado').attr('disabled', true);

                            $('.add_button_tramite').addClass('disabled');
                            $('.add_button').addClass('disabled');

                            $('#btn_submit_venta').attr('disabled', true);
                        }
                    },
                    error: function() {
                    }
                });
                
               
            });


            /////////////////////////// BTN CANCELAR REGISTRO CONTRIBUYENTE
            $(document).on('click','#btn_add_contribuyente', function(e) {
                e.preventDefault();
                var condicion = $('#identidad_condicion').val();
                var nro = $('#identidad_nro').val();
                var nombre = $('#nombre').val();

                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("venta.add_contribuyente") }}',
                    data: {condicion:condicion,nro:nro,nombre:nombre},
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            $('#nombre').attr('disabled', true);
                            $('#btns_add_contribuyente').addClass('d-none');
                            alert('REGISTRO DE CONTRIBUYENTE EXITOSO.');
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


            //////////////////////////// VALOR DEL TRAMITE SELECCIONADO
            $(document).on('change','.tramite', function(e) {
                e.preventDefault(); 
                var nro =  $(this).attr('nro');
                var value = $(this).val();

                if (value == '') {
                    $('#ucd_tramite_'+nro).val('0');
                }else{
                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        type: 'POST',
                        url: '{{route("venta.ucd_tramite") }}',
                        data: {value:value},
                        success: function(response) {
                            if (response.success) {
                                $('#ucd_tramite_'+nro).val(response.valor);
                            }else{
                                ////alert
                            }   
                        },
                        error: function() {
                        }
                    });
                }
            });


            //////////////////////////// TRAMITES SEGUN EL ENTE
            $(document).on('change','.ente', function(e) {
                e.preventDefault(); 
                var nro =  $(this).attr('nro');
                var value = $(this).val();
                // var unidad = $(this).attr('unidad');
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


            //////////////////////////// VALOR DEL TRAMITE SELECCIONADO
            $(document).on('change','.tramite', function(e) {
                calcular();
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
                $('.tramite').each(function(){
                    var t = $(this).val();
                    tramites.push(t);
                });
                
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("venta.debitado") }}',
                    data: {value:value,tramites:tramites,otro_debito:otro_debito},
                    success: function(response) {
                        console.log(response);
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
            

            //////////////////////////// DESABILITAR CAMPO NO COMPROBANTE
            $(document).on('change','.metodo', function(e) {
                e.preventDefault(); 
                var value = $(this).val();
                var i = $(this).attr('i');
                console.log(value+'/'+i);
                if (value == 'efectivo') {
                    $('#comprobante_'+i).attr('disabled', true);
                    $('#comprobante_'+i).val('');
                }else{
                    $('#comprobante_'+i).attr('disabled', false);
                }
               
            });

        });

        function calcular(){
            var tramites = [];
            $('.tramite').each(function(){
                var t = $(this).val();
                tramites.push(t);
            });

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("venta.total") }}',
                data: {tramites:tramites},
                success: function(response) {
                    // console.log(response);
                    $('#ucd').html(response.ucd);
                    $('#bolivares').html(response.bolivares);
                    $('#diferencia').html(response.bolivares);

                    $('.debitado').val('');
                    $('.comprobante').val('');

                    $('#debitado').html('0.00');
                    $('#vuelto').html('0.00');
                    
                },
                error: function() {
                }
            });

            // console.log(tramites);
        }

        function ventaF14(){
            var formData = new FormData(document.getElementById("form_venta_f14"));
            // console.log("alo");
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url:'{{route("venta.venta_f14") }}',
                type:'POST',
                contentType:false,
                cache:false,
                processData:false,
                async: true,
                data: formData,
                success: function(response){
                    console.log(response);
                    if (response.success) {
                       
                    }else{
                        alert(response.nota);
                    }
                },
                error: function(error){
                    
                }
            });
        }

    </script>
  
@stop