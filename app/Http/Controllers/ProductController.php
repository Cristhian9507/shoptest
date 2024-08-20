<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $products = Product::all();

    return view('products.index', compact('products'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('products.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    // solo recibimos ciertos datos
    $data = $request->only(
      'name',
      'description',
    );

    $validator = $this->validateProduct($request->all());

    // Devolvemos un error si fallan las validaciones
    if ($validator->fails()) {
      return redirect()->route('products.create')
      ->withErrors($validator)
      ->withInput();
    }

    // Creamos un nuevo producto
    $product = new Product();
    $product->name = $data['name'];
    $product->description = $data['description'];
    $product->save();

    // Redirigimos a la lista de productos
    return redirect()->route('products.index')->with('success', 'Producto creado correctamente.');
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    $product = Product::find($id);
    if(isset($product->id)) {
      return view('products.edit', compact('product'));
    } else {
      return redirect()->route('products.index');
    }
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    $product = Product::find($id);
    if(!isset($product->id)) {
      return redirect()->route('products.index');
    }
    // solo recibimos ciertos datos
    $data = $request->only(
      'name', 
      'description', 
    );

    // Realizamos validaciones a la información que entra
    $validator = $this->validateProduct($request->all());

    // Devolvemos un error si fallan las validaciones
    if ($validator->fails()) {
      return redirect()->route('products.edit', ['id' => $id])
      ->withErrors($validator)
      ->withInput();
    }

    // Creamos un nuevo cliente
    $product->name = $data['name'];
    $product->description = $data['description'];
    $product->save();

    // Redirigimos a la lista de productos
    return redirect()->route('products.index')->with('success', 'Producto actualizado correctamente.');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function delete(string $id)
  {
    $product = Product::find($id);
    if(isset($product->id)) {
      $product->delete();
    }

    return redirect()->route('products.index')
    ->with('success', 'Producto eliminado correctamente.');
  }

  private function validateProduct(array $data)
  {
    $validator = Validator::make($data, [
      'name' => ['required', 'string', 'max:255'],
      'description' => ['nullable', 'string', 'max:255'],
    ], [
        'required' => 'El campo :attribute es obligatorio.',
        'string' => 'El campo :attribute debe ser una cadena de texto.',
        'max' => [
            'string' => 'El campo :attribute no debe tener más de :max caracteres.',
        ],
    ]);

    $validator->setAttributeNames([
        'name' => 'nombre',
        'description' => 'descripción',
    ]);

    return $validator;
  }
}
