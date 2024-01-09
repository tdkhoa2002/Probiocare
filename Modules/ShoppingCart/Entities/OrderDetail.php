<?php

namespace Modules\ShoppingCart\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\Product;

class OrderDetail extends Model
{
  protected $table = 'shoppingcart__orderdetails';
  protected $fillable = [
    'order_id',
    'product_id',
    'price',
    'qty',
    'total'
  ];

  public function product()
  {
    return $this->belongsTo(Product::class, 'product_id');
  }
}
