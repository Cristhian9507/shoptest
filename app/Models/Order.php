<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
    'customer_id',
    'order_status_id',
    'date',
  ];

  public function customer()
  {
    return $this->belongsTo(Customer::class);
  }

  public function orderDetails()
  {
    return $this->hasMany(OrderDetail::class);
  }

  public function orderStatus()
  {
    return $this->belongsTo(OrderStatus::class);
  }
}
