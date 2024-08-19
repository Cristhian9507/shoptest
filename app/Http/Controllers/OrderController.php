<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $orders = Order::with(['products', 'status'])->get();

    return view('orders.index', compact('orders'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $products = Product::all();
    $statuses = OrderStatus::all();
    $customers = Customer::all();

    return view('orders.create', compact('products', 'statuses', 'customers'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    // solo recibimos ciertos datos
    $data = $request->only(
      'products',
      'date',
      'status_id',
      'customer_id',
    );

    $validator = $this->validateOrder($request->all());

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
    return redirect()->route('products');
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
      return redirect()->route('products');
    }
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    $product = Product::find($id);
    if(!isset($product->id)) {
      return redirect()->route('products');
    }
    // solo recibimos ciertos datos
    $data = $request->only(
      'name', 
      'description', 
    );

    // Realizamos validaciones a la información que entra
    $validator = $this->validateOrder($request->all());

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
    return redirect()->route('products');
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

    return redirect()->route('products')
    ->with('success', 'Producto eliminado correctamente.');
  }

  private function validateOrder(array $data)
  {
    $validator = Validator::make($data, [
      'customer_id' => ['required', 'integer'],
      'status_id' => ['required', 'integer'],
      'products' => ['required', 'array'],
    ], [
        'required' => 'El campo :attribute es obligatorio.',
    ]);

    $validator->setAttributeNames([
        'customer_id' => 'cliente',
        'products' => 'productos',
        'status_id' => 'estado',
    ]);

    return $validator;
  }
}
