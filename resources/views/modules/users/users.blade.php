@extends('welcome')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Gestor de Usuarios</h1>
        </section>

        <section class="content">
            <div class="box">
                <div class="box-header with-border">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalcreateUser">Crear Usuario</button>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped table-hover dt-responsive">
                        <thead>
                            <tr>
                                <th style="width: 10px;">#</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Foto</th>
                                <th>Sucursal</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th>Último login</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if ($user->photo != '')
                                            <img src="{{ url('storage/'.$user->photo) }}" alt="" class="img-thumbnail" width="40px">
                                        @else
                                            <img src="{{ url('storage/users/anonymous.png') }}" alt="" class="img-thumbnail" width="40px">
                                        @endif
                                    </td>
                                    <td>{{ $user->branch->name }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>
                                        @if ($user->status)
                                            <button class="btn btn-success btn-xs">Activo</button>
                                        @else
                                            <button class="btn btn-danger btn-xs">Inactivo</button>
                                        @endif
                                    </td>
                                    <td>{{ $user->last_login }}</td>
                                    <td>
                                        @if ($user->status)
                                            <button class="btn btn-warning btnEditBranch" data-toggle="modal" data-target="#modalEditBranch" branchId="{{ $user->id }}" >
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                        @endif
                                        
                                        <a href="cambiar-estado-sucursal/{{ $user->id }}">
                                            <button class="btn btn-danger">{{ $user->status ? 'Deshabilitar' : 'Habilitar' }}</button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" id="modalcreateUser">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="POST">
                    @csrf
                    <div class="modal-header" style="background: #3c8dbc; color: white;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Crear Usuario</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" name="name" id="name" placeholder="Ingresar el nombre del Usuario" class="form-control input-lg" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">@</span>
                                <input type="email" name="email" id="email" placeholder="Ingresar el email del Usuario" class="form-control input-lg" required>
                            </div>
                            @error('email')
                                <p class="alert alert-danger">El Email ya se encuentra registrado!</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input type="password" name="password" id="" placeholder="Ingresar la contraseña del Usuario" class="form-control input-lg" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                                <select name="role" id="" class="form-control input-lg selectRole">
                                    <option value="">Seleccionar Rol</option>
                                    <option value="Administrator">Administrador</option>
                                    <option value="Manager">Encargado</option>
                                    <option value="Seller">Vendedor</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group selectBranch" style="display: none;">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-building"></i></span>
                                <select name="branch_id" id="" class="form-control input-lg">
                                    <option value="0">Seleccionar Sucursal</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
                        <button type="submit" class="btn btn-primary">Crear Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection