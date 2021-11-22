@extends('layouts.plantillabase')
@section('contenido')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <form method="POST" action="{{ route('usuarios.update', $usuarios->id) }}" class="form-horizontal">
          @csrf
          @method('PUT')
          <div class="card">
            <!--Header-->
            <div class="card-header card-header-warning">
              <h4 class="card-title">Editar Usuario</h4><br><br><br>
              <p class="card-category">Editar datos del Usuario</p>
            </div>
            <!--End header-->
            <!--Body-->
            <div class="card-body">
                <div class="row">
                    <label for="nombre" class="col-sm-2 col-form-label">Nombre del Usuario</label>
                    <div class="col-sm-7">
                        <div class="form-group">
                            <input type="text" class="form-control" name="nombre" value="{{ old('name', $usuarios->name) }}" autocomplete="off" autofocus>
                            @if ($errors->has('nombre'))
                            <span class="error text-danger" for="input-nombre">{{ $errors->first('nombre') }}</span>
                        @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label for="nombre" class="col-sm-2 col-form-label">Correo</label>
                    <div class="col-sm-7">
                        <div class="form-group">
                            <input type="text" class="form-control" name="email" autocomplete="off" autofocus>
                            @if ($errors->has('email'))
                            <span class="error text-danger" for="input-nombre">{{ $errors->first('nombre') }}</span>
                        @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label for="nombre" class="col-sm-2 col-form-label">Telefono</label>
                    <div class="col-sm-7">
                        <div class="form-group">
                            <input type="text" class="form-control" name="telefono" autocomplete="off" autofocus>
                            @if ($errors->has('telefono'))
                            <span class="error text-danger" for="input-nombre">{{ $errors->first('nombre') }}</span>
                        @endif
                        </div>
                    </div>
                </div>
            </div>
            <!--End body-->
            <!--Footer-->
            <div class="card-footer ml-auto mr-auto">
              <button type="submit" class="btn btn-warning">Actualizar</button>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-danger" href="{{route('roles.index')}}">
                  <i class="material-icons"></i>Cancelar</a>
            </div>
          </div>
          <!--End footer-->
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
