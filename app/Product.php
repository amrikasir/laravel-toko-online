<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $table = 'products';

	protected $fillable = ['name','image','description','price','weigth','categories_id','stok'];

	/**
	 * create getter for image attribute
	 */
	public function getImageAttribute($value){
		/**
		 * return $value if $value is url format
		 */
		if (preg_match('/^http/',$value)) {
			return $value;
		}

		/**
		 * return url asset image if $value is not url format
		 */
		return url('storage/'.$value);
	}
}
