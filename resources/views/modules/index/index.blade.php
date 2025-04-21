@extends('welcome')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Inicio</h1>
        </section>

        <section class="content">
            <div class="row">
                @include('modules.index.top-boxes')
            </div>

            @if (auth()->user()->role != 'Seller')
                <div class="row">
                    <div class="col-lg-12">
                        @include('modules.index.sale-chart')
                    </div>
                    <div class="col-lg-6">
                        @include('modules.index.best-selling-products-chart')
                    </div>
                    <div class="col-lg-6">
                        @include('modules.index.latest-products')
                    </div>
                </div>
            @else
            @include('modules.index.my-sales')
            @endif
        </section>
    </div>

    {{-- <div class="modal fade" id="modalAgregarSucursal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="POST">
                    @csrf
                    <div class="modal-header" style="background: #3c8dbc; color: white;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Agregar Sucursal</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-building"></i></span>
                                <input type="text" name="name" id="name" placeholder="Ingresar el nombre de Sucursal" class="form-control input-lg" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
                        <button type="submit" class="btn btn-primary">Agregar Sucursal</button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
@endsection