<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStoreModel extends Model
{
    use HasFactory;
    protected $table = 'order_store';
    protected $primaryKey = 'id';
}
