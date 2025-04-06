@extends('welcome')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Administrar Ventas</h1>
        </section>

        <section class="content">
            <div class="box">
                <div class="box-header with-border">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalCreateSale">Crear Nueva Venta</button>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped table-hover dt-responsive">
                        <thead>
                            <tr>
                                <th style="width: 10px;">#</th>
                                <th>Nombre</th>
                                <th>Documento</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                                <th>Dirección</th>
                                <th>Total Compras</th>
                                <th>Total Ventas</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales as $sale)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $sale->name }}</td>
                                    <td>{{ $sale->document }}</td>
                                    <td>{{ $sale->email }}</td>
                                    <td>{{ $sale->phone }}</td>
                                    <td>{{ $sale->direction }}</td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        @if ($sale->status)
                                            <button class="btn btn-warning btnEditClient" data-toggle="modal" data-target="#modalEditSale" saleId="{{ $sale->id }}" >
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <button class="btn btn-danger btnDeleteSale" saleId="{{ $sale->id }}" saleName="{{ $sale->name }}"><i class="fa fa-trash"></i></button>
                                        @endif
                                        
                                        {{-- <a href="cambiar-estado-venta/{{ $sale->id }}">
                                            <button class="btn btn-danger">{{ $sale->status ? 'Deshabilitar' : 'Habilitar' }}</button>
                                        </a> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" id="modalCreateSale">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="POST" id="frm_create_sale">
                    @csrf
                    <div class="modal-header" style="background: #3c8dbc; color: white;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Crear Nueva Venta</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                {{-- <input type="text" name="name" id="name" placeholder="Ingresar el nombre del cliente" class="form-control input-lg" required> --}}
                                <input type="hidden" name="seller_id" id="seller_id" class="form-control input-lg" value="{{ auth()->user()->id }}">
                                <input type="text" name="seller_name" id="seller_name" class="form-control input-lg" value="{{ auth()->user()->name }}" readonly>
                            </div>
                        </div>
                        <div class="form-group selectBranch">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-building"></i></span>
                                <select name="branch_id" id="branch_id" class="form-control input-lg" required>
                                    @if(auth()->user()->branch_id)
                                        <option value="">Seleccionar Sucursal</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}" 
                                                {{ auth()->user()->branch_id == $branch->id ? 'selected' : '' }}>
                                                {{ $branch->name }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="" selected disabled>Selecciona una Sucursal</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group selectBranch">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user-plus"></i></span>
                                <select name="client_id" id="client_id" class="form-control input-lg" required>
                                    <option value="">Seleccionar Cliente</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                <input type="text" name="document" id="document" placeholder="Ingresar el documento del cliente" class="form-control input-lg" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                <input type="text" name="direction" id="direction" placeholder="Ingresar la dirección del cliente" class="form-control input-lg">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>
                        <button type="submit" class="btn btn-primary">Crear Venta</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditSale">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ url('actualizar-venta') }}" method="POST" id="frm_edit_sale">
                    @csrf
                    @method('put')
                    <div class="modal-header" style="background: #ffc107; color: black;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Editar Cliente</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" name="name" id="editName" placeholder="Ingresar el nombre del cliente" class="form-control input-lg" required>
                                <input type="hidden" name="id" id="idEdit" class="form-control input-lg" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                <input type="text" name="document" id="editDocument" placeholder="Ingresar el documento del cliente" class="form-control input-lg" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input type="email" name="email" id="editEmail" placeholder="Ingresar el email del cliente" class="form-control input-lg" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                <input type="text" name="phone" id="editPhone" data-mask data-inputmask="'mask': '(999) 999-999-99'" placeholder="Ingresar el teléfono del cliente" class="form-control input-lg" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                <input type="text" name="direction" id="editDirection" placeholder="Ingresar la dirección del cliente" class="form-control input-lg">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" name="birth_date" id="editBirthDate" data-mask data-inputmask="'alias': 'yyyy/mm/dd'" placeholder="Ingresar la fecha de nacimiento del cliente" class="form-control input-lg">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning">Editar Cliente</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection