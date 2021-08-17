<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryUserModel extends Model
{
    protected $table = 'category_user';
    protected $primaryKey = 'id';
    public function contributor() {
        return $this->belongsTo('App\Models\ContributorModel', 'foreign_key');
    }
    public function category() {
        return $this->belongsTo('App\Models\CategoryModel', 'foreign_key');
    }
}
