@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <div class="row">
    <div class="col-md-12 text-right">
      <a href="{{ route('customers.create') }}" class="btn btn-primary mb-4 float-right">Nuevo Cliente</a>
    </div>
  </div>
  <h1 class="text-center mb-4">Lista de Clientes</h1>
  @if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @elseif(session('error'))
    <div class="alert alert-danger">
      {{ session('error') }}
    </div>
  @endif
  <div class="row mb-3">
    <div class="col-md-6">
      <input type="text" id="searchInput" class="form-control" placeholder="Buscar por nombre o teléfono">
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered table-striped">
      <thead class="thead-dark">
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Teléfono</th>
          <th>Acciones</th>
        </tr>
      </thead>
        <tbody id="customerTable">
          @foreach($customers as $customer)
            <tr>
              <td>{{ $customer->id }}</td>
              <td>{{ $customer->name }}</td>
              <td>{{ $customer->phone }}</td>
              <td>
                <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning">Editar</a>
                <form action="{{ route('customers.delete', $customer->id) }}" method="POST" class="d-inline form-delete">
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
<script>
  document.getElementById('searchInput').addEventListener('keyup', function() {
    console.log('dankdja')
    // cambiamos todo el contenido a minúsculas
    var searchTerm = this.value.toLowerCase();
    var rows = document.querySelectorAll('#customerTable tr');

    rows.forEach(function(row) {
      // El contenido de name y phone también lo cambiamos a minúsculas
      var name = row.cells[1].textContent.toLowerCase();
      var phone = row.cells[2].textContent.toLowerCase();

      if (name.includes(searchTerm) || phone.includes(searchTerm)) {
        // si está incluido o lo encuentra, lo muestra
        row.style.display = '';
      } else {
        // de lo contrario ocultamos la fila  
        row.style.display = 'none';
      }
    });
  });
</script>
@endsection