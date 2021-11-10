@extends('layouts.plantillabase')
@section('contenido')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <form method="POST" action="{{ route('roles.update', $roles->id) }}" class="form-horizontal">
          @csrf
          @method('PUT')
          <div class="card">
            <!--Header-->
            <div class="card-header card-header-warning">
              <h4 class="card-title">Editar rol</h4>
              <p class="card-category">Editar datos del rol</p>
            </div>
            <!--End header-->
            <!--Body-->
            <div class="card-body">
              <div class="row">
                <label for="nombre" class="col-sm-2 col-form-label">Nombre del rol</label>
                <div class="col-sm-7">
                  <input type="text" class="form-control" name="nombre" value="{{ old('nombre', $roles->nombre) }}" autocomplete="off" autofocus>
                </div>
              </div>
              <div class="row">
                <label for="estado" class="col-sm-2 col-form-label">Estado</label>
                <div class="col-sm-10">
                  <select class="form-control " name="estado" data-style="btn btn-link" id="estado">
                      <option value="1" >Activado</option>
                      <option value="0">Desactivado</option>
                  </select>
                  @if ($errors->has('estado'))
                    <span class="error text-danger" for="input-estado">{{ $errors->first('estado') }}</span>
                  @endif
                </div>
              </div>
              <div class="row">
                <label for="nombre" class="col-sm-2 col-form-label">Menu</label>
                @foreach ($menus as $menu )
                    @if ($menu->id == 1)
                    <input type="hidden" value="{{$menu['id']}}" name="menu[]">
                    @endif
                    @endforeach
                <div class="col-sm-7">
                  <div class="form-group">
                    @foreach ($menus as $menu)
                    @if ($menu->id != 1)
                    <input type="checkbox" name="menu[]" value="{{$menu['id']}}" autocomplete="off" autofocus>{{$menu['nombre']}}<br>
                    @endif
                    @endforeach
                    @if ($errors->has('nombre'))
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
                  <i class="material-icons">close</i>Cancelar</a>
            </div>
          </div>
          <!--End footer-->
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
