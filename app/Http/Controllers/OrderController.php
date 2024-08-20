<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
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
    $orders = Order::with(['customer', 'orderDetails', 'orderStatus'])->get();

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
      'customer_id',
      'product_id',
      'quantity',
      'date',
      'order_status_id',
    );

    $validator = $this->validateOrder($request->all());

    // Devolvemos un error si fallan las validaciones
    if ($validator->fails()) {
      return redirect()->route('orders.create')
      ->withErrors($validator)
      ->withInput();
    }

    // Creamos un nuevo pedido
    $order = Order::create([
      'date' => $data['date'],
      'order_status_id' => $data['order_status_id'],
      'customer_id' => $data['customer_id'],
    ]);

    $productIds = $request->input('product_id');
    $quantities = $request->input('quantity');

    // Recorremos los arrays
    foreach ($productIds as $index => $productId) {
      $quantity = $quantities[$index];

      // Aquí puedes realizar operaciones con $productId y $quantity
      // Por ejemplo, guardar cada producto en la base de datos
      OrderDetail::create([
        'order_id' => $order->id,
        'product_id' => $productId,
        'quantity' => $quantity,
      ]);
    }

    // Redirigimos a la lista de productos
    return redirect()->route('orders.index')->with('success', 'Pedido creado correctamente.');
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
    $order = Order::with(['customer', 'orderDetails', 'orderStatus'])->find($id);
    if(isset($order->id)) {
      $products = Product::all();
      $statuses = OrderStatus::all();
      $customers = Customer::all();
      return view('orders.edit', compact('order', 'products', 'statuses', 'customers'));
    } else {
      return redirect()->route('orders.index');
    }
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    $order = Order::find($id);
    if(!isset($order->id)) {
      return redirect()->route('orders.index');
    }

    // solo recibimos ciertos datos
    $data = $request->only(
      'customer_id',
      'product_id',
      'quantity',
      'date',
      'order_status_id',
    );

    $validator = $this->validateOrder($request->all());

    // Devolvemos un error si fallan las validaciones
    if ($validator->fails()) {
      return redirect()->route('orders.edit', $id)
      ->withErrors($validator)
      ->withInput();
    }

    $order->date = $data['date'];
    $order->order_status_id = $data['order_status_id'];
    $order->customer_id = $data['customer_id'];
    $order->save();

    // Eliminamos los detalles del pedido
    OrderDetail::where('order_id', $order->id)->delete();

    $productIds = $request->input('product_id');
    $quantities = $request->input('quantity');

    // Recorremos los arrays
    foreach ($productIds as $index => $productId) {
      $quantity = $quantities[$index];

      // Aquí puedes realizar operaciones con $productId y $quantity
      // Por ejemplo, guardar cada producto en la base de datos
      OrderDetail::create([
        'order_id' => $order->id,
        'product_id' => $productId,
        'quantity' => $quantity,
      ]);
    }

    return redirect()->route('orders.index')->with('success', 'Pedido actualizado correctamente.');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function delete(string $id)
  {
    $order = Order::find($id);
    if(isset($order->id)) {
      // eliminamos el detalle del pedido
      OrderDetail::where('order_id', $order->id)->delete();
      // eliminamos el pedido
      $order->delete();
    }

    return redirect()->route('orders.index')
    ->with('success', 'Pedido eliminado correctamente.');
  }

  private function validateOrder(array $data)
  {
    $validator = Validator::make($data, [
      'customer_id' => ['required', 'integer'],
      'order_status_id' => ['required', 'integer'],
      'date' => ['required', 'date'],
      'product_id' => ['required', 'array'],
      'quantity' => ['required', 'array'],
    ], [
        'required' => 'El campo :attribute es obligatorio.',
    ]);

    $validator->setAttributeNames([
      'customer_id' => 'cliente',
      'products' => 'productos',
      'order_status_id' => 'estado',
      'date' => 'fecha',
      'quantity' => 'cantidad',
    ]);

    return $validator;
  }
}
