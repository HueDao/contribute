<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusOrderModel extends Model
{
    use HasFactory;
    protected $table = 'status_order';
    protected $primaryKey = 'id';
}
