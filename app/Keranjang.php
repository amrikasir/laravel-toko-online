<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
	protected $table = 'keranjang';
	protected $fillable = ['user_id','products_id','qty'];

	// one to one relationship dengan table product
	// use product_id sebagai foreign key di table keranjang dan id di table product
	public function product(){
		return $this->hasOne(\App\Product::class,'id','products_id');
	}
}
