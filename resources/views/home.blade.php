@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Inicio') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('¡Estás dentro!') }}
                    <div class="row pt-2">
                      <div class="col-md-4">
                        <a href="{{ route('customers.index') }}" class="btn btn-primary">Clientes</a>
                      </div>
                      <div class="col-md-4">
                        <a href="{{ route('products.index') }}" class="btn btn-primary">Productos</a>
                      </div>
                      <div class="col-md-4">
                        <a href="{{ route('orders.index') }}" class="btn btn-primary">Pedidos</a>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
