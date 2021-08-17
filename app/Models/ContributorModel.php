<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContributorModel extends Model
{
  protected $table = 'contributors';
  protected $primaryKey = 'id';
  public function categoryUsers() {
    return $this->hasMany('App\Models\CategoryUserModel', 'user_id');
  }
}
