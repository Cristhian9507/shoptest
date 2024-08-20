@extends('layouts.app')
@section('content')

<div class="container mt-5">
  <h1 class="text-center mb-4">Editar cliente</h1>
  @if ($errors->any())
    <div class="alert alert-danger mt-4">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  <form action="{{ route('customers.update', $customer->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
      <div class="form-group col-md-6 col-xs-12">
        <label for="name">Nombre</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ $customer->name }}" required>
      </div>
      <div class="form-group col-md-6 col-xs-12">
        <label for="phone">Teléfono</label>
        <input type="number" name="phone" id="phone" class="form-control" value="{{ $customer->phone }}" required>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 text-center">
        <button type="submit" class="btn btn-primary mt-2 text-center">Actualizar cliente</button>
      </div>
    </div>
  </form>
</div>
@endsection