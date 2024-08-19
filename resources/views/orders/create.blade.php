@extends('layouts.app')

@section('content')

<div class="container mt-5">
  <h1 class="text-center mb-4">Crear nueva orden</h1>
  @if ($errors->any())
    <div class="alert alert-danger mt-4">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  <form action="{{ route('orders.store') }}" method="POST">
    @csrf
    <div class="row">
      <div class="form-group col-md-6 col-xs-12">
        <label for="name">Cliente</label>
        <select name="customer_id" id="customer_id" class="form-control">
          <option value="">Seleccione un cliente</option>
          @foreach ($customers as $customer)
            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
            @endforeach
        </select>
      </div>
      <div class="form-group col-md-6 col-xs-12">
        <label for="name">Estado</label>
        <select name="status_id" id="status_id" class="form-control">
          <option value="">Seleccione un estado</option>
          @foreach ($statuses as $status)
          <option value="{{ $status->id }}">{{ $status->name }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="row">
      <div class="form-group col-md-6 col-xs-12">
        <label for="name">Producto</label>
        <select name="product_id[]" id="product_id" class="form-control">
          <option value="">Seleccione un producto</option>
          @foreach ($products as $product)
          <option value="{{ $product->id }}">{{ $product->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group col-md-6 col-xs-12">
        <label for="quantity">Cantidad</label>
        <input type="number" name="quantity" id="quantity" class="form-control" required>
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