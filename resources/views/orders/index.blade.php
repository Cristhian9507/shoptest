@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <div class="row">
    <div class="col-md-12 text-right">
      <a href="{{ route('orders.create') }}" class="btn btn-primary mb-4 float-right">Nuevo Pedido</a>
    </div>
  </div>
  <h1 class="text-center mb-4">Lista de Pedidos</h1>
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
          <th>Cliente</th>
          <th>Productos</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
        <tbody>
          @foreach($orders as $order)
            <tr>
              <td>{{ $order->id }}</td>
              <td>{{ $order->customer->name }}</td>
              <td>
                @foreach($order->orderDetails as $orderDetail)
                  <span class="badge badge-primary">{{ $orderDetail->product->name }} ($orderDetail->quantity)</span>
                @endforeach
              </td>
              <td>{{ $order->status->name }}</td>
              <td>
                <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-warning">Editar</a>
                <form action="{{ route('orders.delete', $order->id) }}" method="POST" class="d-inline form-delete">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-delete">Eliminar</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
    </table>
  </div>
</div>
@endsection
