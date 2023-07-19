<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
	protected $table = 'cities';
	protected $fillable = [
		'province_id', 'city_id','title'
	];

	// relation one to one dengan table provinces
	public function province(){
		return $this->belongsTo(\App\Province::class,'province_id','province_id');
	}
}
