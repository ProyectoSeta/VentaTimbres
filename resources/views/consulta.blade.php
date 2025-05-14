@extends('adminlte::page')

@section('title', 'Consulta')


@section('content')
    


    <main>
        <div class="my-4">
           <h1 class="display-6 text-navy text-center fw-bold">Consultar Timbre Fiscal</h1> 
        </div>
        <div class="d-flex flex-column align-items-center justify-content-center">
            <!-- btns -->
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist" style="font-size:15px">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-tfe-tab" data-bs-toggle="pill" data-bs-target="#pills-tfe" type="button" role="tab" aria-controls="pills-tfe" aria-selected="true">TFE14</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-estampilla-tab" data-bs-toggle="pill" data-bs-target="#pills-estampilla" type="button" role="tab" aria-controls="pills-estampilla" aria-selected="false">Estampilla</button>
                </li>
            </ul>

            <!-- content -->
            <div class="tab-content" id="pills-tabContent" style="font-size:13px">
                <!-- FORM SEARCH TFE14 -->
                <div class="tab-pane fade show active" id="pills-tfe" role="tabpanel" aria-labelledby="pills-tfe-tab" tabindex="0">
                    <form action="">
                        <label for="timbre" class="form-label"><span class="text-danger">*</span> Ingresa el número de timbre (Correlativo de papel) o serial como se muestra en la imagen.</label>
                        <div class="d-flex mb-0 pb-0">
                            <input type="text" id="timbre" class="form-control">
                            <button type="submit" class="btn btn-primary mb-3 ms-3"> <i class=" bx bx-search-alt"></i> </button>
                        </div>
                        <span class="text-muted">El número de timbre o serial debe estar sin guión o algun carecter especial.</span>
                    </form>
                </div>


                <!-- FORM SEARCH ESTAMPILLAS -->
                <div class="tab-pane fade" id="pills-estampilla" role="tabpanel" aria-labelledby="pills-estampilla-tab" tabindex="0">

                </div>
            </div>
        </div>
        
        <!-- <h3 class="fw-normal text-muted mb-3 titulo">Ingresa el nímero de Timbre (Correlativo de Papel)</h3> -->

        

        <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-white container-fluid bg_arqueo" style="background-image: url({{asset('assets/fondo2.png')}});">
            <div class="p-lg-5 mx-auto my-5">
                <div class="row">
                    <div class="col-lg-4">

                    </div>
                    <div class="col-lg-4">

                    </div>
                    <div class="col-lg-4">

                    </div>
                </div>
                
                
                   
                

                
            </div>

            

            
        </div>


        <!-- <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-white">
            <div class="p-lg-5 mx-auto my-5">
                <h1 class="display-5 fw-bold text-navy">FORMA 01 | Venta Online</h1>
                <h3 class="fw-normal text-muted mb-3">Venta de Timbres Fiscales</h3>
                <div class="d-flex gap-3 justify-content-center fw-normal titulo" style="font-size:12.7px">
                    <button type="button btn-sm" class="btn btn-primary  py-1">Ver</button>
                </div>
            </div>
        </div> -->


                 
        <!-- <div class="row g-0">
            <div class="col-md-6">
                <div class="bg-body-tertiary me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden">
                    <div class="my-3 py-3">
                        <h2 class="display-5">FORMA 14</h2>
                        <p class="lead">Timbre Fiscal Electrónico.</p>
                    </div>
                    <img src="{{asset('assets/timbre.svg')}}" class="shadow-sm mx-auto img-fluid" alt="" style="width: 80%; height: 300px;">
                    
                </div>
            </div>
            <div class="col-md-6">
                <div class="bg-body-tertiary me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden" role="button">
                    <div class="my-3 p-3">
                        <h2 class="display-5">Estampilla</h2>
                        <p class="lead">Timbre Movil.</p>
                    </div>
                    <div class="bg-dark shadow-sm mx-auto" style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;"></div>
                </div>
            </div>
        </div> -->

    </main>
    
<!-- *********************************  MODALES ******************************* -->
    <!-- ************ APERTURA DE TAQUILLA ************** -->
    <div class="modal fade" id="modal_apertura_taquilla" tabindex="-1" aria-hidden="true"  data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content" id="content_apertura_taquillas">
                <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-lock-open-alt fs-2 text-muted me-2"></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Apertura Taquilla</h1>
                    </div>
                </div> 
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    <form id="form_aperturar_taquilla" method="post" onsubmit="event.preventDefault(); aperturaTaquilla()">
                        
                        <label for="clave" class="form-label"><span class="text-danger">* </span>Ingrese la clave de seguridad de la Taquilla:</label>
                        <input type="password" id="clave" class="form-control form-control-sm" name="clave" required>

                        <p class="text-muted text-end"><span style="color:red">*</span> Campos requeridos.</p>

                        <div class="d-flex justify-content-center mt-3 mb-3">
                            <button type="button" class="btn btn-secondary btn-sm me-2" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success btn-sm">Aperturar</button>
                        </div>
                    </form>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>



    


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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        $(document).ready(function () {
           
        });

        


    </script>
  
@stop