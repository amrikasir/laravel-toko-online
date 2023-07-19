<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alamat extends Model
{
	protected $table = 'alamat';
	protected $fillable = ['user_id','cities_id','detail'];

	// relation one to one dengan table cities
	public function city(){
		return $this->belongsTo(\App\City::class,'cities_id','city_id');
	}

}
