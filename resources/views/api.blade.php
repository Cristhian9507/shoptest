@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <h1 class="text-center mb-4">Lista de ciudades</h1>
    <table class="table table-bordered table-striped">
      <thead class="thead-dark">
      <tr>
        <th>Cod Ciudad</th>
        <th>Nombre</th>
        <th>Nombre Depto</th>
      </tr>
      </thead>
      <tbody>
        @foreach($paginatedCities as $city)
        <tr>
          <td>{{ $city["codCiudad"] }}</td>
          <td>{{ $city["nomCiudad"] }}</td>
          <td>{{ $city["nomDepto"] }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="row">
      <div class="col-md-12 col-xs-12">
      <div class="d-flex justify-content-center">
        <nav>
          <ul class="pagination">
            @if ($currentPage > 3)
              <li class="page-item">
                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => 1]) }}">
                  1
                </a>
              </li>
              @if ($currentPage > 4)
                <li class="page-item disabled"><span class="page-link">...</span></li>
              @endif
            @endif
    
            <!-- Links for each page number -->
            @for ($page = max(1, $currentPage - 2); $page <= min($currentPage + 2, $totalPages); $page++)
              <li class="page-item {{ $page == $currentPage ? 'active' : '' }}">
                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $page]) }}">
                  {{ $page }}
                </a>
              </li>
            @endfor
    
            <!-- Link to the next page -->
            @if ($currentPage < $totalPages - 2)
              @if ($currentPage < $totalPages - 3)
                <li class="page-item disabled"><span class="page-link">...</span></li>
              @endif
              <li class="page-item">
                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $totalPages]) }}">
                  {{ $totalPages }}
                </a>
              </li>
            @endif
            @if ($currentPage < $totalPages)
              <li class="page-item">
                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $currentPage + 1]) }}">
                  Sig &raquo;
                </a>
              </li>
            @endif
          </ul>
        </nav>
      </div>
    </div>
  </div>
</div>
@endsection
