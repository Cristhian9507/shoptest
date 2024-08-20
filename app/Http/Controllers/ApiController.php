<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
  public function index()
  {
    $client = new Client();
    $response = $client->get('https://ingenia.app/escobar/ws/cities');

    if ($response->getStatusCode() === 200) {
      $data = json_decode($response->getBody(), true);
      $cities = $data['cities'];
      Log::info($data);
      
      $perPage = 10;
      $totalCities = count($cities); 
      $currentPage = request()->query('page', 1); 
      $offset = ($currentPage - 1) * $perPage;
      
      $totalPages = ceil($totalCities / $perPage);
      $paginatedCities = array_slice($cities, $offset, $perPage);
      
      return view('api', [
        'paginatedCities' => $paginatedCities,
        'products' => [], // If you have products
        'currentPage' => $currentPage,
        'totalPages' => $totalPages
      ]);
    }
  }
}
