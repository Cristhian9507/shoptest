@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <div class="row">
    <div class="col-md-12 text-right">
      <a href="{{ route('products.create') }}" class="btn btn-primary mb-4 float-right">Nuevo Producto</a>
    </div>
  </div>
  <h1 class="text-center mb-4">Lista de Productos</h1>
  @if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @elseif(session('error'))
    <div class="alert alert-danger">
      {{ session('error') }}
    </div>
  @endif
  <div class="table-responsive">
    <table class="table table-bordered table-striped">
      <thead class="thead-dark">
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Descripción</th>
          <th>Acciones</th>
        </tr>
      </thead>
        <tbody>
          @foreach($products as $product)
            <tr>
              <td>{{ $product->id }}</td>
              <td>{{ $product->name }}</td>
              <td>{{ $product->description }}</td>
              <td>
                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning ">Editar</a>
                <form action="{{ route('products.delete', $product->id) }}" method="POST" class="d-inline form-delete">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-delete mt-1">Eliminar</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
    </table>
  </div>
</div>
@endsection
