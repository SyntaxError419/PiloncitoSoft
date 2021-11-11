@extends('layouts.plantillabase')
@section('contenido')
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-warning">
              <h4 class="card-title">Usuarios
                              {{ Form::open(['route' => 'usuarios.index', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
                                  <div class="form-group">
                                      {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Buscar']) }}
                                  </div>
                                  <div class="form-group">
                                  <button type="submit" class="btn btn-white btn-round btn-just-icon">
                                      <i class="material-icons">search</i>
                                      <div class="ripple-container"></div>
                                  </button>
                                  </div>
                              {{ Form::close() }}
              </h4>
              <p class="card-category">Lista de Usuarios registrados</p>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12 text-right">
                  <a href="{{ route('usuarios.create') }}" class="btn btn-sm btn-facebook">Añadir nuevo Usuario</a>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table table-light" >
                  <thead class="text-warning">

                    <th> Nombre </th>
                    <th> Menus </th>
                    <th> Estado </th>
                    <th class="text-right"> Acciones </th>
                  </thead>
                  <tbody>
                    @forelse ($usuarios as $usuario)
                    <tr>

                      <td>{{ $usuario->nombre }}</td>
                      <td>

                      </td>
                      <td>@if ($usuario->estado == 1)
                      Activado
                      @else
                      Desactivado
                      @endif</td>
                      <td class="td-actions text-right">
                        <a href="{{ route('usuarios.show', $usuario->id) }}" class="btn btn-info"> <i class="fas fa-eye"></i> </a>
                        <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-warning"> <i class="fas fa-pen"></i> </a>
                        <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="post"
                          onsubmit="return confirm('Esta seguro?')" style="display: inline-block;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" rel="tooltip" class="btn btn-danger">
                              <i class="fas fa-trash"></i>
                          </button>
                        </form>
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="2">Sin registros.</td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
                {{-- {{ $users->links() }} --}}
              </div>
            </div>
            <!--Footer-->
            <div class="card-footer mr-auto">

            </div>
            <!--End footer-->
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

