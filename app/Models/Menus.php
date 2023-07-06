<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menus extends Model
{
    use HasFactory;
    protected $table = 'menu_items';
    protected $fillable = [ 'restor_id', 'staff_id','category_id','sub_cat_id','item_name','item_italian_name','item_price','description',
                            'description_it','item_image'];
    public function getDetail(){
        return $this->hasOne(Category::class,'id','category_id');
    }

   
}
