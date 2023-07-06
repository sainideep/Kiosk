<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcat extends Model
{
    use HasFactory;
    protected $table = 'manage_sub_category';
    protected $fillable = ['staff_id','category_id','sub_cat_name','sub_cat_name_italian'];
   
}
