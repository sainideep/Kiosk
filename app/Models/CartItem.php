<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;
    protected $table = 'cart_items';

     public function MenusDetail()
    {
        return $this->hasOne(Menus::class, 'id', 'menu_id');
    }
    public function categoryDetail()
    {
        return $this->hasOne(Category::class, 'id', 'cat_id');
    }
}
