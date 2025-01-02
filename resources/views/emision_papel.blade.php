@extends('adminlte::page')

@section('title', 'Emisión Estampillas')

@section('content_header')
    
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <!-- <script src="{{asset('vendor/sweetalert.js') }}"></script>  -->
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>

    <!-- <img src="{{asset('assets/bf-1.svg')}}" class="w-100" alt="..."> -->
@stop

@section('content')
    
    <div class="container rounded-4 p-3" style="background-color:#ffff;">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h3 class="mb-3 text-navy titulo fw-bold">Papel de Seguridad <span class="text-secondary fs-4">| Emisión</span></h3>
            <!-- <div class="mb-3">
                <button type="button" class="btn bg-navy rounded-pill px-3 btn-sm fw-bold d-flex align-items-center" id="btn_emitir_estampillas" data-bs-toggle="modal" data-bs-target="#modal_emitir_estampillas">
                    <i class='bx bx-plus fw-bold fs-6 pe-2'></i>
                    <span>Emitir</span>
                </button>
            </div> -->
        </div>

        <ul class="nav nav-pills mb-4 d-flex justify-content-center" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-f14-tab" data-bs-toggle="pill" data-bs-target="#pills-f14" type="button" role="tab" aria-controls="pills-f14" aria-selected="true">Forma 14</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-estampillas-tab" data-bs-toggle="pill" data-bs-target="#pills-estampillas" type="button" role="tab" aria-controls="pills-estampillas" aria-selected="false">Estampillas</button>
            </li>
        </ul>

        <!-- CONTENTS -->
        <div class="tab-content" id="pills-tabContent">
            <!-- *********************   FORMA 14   ************************ -->
            <div class="tab-pane fade show active" id="pills-f14" role="tabpanel" aria-labelledby="pills-f14-tab" tabindex="0">
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn bg-navy rounded-pill px-3 btn-sm fw-bold d-flex align-items-center" id="btn_emitir_papel_f14" data-bs-toggle="modal" data-bs-target="#modal_emitir_papel_f14">
                        <i class='bx bx-plus fw-bold fs-6 pe-2'></i>
                        <span>Emitir</span>
                    </button>
                </div>

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
                            <th>Opciones</th> 
                        </thead>
                        <tbody id="" class="border-light-subtle"> 
                                           
                        </tbody> 
                    </table>
                </div>
            </div>
            
            <!-- *********************   ESTAMPILLAS   ************************ -->
            <div class="tab-pane fade" id="pills-estampillas" role="tabpanel" aria-labelledby="pills-estampillas-tab" tabindex="0">
                <div class="d-flex justify-content-center">    
                    <button type="button" class="btn bg-navy rounded-pill px-3 btn-sm fw-bold d-flex align-items-center" id="btn_emitir_papel_estampillas" data-bs-toggle="modal" data-bs-target="#modal_emitir_papel_estampillas">
                        <i class='bx bx-plus fw-bold fs-6 pe-2'></i>
                        <span>Emitir</span>
                    </button>
                </div>

                <div class="table-responsive" style="font-size:12.7px">
                    <table id="papel_estampillas_emitidos" class="table text-center border-light-subtle" style="font-size:12.7px">
                        <thead>
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Cantidad</th>
                            <th>Desde</th>
                            <th>Hasta</th>
                            <th>Detalle</th>  <!-- fecha entrega, emitidos en ucd, user -->
                            <th>Estado</th> 
                            <th>Opciones</th> 
                        </thead>
                        <tbody id="" class="border-light-subtle"> 
                                           
                        </tbody> 
                    </table>
                </div>

            </div>
        </div>

    </div>
    
    

      

    
    
<!--****************** MODALES **************************-->
    <!-- ************ EMITIR PAPEL DE SEGURIDAD: FORMA 14  ************** -->
    <div class="modal fade" id="modal_emitir_papel_f14" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_emitir_papel_f14">
                <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class='bx bx-plus-circle fs-2 text-muted me-2'></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Emisión</h1>
                        <span>Papel de Seguridad | TFE-14</span>
                    </div>
                </div> 
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    <p class="text-muted">*NOTA: Si el total de timbres fiscales a emitir 
                        es diferente al esperado o se ha cambiado el numero de timbres a producirse por emisión, 
                        dirigirse al modulo configuraciones (Papel de Seguridad) para cambiar el numero total de timbres fiscales.
                    </p>
                    
                    <div class="fw-bold text-center">
                        <p class="text-navy m-0">Total de Timbres a Emitir</p>
                        <p class="fs-5 titulo fw-semibold text-muted">1000 Timbres TFE-14 | Papel de Seguridad</p>
                    </div>
                    

                    <div class="d-flex justify-content-center my-4">
                        <table class="table table-borderess w-50">
                            <tr>
                                <th>Desde:</th>
                                <td>1</td>
                            </tr>
                            <tr>
                                <th>Hasta:</th>
                                <td>1000</td>
                            </tr>
                        </table>
                    </div>

                    <form id="form_emitir_rollos" method="post" onsubmit="event.preventDefault(); emitirPapelF14()">
                        <div class="d-flex justify-content-center mt-3 mb-3">
                            <button type="button" class="btn btn-secondary btn-sm me-2" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success btn-sm">Emitir</button>
                        </div>
                    </form>
                    
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ************ EMITIR PAPEL DE SEGURIDAD: FORMA 14  ************** -->
    <div class="modal fade" id="modal_emitir_papel_estampillas" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_emitir_papel_estampillas">
                <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class='bx bx-plus-circle fs-2 text-muted me-2'></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Emisión</h1>
                        <span>Papel de Seguridad | Estampillas</span>
                    </div>
                </div> 
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    <p class="text-muted">*NOTA: Si el total de timbres fiscales a emitir 
                        es diferente al esperado o se ha cambiado el numero de timbres a producirse por emisión, 
                        dirigirse al modulo configuraciones (Papel de Seguridad) para cambiar el numero total de timbres fiscales.
                    </p>
                    
                    <div class="fw-bold text-center">
                        <p class="text-navy m-0">Total de Timbres a Emitir</p>
                        <p class="fs-5 titulo fw-semibold text-muted">1000 Timbres Estampillas | Papel de Seguridad</p>
                    </div>
                    

                    <div class="d-flex justify-content-center my-4">
                        <table class="table table-borderess w-50">
                            <tr>
                                <th>Desde:</th>
                                <td>1</td>
                            </tr>
                            <tr>
                                <th>Hasta:</th>
                                <td>1000</td>
                            </tr>
                        </table>
                    </div>

                    <form id="form_emitir_rollos" method="post" onsubmit="event.preventDefault(); emitirPapelEstampillas()">
                        <div class="d-flex justify-content-center mt-3 mb-3">
                            <button type="button" class="btn btn-secondary btn-sm me-2" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success btn-sm">Emitir</button>
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
        // const myModal = document.getElementById('myModal');
        // const myInput = document.getElementById('myInput');

        // myModal.addEventListener('shown.bs.modal', () => {
        //     myInput.focus();
        // });
    </script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
    <script src="{{ asset('jss/datatable.min.js') }}" defer ></script>
    <script src="{{ asset('jss/datatable.bootstrap.js') }}" ></script>
    <script src="{{ asset('jss/toastr.js') }}" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" ></script>
   
    <script type="text/javascript">
        $(document).ready(function () {
            $('#papel_f14_emitidos').DataTable(
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

            $('#papel_estampillas_emitidos').DataTable(
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