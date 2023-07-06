<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'category';
    protected $fillable = ['staff_id','category_name','category_italian_name','image'];
    public function getNames(){
        return $this->hasOne(Menus::class,'category_id','id');
    }
}
