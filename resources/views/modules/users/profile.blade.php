@extends('welcome')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Gestor de Perfil</h1>
        </section>

        <section class="content">
            <div class="box">
                
                <div class="box-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control input-lg" name="name" required value="{{ auth()->user()->name }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">@</span>
                                <input type="email" class="form-control input-lg" name="email" required value="{{ auth()->user()->email }}">
                            </div>
                            @error('email')
                                <p class="alert alert-danger">El email ya se encuentra registrado</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input type="password" class="form-control input-lg" name="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="file" name="profilePhoto" id="">
                            <br>
                            @if (auth()->user()->photo)
                                <img src="{{ url('storage/'.auth()->user()->photo) }}" alt="" width="150px;" height="150px">
                            @else
                                <img src="{{ url('storage/users/anonymous.png') }}" alt="" width="150px;" height="150px">    
                            @endif
                            
                        </div>
                        <div class="box-footer">
                            <button class="btn btn-success pull-right" type="subnmit">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>


@endsection