<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersShipperModel extends Model
{
    use HasFactory;
    protected $table = 'orders_shipper';
    protected $primaryKey = 'id';
}
