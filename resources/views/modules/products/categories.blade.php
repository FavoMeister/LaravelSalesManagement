@extends('welcome')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Categorías</h1>
        </section>

        <section class="content">
            <div class="box">
                <div class="box-header with-border">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalcreateCategory">Agregar Categoría</button>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped table-hover dt-responsive">
                        <thead>
                            <tr>
                                <th style="width: 10px;">#</th>
                                <th>Nombre</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        @if ($category->status)
                                            <button class="btn btn-warning btnEditCategory" data-toggle="modal" data-target="#modalEditCategory" categoryId="{{ $category->id }}" >
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <button class="btn btn-danger btnDeleteCategory" categoryId="{{ $category->id }}" categoryName="{{ $category->name }}"><i class="fa fa-trash"></i></button>
                                        @endif
                                        
                                        {{-- <a href="cambiar-estado-categoria/{{ $category->id }}">
                                            <button class="btn btn-danger">{{ $category->status ? 'Deshabilitar' : 'Habilitar' }}</button>
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

    <div class="modal fade" id="modalcreateCategory">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="POST">
                    @csrf
                    <div class="modal-header" style="background: #3c8dbc; color: white;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Agregar Categoría</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                <input type="text" name="name" id="name" placeholder="Ingresar el nombre de la categoría" class="form-control input-lg" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
                        <button type="submit" class="btn btn-primary">Agregar Categoría</button>
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
                                <span class="input-group-addon pull-left"><i class="fa fa-th"></i></span>
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