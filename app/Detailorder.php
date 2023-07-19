<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detailorder extends Model
{
	protected $table = 'detail_order';
	protected $fillable = ['order_id','product_id','qty'];

	// relationship many to one with table order
	public function order(){
		return $this->belongsTo(\App\Order::class,'order_id');
	}

	// relationship one to one with table product
	public function product(){
		return $this->belongsTo(\App\Product::class,'product_id');
	}
}
