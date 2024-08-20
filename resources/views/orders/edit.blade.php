@extends('layouts.app')
@section('content')

<div class="container mt-5">
  <h1 class="text-center mb-4">Editar Orden</h1>
  @if ($errors->any())
    <div class="alert alert-danger mt-4">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  <form action="{{ route('orders.update', $order->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
      <div class="form-group col-md-4 col-xs-12">
        <label for="name">Fecha</label>
        <input type="date" name="date" id="date" class="form-control" value="{{ date('Y-m-d', strtotime($order->date)) }}" required>
      </div>
      <div class="form-group col-md-4 col-xs-12">
        <label for="name">Cliente</label>
        <select name="customer_id" id="customer_id" class="form-control" required>
          <option value="">Seleccione un cliente</option>
          @foreach ($customers as $customer)
            <option value="{{ $customer->id }}" @if($customer->id === $order->customer_id) selected @endif>{{ $customer->name }}</option>
            @endforeach
        </select>
      </div>
      <div class="form-group col-md-4 col-xs-12">
        <label for="name">Estado</label>
        <select name="order_status_id" id="status_id" class="form-control" required>
          <option value="">Seleccione un estado</option>
          @foreach ($statuses as $status)
          <option value="{{ $status->id }}" @if($status->id === $order->order_status_id) selected @endif>{{ $status->name }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <hr>
    <h2 class="text-center mb-4">Productos</h2>
    <div id="product-lines">
      @foreach ($order->orderDetails as $orderDetail)
      <div class="row product-line">
        <div class="form-group col-md-4 col-xs-12">
          <label for="name">Producto</label>
          <select name="product_id[]" id="product_id" class="form-control">
            <option value="">Seleccione un producto</option>
            @foreach ($products as $product)
            <option value="{{ $product->id }}" @if($product->id === $orderDetail->product_id) selected @endif>{{ $product->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group col-md-2 col-xs-12">
          <label for="quantity">Cantidad</label>
          <input type="number" name="quantity[]" id="quantity" class="form-control" value="{{ $orderDetail->quantity }}" required>
        </div>
        <div class="form-group col-md-2 col-xs-12 d-flex align-items-end">
          <button type="button" class="btn btn-danger remove-product">-</button>
        </div>
      </div>
      @endforeach
    </div>
    <div class="row mt-3">
      <div class="col-md-12 text-center">
        <button type="button" class="btn btn-success" id="add-product-line">Agregar Producto</button>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 text-center">
        <button type="submit" class="btn btn-primary mt-2 text-center">Actualizar orden</button>
      </div>
    </div>
  </form>
</div>
<script>
  $(document).ready(function() {
    // Funcionalidad para agregar una nueva línea de producto
    $('#add-product-line').click(function() {
      console.log('yes ??')
      // Clonar la primera línea de producto
      var newProductLine = $('.product-line').first().clone();
      // Limpiar los valores seleccionados y el input de cantidad
      newProductLine.find('select').val('');
      newProductLine.find('input').val('');
      // Añadir la nueva línea al final
      $('#product-lines').append(newProductLine);
    });

    // Funcionalidad para eliminar una línea de producto
    $(document).on('click', '.remove-product', function() {
      if ($('.product-line').length > 1) {
        $(this).closest('.product-line').remove();
      } else {
        alert('Debe haber al menos un producto en el pedido.');
      }
    });
  });
</script>
@endsection