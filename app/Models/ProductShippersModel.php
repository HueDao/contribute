<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductShippersModel extends Model
{
    use HasFactory;
    protected $table = 'product_shippers';
    protected $primaryKey = 'id';
}
