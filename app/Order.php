<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $table = 'order';

	protected $fillable = ['invoice','user_id','subtotal','no_resi','status_order_id','metode_pembayaran','ongkir','biaya_cod','bukti_pembayaran','pesan','no_hp'];

	/**
	 * create getter for bukti_pembayaran attribute
	 */
	public function getBuktiPembayaranAttribute($value){
		// return null if $value is null
		if ($value == null) {
			return null;
		}
		
		/**
		 * return $value if $value is url format
		 */
		if (preg_match('/^http/',$value)) {
			return $value;
		}

		/**
		 * return url asset bukti_pembayaran if $value is not url format
		 */
		return url('storage/'.$value);
	}

	// create relationship one to many with table order_detail
	public function detail(){
		return $this->hasMany(\App\Detailorder::class,'order_id');
	}

	// create relationship one to many with table status_order
	public function status_order(){
		return $this->belongsTo(\App\Orderstatus::class,'status_order_id');
	}
}
