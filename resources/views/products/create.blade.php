@extends('layouts.app')

@section('content')

<div class="container mt-5">
  <h1 class="text-center mb-4">Crear nuevo producto</h1>
  @if ($errors->any())
    <div class="alert alert-danger mt-4">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  <form action="{{ route('products.store') }}" method="POST">
    @csrf
    <div class="row">
      <div class="form-group col-md-6 col-xs-12">
        <label for="name">Nombre</label>
        <input type="text" name="name" id="name" class="form-control" required>
      </div>
      <div class="form-group col-md-6 col-xs-12">
        <label for="name">Descripción (opcional)</label>
        <input type="text" name="description" id="description" class="form-control">
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 text-center">
        <button type="submit" class="btn btn-primary mt-2 text-center">Crear producto</button>
      </div>
    </div>
  </form>
</div>
@endsection