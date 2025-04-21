<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Mis Ventas</h3>
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
                @foreach ($mySales as $sale)
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
                            
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>