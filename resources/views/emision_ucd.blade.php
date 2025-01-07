@extends('adminlte::page')

@section('title', 'Inventario Papel')

@section('content_header')
    
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <!-- <script src="{{asset('vendor/sweetalert.js') }}"></script>  -->
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>

    <!-- <img src="{{asset('assets/bf-1.svg')}}" class="w-100" alt="..."> -->
@stop

@section('content')
    
    <div class="container rounded-4 p-3" style="background-color:#ffff;">
        <div class="row mb-3">
            <div class="col-md-6">
               <h3 class="text-navy titulo fw-bold fs-3">Emision de Denominaciones UCD</h3> 
               <h4 class="titulo text-muted fs-3">Estampillas</h4>
            </div>
            
            <div class="col-md-6 zoom_text px-5">
                <div class="text-center mb-3">
                    <h3 class=" fs-4 fw-bold titulo text-nay " style="color: #004cbd"><span class="text-muted">Lote Papel de Seguridad | </span>Estampillas</h3>
                </div>
                <div class="">
                    <div class="row">
                        <div class="col-lg -8 d-flex flex-column">
                            <div class=" fs-4 text-navy fw-bold" >Disponible en Inventario</div>
                            <div class="text-secondary">Para emitir denominaciones UCD</div>
                        </div>
                        <div class="col-lg -4">
                            <div class="fs-2 text-primary fw-bold bg-primary-subtle text-center rounded-4  px-2">500 <span class="fs-5">Und.</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- cierra row -->


        <div class="text-center mb-3 mt-5">
            <h3 class=" fs-4 fw-bold titulo text-nay " style="color: #004cbd"><span class="text-muted">Estampillas por denominación | </span>Inventario</h3>
        </div>


        <div class="row gap-2">
            @foreach ($deno as $de)
                <div class="col border py-2 px-3 rounded-3">
                    <div class="row">
                        <div class="col-md-5">
                            <div class=" fs-4 text-navy fw-bold" >{{$de->denominacion}} UCD</div>
                            <div class="text-secondary">En Inventario</div>
                        </div>
                        <div class="col-md-7 d-flex align-items-center">
                            <div class="fs-2  fw-bold bg-dark-subtle text-center rounded-3 px-3">550 <span class="fs-5">Und.</span></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>


        <div class="d-flex justify-content-center my-4 mt-5">    
            <button type="button" class="btn bg-navy rounded-pill px-3 btn-sm fw-bold d-flex align-items-center" id="btn_emitir_ucd_estampillas" data-bs-toggle="modal" data-bs-target="#modal_emitir_ucd_estampillas">
                <i class='bx bx-plus fw-bold fs-6 pe-2'></i>
                <span>Emitir UCD Estampillas</span>
            </button>
        </div>


        <div class="table-responsive" style="font-size:12.7px">
            <table id="emisiones_ucd" class="table text-center border-light-subtle" style="font-size:12.7px">
                <thead>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Denominación</th>
                    <th>Cantidad</th>
                    <th>Detalle</th>  <!-- fecha entrega, emitidos en ucd, user -->
                    <th>Opción</th>  
                </thead>
                <tbody id="" class="border-light-subtle"> 
                        
                </tbody> 
            </table>
        </div>
        

        





        

        

    </div>
    
    

    

    
    
<!--****************** MODALES **************************-->
    <!-- ************ DETALLE LOTE: ESTAMPILLAS  ************** -->
    <div class="modal fade" id="modal_emitir_ucd_estampillas" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_detalle_lote_estampillas">
                <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-plus-circle fs-2 text-muted me-2"></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Emisión</h1>
                        <span>Estampillas | Por Denominaciones UCD </span>
                    </div>
                </div>
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    <form id="form_emitir_papel_f14" method="post" onsubmit="event.preventDefault(); emitirPapelF14()">
                        <div class="d-flex justify-content-center">
                            <div class="row">
                                <div class="col-lg-8 d-flex flex-column">
                                    <div class="fs-6 text-navy fw-bold" >Disponible en Inventario</div>
                                    <div class="text-secondary">Para emitir denominaciones UCD</div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="fs-6 text-primary fw-bold bg-primary-subtle text-center rounded-4 px-2">5000 <span class="fs-6">Und.</span></div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center text-navy fw-bold titulo my-3">Emisión</div>
                        
                        <div id="row_emision_ucd">
                            <div class="row">
                                <div class="col-sm-5">
                                    <label for="ucd" class="form-label">Denominación: <span class="text-danger">*</span></label>

                                </div>
                                <div class="col-sm-6">
                                    <label for="cantidad" class="form-label">Cantidad: <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control form-control-sm cantidad" id="cantidad_1" i="1" name="emitir[1][cantidad]" required>
                                </div>
                                <div class="col-md-1 pt-4">
                                    <a  href="javascript:void(0);" class="btn add_button border-0">
                                        <i class="bx bx-plus fs-4" style="color:#038ae4"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        


                        <div class="d-flex justify-content-center mt-4 mb-3">
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
            $('#emisiones_ucd').DataTable(
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