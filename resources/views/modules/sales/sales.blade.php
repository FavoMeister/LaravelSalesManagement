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
                                <th>Código</th>
                                <th>Cliente</th>
                                <th>Vendedor</th>
                                <th>Forma de <br> Pago</th>
                                <th>Impuesto <br> Neto</th>
                                <th>Total</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales as $sale)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $sale->code }}</td>
                                    <td>{{ $sale->client->name }}</td>
                                    <td>{{ $sale->user->name }}</td>
                                    <td>{{ $sale->payment_method }}</td>
                                    <td>$ {{ number_format($sale->net_tax, 2, '.', ',') }}</td>
                                    <td>$ {{ number_format($sale->total, 2, '.', ',') }}</td>
                                    <td>{{ $sale->sale_date }}</td>
                                    <td>
                                        <a href="{{ url('venta/'. $sale->id) }}">
                                            <button class="btn btn-primary">Administrar</button>
                                        </a>
                                        @if ($sale->status != "Finalizada")
                                            <button class="btn btn-danger btnDeleteSale" saleId="{{ $sale->id }}" saleCode="{{ $sale->code }}"><i class="fa fa-trash"></i></button>
                                        @else
                                            <a href="{{ url('Factura/'. $sale->id) }}" target="_blanck">
                                                <button class="btn btn-info"><i class="fa fa-print"></i></button>
                                            </a>
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>
                        <button type="submit" class="btn btn-primary">Crear Venta</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection