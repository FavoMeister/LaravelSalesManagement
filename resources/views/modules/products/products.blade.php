@extends('welcome')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Productos</h1>
        </section>

        <section class="content">
            <div class="box">
                <div class="box-header with-border">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalCreateProduct">Agregar Producto</button>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped table-hover dt-responsive">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>
                                        @if ($product->status)
                                            <button class="btn btn-warning btnEditCategory" data-toggle="modal" data-target="#modalEditCategory" categoryId="{{ $product->id }}" >
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <button class="btn btn-danger btnDeleteCategory" categoryId="{{ $product->id }}" categoryName="{{ $product->name }}"><i class="fa fa-trash"></i></button>
                                        @endif
                                        
                                        {{-- <a href="cambiar-estado-categoria/{{ $product->id }}">
                                            <button class="btn btn-danger">{{ $product->status ? 'Deshabilitar' : 'Habilitar' }}</button>
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

    <div class="modal fade" id="modalCreateProduct">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="POST">
                    @csrf
                    <div class="modal-header" style="background: #3c8dbc; color: white;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Agregar Producto</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cube"></i></span>
                                <input type="text" name="name" id="name" placeholder="Ingresar el nombre del producto" class="form-control input-lg" required>
                            </div>
                        </div>
                        <div class="form-group selectCategory">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-building"></i></span>
                                <select name="category_id" id="category_id" class="form-control input-lg" required>
                                    <option value="">Seleccionar Categoría</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-code"></i></span>
                                <input type="text" name="code" id="productCode" placeholder="Código del producto" class="form-control input-lg" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>
                                <input type="text" name="description" id="description" placeholder="Ingresar la descripción del producto" class="form-control input-lg" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-check"></i></span>
                                <input type="number" min="0" name="stock" id="stock" placeholder="Ingresar el stock del producto" class="form-control input-lg" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-xs-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span>
                                    <input type="number" name="purchase_price" min="0" id="purchasePrice" placeholder="Precio de compra del producto" class="form-control input-lg" required>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span>
                                    <input type="number" name="selling_price" min="0" id="sellingPrice" placeholder="Precio de venta del producto" class="form-control input-lg" required>
                                </div>
                            
                                <br>
                                <div class="col-xs-6">
                                    <div class="input-group">
                                        <label for="">
                                            <input type="checkbox" name="" id="" class="minimal percentage" checked>
                                            Utilizar Porcentage
                                        </label>
                                    </div>
                                </div>
                                <div class="col-xs-6" style="padding: 0;">
                                    <div class="input-group">
                                        <input type="number" name="" min="0" id="percentageValue" class="form-control input-lg percentageValue" required value="40">
                                        <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="panel">Subir Imágen</div>
                                <input type="file" name="image" id="image">
                                <img src="{{ url('storage/products/default.png') }}" alt="" class="img-thumbnail" width="100px">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>
                        <button type="submit" class="btn btn-primary">Agregar Producto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditCategory">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ url('actualizar-categoria') }}" method="POST">
                    @csrf
                    @method('put')
                    <div class="modal-header" style="background: #ffc107; color: black;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Editar Categoría</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                <input type="text" name="name" id="editName" placeholder="Nombre" class="form-control input-lg" required>
                                <input type="hidden" name="id" id="idEdit" class="form-control input-lg" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning">Editar Categoría</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection