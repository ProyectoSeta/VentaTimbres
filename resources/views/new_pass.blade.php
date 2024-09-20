@extends('adminlte::page')

@section('title', 'Configuración')

@section('content_header')
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
@stop

@section('content')
    <div class="container rounded-4 p-3 pt-1" style="background-color:#ffff;">
        <div class="d-flex justify-content-center align-items-center mb-4">
            <!-- <h3 class=" text-navy titulo me-3">Actualización de Datos</h3> -->

            <div class="text-center">
                <img src="{{asset('assets/icon-user.svg')}}" class="rounded-circle mb-3" style="width:12%" alt="...">
                <h5 class="text-navy mb-0 fw-bold titulo">ARAGUA MINAS Y CANTERAS (ARAMICA) S.A.</h5>
                <span class="text-muted">G-200108240</span>
            </div>
        </div> 
        <div class="d-flex justify-content-center">
            <div class="w-50" style="font-size:13px">
                <div class="row border-bottom pb-3">
                    <div class="col-sm-2">
                        <div class="d-flex justify-content-center align-items-center">
                            <i class='bx bx-key text-muted' style="font-size:40px"></i>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <h6 class="fw-bold">Contraseña</h6>
                        <p>Actualizar la contraseña cada periodo de tiempo ayuda a que su cuenta sea más segura.</p>
                        <p class="text-end text-secondary fw-bold">
                            Ultima actualización: <span class="text-success">{{$update->fecha}}</span>
                        </p>
                        <div class="d-flex justify-content-end">
                            <buttom class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#modal_update_pass">Actualizar</buttom>
                        </div>
                    </div>
                </div>

                <div class="row border-bottom py-3">
                    <div class="col-sm-2">
                        <div class="d-flex justify-content-center align-items-center">
                            <i class='bx bx-detail text-muted' style="font-size:40px"></i>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <h6 class="fw-bold">Información Fiscal</h6>
                        <p>Cumple con los deberes formales como contribuyente del estado, con tu información fiscal actualizada.</p>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('actualizar_datos') }}" class="btn btn-sm btn-secondary">Verificar</a>
                        </div>
                    </div>
                </div>

                <div class="row  border-bottom py-3">
                    <div class="col-sm-2">
                        <div class="d-flex justify-content-center align-items-center">
                            <i class='bx bx-hard-hat text-muted' style="font-size:40px"></i> 
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <h6 class="fw-bold">Canteras y/o Desazolves Registrados</h6>
                        <p>Verifica las canteras y/o desazolves adjudicados a la empresa, y continua con el proceso relacionado a las Guías de Circulación de los Minerales no Metálicos.</p>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('cantera') }}" class="btn btn-sm btn-secondary">Verificar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

        

        







    </div>
    

    
    
<!--****************** MODALES **************************-->
    <!-- ********* ACTUALIZAR CONTRASEÑA ******** -->
    <div class="modal fade" id="modal_update_pass" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_update_pass">
                <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-refresh bx-spin  fs-1" style="color:#0d8a01"></i>                 
                        <h1 class="modal-title fs-5 text-navy" id="exampleModalLabel">Nueva Contraseña</h1>
                        <div class="">
                            <h5 class="modal-title text-muted" id="" style="font-size:14px">Actualizar</h5>
                        </div>
                    </div>
                </div>
                <div class="modal-body px-4" style="font-size:13px">
                    <form id="form_update_pass" method="post" onsubmit="event.preventDefault(); updatePass()">
                        <div class="my-2">
                            <label class="form-label" for="pass_actual">Contraseña actual</label><span class="text-danger">*</span>
                            <input type="password" id="pass_actual" class="form-control form-control-sm" name="pass_actual">
                        </div>
                        <div class="my-2">
                            <label class="form-label" for="password">Nueva contraseña</label><span class="text-danger">*</span>
                            <input type="password" id="password" class="form-control form-control-sm" name="password">
                        </div>
                        
                        <div class="my-2">
                            <label class="form-label" for="confirmar_pass">Confirmar contraseña</label><span class="text-danger">*</span>
                            <input type="password" id="confirmar_pass" class="form-control form-control-sm" name="confirmar_pass">
                        </div>

                        <p class="text-muted text-end"><span style="color:red">*</span> Campos requeridos.</p>

                        <div class="text-muted my-3" style="font-size:14px">
                            <span>La Contraseña debe contener:</span>
                            <ol>
                                <li>Mínimo 8 caracteres.</li>
                                <li>Caracteres alfanuméricos.</li>
                                <li>Caracteres especiales (Ejemplo: ., @, $, *, %, !, &amp;, entre otros.).</li>
                            </ol>
                        </div>

                        
                        <div class="alert alert-danger info_error d-none">
                            
                        </div>
         

                        <div class="d-flex justify-content-center my-3 mt-4" id="btns_edit_user">
                            <button type="submit" class="btn btn-success btn-sm me-3">Actualizar</button>
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
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
   
    <script type="text/javascript">
        $(document).ready(function () {
            $('#example').DataTable(
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
        $(document).ready(function () {
            $('#modal_update_pass').modal('show');
           
           
        });

        function updatePass(){
            $('.info_error').addClass('d-none');
            var formData = new FormData(document.getElementById("form_update_pass"));
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url:'{{route("new_pass.update") }}',
                type:'POST',
                contentType:false,
                cache:false,
                processData:false,
                async: true,
                data: formData,
                success: function(response){
                    // console.log(response);
                    if (response.success) {
                        alert('ACTUALIZACIÓN DE CONTRASEÑA EXITOSO');
                        $('#modal_update_pass').modal('hide');
                    } else {
                        if (response.nota == 'errores') {
                            $('.info_error').removeClass('d-none');
                            $('.info_error').html(response.errores);
                        }else{
                            alert(response.nota);
                        }
                        
                    } 

                },
                error: function(error){
                    
                }
            });
        }

   
        
    </script>
  
@stop