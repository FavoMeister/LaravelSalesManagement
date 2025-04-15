@extends('welcome')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Administrar Venta - {{ $sale->code }}</h1>
        </section>

        <section class="content">
            <div class="row">
                {{-- Sale Fomr --}}
                <div class="col-lg-5 col-xs-12">
                    <div class="box box-success">
                        <div class="box-header with-border"></div>
                        <div class="box-body">
                            <div class="box">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                        <input type="text" name="" id="" class="form-control" readonly value="{{ $sale->user->name }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                        <input type="text" name="" id="" class="form-control" readonly value="{{ $sale->code }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user-plus"></i></span>
                                        <input type="text" name="" id="" class="form-control" readonly value="{{ $sale->client->name }}">
                                    </div>
                                </div>
                                <div class="form-group row saleProducts">
                                    <input type="hidden" id="saleId" value="{{ $sale->id }}">
                                    <input type="hidden" id="url" value="{{ url('') }}">
                                    <input type="hidden" id="status" value="{{ $sale->status }}">
                                    
                                </div>

                                <button class="btn btn-default hidden-lg" data-toggle="modal" data-target="#modalAddProductToSale">Agregar Producto</button>

                                <hr>
                                <div class="row">
                                    <div class="col-xs-8 pull-right">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Impuesto</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="width: 50%">
                                                        <div class="input-group">
                                                            <input type="number" name="" id="newTaxSale" class="form-control input-lg" min="0" 
                                                            value="{{ $sale->tax }}" @if($sale->status == 'Finallizada') readonly @endif placeholder="0" required>

                                                            <input type="hidden" id="newNetPrice">
                                                        </div>
                                                    </td>
                                                    <td style="width: 50%">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                                                            <input type="number" id="newTotalPrice" class="form-control input-lg" min="0" placeholder="0000" readonly>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                </div>
                                <hr>
                                <div class="form-group row">
                                    @if ($sale->status != 'Finalizada')
                                        <div class="col-xs-6" style="padding-right: 0px;">
                                            <div class="input-group">
                                                <select name="" id="newPaymentMethod" class="form-control" required>
                                                    <option value="">Seleccione Método de Pago</option>
                                                    <option value="cash">Efectivo</option>
                                                    <option value="cc">Tarjeta de Crédito</option>
                                                    <option value="dc">Tarjeta de Débito</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="paymentMethodBoxes">

                                        </div>
                                        
                                    @else
                                        <div class="col-xs-12" style="padding-right: 0px">
                                            <h4>Método de Pago: <b>{{ $sale->payment_method }}</b></h4>
                                        </div>
                                    @endif
                                    
                                </div>
                                <br>
                            </div>
                        </div>
                        @if ($sale->status != "Finalizada")
                            <div class="box-footer" id="btnEndSale" style="display: none;">
                                <button class="btn btn-success">Finalizar Venta</button>
                            </div>
                        @else
                            
                        @endif
                        
                    </div>
                </div>
                {{-- Products --}}
                <div class="col-lg-7 hidden-md hidden-sm hidden-xs">
                    <div class="box box-warning">
                        <div class="box-header with-border"></div>
                        <div class="box-body">
                            <table class="table table-bordered table-striped table-hover dt-responsive">
                                <thead>
                                    <tr>
                                        <th style="width: 10px;">#</th>
                                        <th>Imágen</th>
                                        <th>Código</th>
                                        <th>Descripción</th>
                                        <th>Stock</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>
                                                @if ($product->image != '')
                                                    <img src="{{ url('storage/'.$product->image) }}" alt="" class="img-thumbnail" width="40px">
                                                @else
                                                    <img src="{{ url('storage/products/default.png') }}" alt="" class="img-thumbnail" width="40px">
                                                @endif
                                            </td>
                                            <td>{{ $product->code }}</td>
                                            <td>{{ $product->name . ' ' . $product->description }}</td>
                                            <td>
                                                @if ($product->stock <= 10)
                                                    <button class="btn btn-danger">{{ $product->stock }}</button>
                                                @elseif ($product->stock >= 11 && $product->stock <= 15)
                                                    <button class="btn btn-warning">{{ $product->stock }}</button>
                                                @else
                                                    <button class="btn btn-success">{{ $product->stock }}</button>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($sale->status != 'Finalizada')
                                                    @if ($product->stock > 0)
                                                        @if (in_array($product->id, $addedProductIds))
                                                            <button class="btn btn-default disabled" id="product-{{ $product->id }}">Agregar</button>
                                                        @else
                                                            <button class="btn btn-primary addProduct" productId="{{ $product->id }}" id="product-{{ $product->id }}">Agregar</button>
                                                        @endif
                                                        
                                                    @else
                                                        <button class="btn btn-default disabled" id="product-{{ $product->id }}">Agregar</button>
                                                    @endif
                                                @else
                                                    
                                                @endif
                                                
                                            </td>
                                        
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
        </section>
    </div>

    <div class="modal fade" id="modalAddProductToSale">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="POST" id="frm_create_client">
                    @csrf
                    <div class="modal-header" style="background: #3c8dbc; color: white;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Agregar Producto a la Venta</h4>
                    </div>
                    <div class="modal-body">
                        <div class="box-body">
                            <table class="table table-bordered table-striped table-hover dt-responsive">
                                <thead>
                                    <tr>
                                        <th style="width: 10px;">#</th>
                                        <th>Imágen</th>
                                        <th>Código</th>
                                        <th>Descripción</th>
                                        <th>Stock</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>
                                                @if ($product->image != '')
                                                    <img src="{{ url('storage/'.$product->image) }}" alt="" class="img-thumbnail" width="40px">
                                                @else
                                                    <img src="{{ url('storage/products/default.png') }}" alt="" class="img-thumbnail" width="40px">
                                                @endif
                                            </td>
                                            <td>{{ $product->code }}</td>
                                            <td>{{ $product->name . ' ' . $product->description }}</td>
                                            <td>
                                                @if ($product->stock <= 10)
                                                    <button class="btn btn-danger">{{ $product->stock }}</button>
                                                @elseif ($product->stock >= 11 && $product->stock <= 15)
                                                    <button class="btn btn-warning">{{ $product->stock }}</button>
                                                @else
                                                    <button class="btn btn-success">{{ $product->stock }}</button>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($sale->status != 'Finalizada')
                                                    @if ($product->stock > 0)
                                                        @if (in_array($product->id, $addedProductIds))
                                                            <button class="btn btn-default disabled" id="modalProduct-{{ $product->id }}">Agregar</button>
                                                        @else
                                                            <button class="btn btn-primary addProduct" productId="{{ $product->id }}" id="modalProduct-{{ $product->id }}">Agregar</button>
                                                        @endif
                                                        
                                                    @else
                                                        <button class="btn btn-default disabled" id="modalProduct-{{ $product->id }}">Agregar</button>
                                                    @endif
                                                @else
                                                    
                                                @endif
                                                
                                            </td>
                                        
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditClient">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ url('actualizar-cliente') }}" method="POST" id="frm_edit_client">
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