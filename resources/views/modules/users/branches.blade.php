@extends('welcome')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Sucursales</h1>
        </section>

        <section class="content">
            <div class="box">
                <div class="box-header with-border">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarSucursal">Agregar Sucursal</button>
                </div>
                <div class="box-body">

                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" id="modalAgregarSucursal">
        <div class="modal-dialog">
            <form action="" method="POST">
                @csrf
                <div class="modal-header" style="background: #3c8dbc; color: white;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Agreagar Sucursal</h4>
                </div>
                <div class="modal-content">
                    <div class="box-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-building"></i></span>
                                <input type="text" name="name" id="name" placeholder="Ingresar el nombre de Scursal" class="form-control input-lg" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger pull-left" type="button" data-dismiss="modal">Salir</button>
                    <button class="btn btn-primary pull-left" type="submit">Agregar Sucursal</button>
                </div>
            </form>
        </div>
    </div>
@endsection