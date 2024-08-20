<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $customers = Customer::all();

    return view('customers.index', compact('customers'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('customers.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    // solo recibimos ciertos datos
    $data = $request->only(
      'name', 
      'phone', 
    );

    $validator = $this->validateCustomer($request->all());

    // Devolvemos un error si fallan las validaciones
    if ($validator->fails()) {
      return redirect()->route('customers.create')
      ->withErrors($validator)
      ->withInput();
    }

    // Creamos un nuevo cliente
    $customer = new Customer();
    $customer->name = $data['name'];
    $customer->phone = $data['phone'];
    $customer->save();

    // Redirigimos a la lista de clientes
    return redirect()->route('customers.index')->with('success', 'Cliente creado correctamente.');
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
    $customer = Customer::find($id);
    if(isset($customer->id)) {
      return view('customers.edit', compact('customer'));
    } else {
      return redirect()->route('customers.index');
    }
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    $customer = Customer::find($id);
    if(!isset($customer->id)) {
      return redirect()->route('customers.index');
    }
    // solo recibimos ciertos datos
    $data = $request->only(
      'name', 
      'phone', 
    );

    // Realizamos validaciones a la información que entra
    $validator = $this->validateCustomer($request->all());

    // Devolvemos un error si fallan las validaciones
    if ($validator->fails()) {
      return redirect()->route('customers.edit', ['id' => $id])
      ->withErrors($validator)
      ->withInput();
    }

    // Creamos un nuevo cliente
    $customer->name = $data['name'];
    $customer->phone = $data['phone'];
    $customer->save();

    // Redirigimos a la lista de clientes
    return redirect()->route('customers.index')->with('success', 'Cliente actualizado correctamente.');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function delete(string $id)
  {
    $customer = Customer::find($id);
    if(isset($customer->id)) {
      $customer->delete();
    }

    return redirect()->route('customers.index')
    ->with('success', 'Cliente eliminado correctamente.');
  }

  private function validateCustomer(array $data)
  {
    $validator = Validator::make($data, [
      'name' => ['required', 'string', 'max:255'],
      'phone' => ['required', 'string', 'min:10', 'max:15'],
    ], [
        'required' => 'El campo :attribute es obligatorio.',
        'string' => 'El campo :attribute debe ser una cadena de texto.',
        'max' => [
            'string' => 'El campo :attribute no debe tener más de :max caracteres.',
        ],
        'min' => [
            'string' => 'El campo :attribute debe tener al menos :min dígitos.',
        ],
    ]);

    $validator->setAttributeNames([
        'name' => 'nombre',
        'phone' => 'teléfono',
    ]);

    return $validator;
  }
}
