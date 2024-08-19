<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $orderStatuses = [
      'Pendiente',
      'Procesando',
      'Completado',
      'Cancelado',
    ];

    foreach ($orderStatuses as $orderStatus) {
      \App\Models\OrderStatus::create([
        'name' => $orderStatus,
      ]);
    }
  }
}
