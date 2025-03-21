@extends('adminlte::page')

@section('title', 'Arqueo Taquilla')

@section('content')
    <main>
        <section id="" class="py-4">
            <!-- RECAUDACION HOY -->
            <div class="row text-center">
                <div class="col-md-6">
                    <span class="display-5">Recaudación de Hoy</span>
                </div>
                <div class="col-md-6">
                    <div class="display-6 fw-semibold">15.289.942,07 Bs.</div>
                </div>
            </div>

            <!-- EN PUNTO Y EFECTIVO -->
            <div class="row">
                <div class="col-md-6 d-flex justify-content-center align-items-center">
                    <div class="">
                        <table class="table table-sm table-borderless lh-sm">
                            <tr class="">
                                <th>Punto</th>
                                <td class="border-bottom w-25"> </td>
                                <td>6.222,00</td>
                            </tr>
                            <tr>
                                <th>Efectivo</th>
                                <td class="w-25"> <span class="border-bottom w-50"> </span> </td>
                                <td>10.008.001,70 </td>
                            </tr>
                        </table>
                    </div>
                    
                </div>
                <div class="col-md-6">

                </div>
            </div>
        </section>
    </main>

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