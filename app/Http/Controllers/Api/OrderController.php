<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class OrderController extends Controller
{
    /**
     * function to checkout order
     */
    public function checkout()
    {
        // get store address from table alamat_toko
        $alamat_toko = DB::table('alamat_toko')->first();

        // if alamat_toko is null
        if (is_null($alamat_toko)) {
            return response()->json([
                'success' => false,
                'message' => 'Alamat toko belum diisi, silahkan hubungi admin'
            ], 400);
        }

        // add city to alamat_toko
        $alamat_toko->city = \App\City::with('province')->where('city_id', $alamat_toko->city_id)->first();

        // get user alamat from table alamat
        $alamat = \App\Alamat::with('city.province')->where('user_id', Auth::user()->id)->first();

        // if alamat is null
        if (is_null($alamat)) {
            return response()->json([
                'success' => false,
                'message' => 'Alamat User belum diisi'
            ], 400);
        }

        // get data from table keranjang
        $keranjang = \App\Keranjang::with(['product'])->where('user_id', Auth::user()->id)->get();

        // calculate total weight
        $berat = $keranjang->sum(function ($q) {
            return $q->product->weigth * $q->qty;
        });

        // calc shipping cost
        $cost = RajaOngkir::ongkosKirim([
            'origin'        => $alamat_toko->id,
            'destination'   => $alamat->cities_id,
            'weight'        => $berat,
            'courier'       => 'jne'
        ])->get();

        // convert result to collection
        $cost = collect($cost[0]);

        // search OKE service from costs in $cost
        $jne_OKE = collect($cost->get('costs'))->firstWhere('service', 'OKE');

        // if OKE service is null
        if (is_null($jne_OKE)) {
            return response()->json([
                'success' => false,
                'message' => 'LAYANAN OKE TIDAK TERSEDIA UNTUK SAAAT INI'
            ], 400);
        }

        // return response
        return response()->json([
            'success' => true,
            'message' => 'List Checkout',
            'data' => [
                'invoice' => 'ALV' . Date('Ymdhi'), // 'ALV202106231234
                'alamat_toko' => $alamat_toko,
                'alamat_user' => $alamat,
                'keranjang' => $keranjang,
                'ongkir' => $ongkir = [
                    'service' => $jne_OKE['service'],
                    'description' => $jne_OKE['description'],
                    'biaya' => $jne_OKE['cost'][0]['value'],
                    'etd' => $jne_OKE['cost'][0]['etd'],
                ],
                'total_belanja' => $belanja = $keranjang->sum(function ($q) {
                    return $q->product->price * $q->qty;
                }),
                'total_bayar' => $belanja + $ongkir['biaya']
            ]
        ]);
    }

    /**
     * function to get list order
     */
    public function index(){
        // get data from table order
        $order = \App\Order::with(['status_order'])->where('user_id', Auth::user()->id);

        // use when to filter data by status_order_id in query string
        $order = $order->when(request()->status_order_id, function($query){
            return $query->where('status_order_id', request()->status_order_id);
        });

        $order = $order->get();

        // return response
        return response()->json([
            'success' => true,
            'message' => 'List Order',
            'data' => $order
        ]);
    }

    /**
     * function to store order
     */
    public function store(Request $request)
    {
        // use firstOrCreate to get or create data from model order
        $order = \App\Order::firstOrCreate([
            'invoice' => $request->invoice
        ], [
            'user_id' => Auth::user()->id,
            'subtotal' => $request->total_bayar,
            'status_order_id' => 1,
            'metode_pembayaran' => 'trf', // trf = transfer 
            'ongkir' => $request->ongkir,
            'no_hp' => $request->no_hp,
            'pesan' => $request->pesan
        ]);

        // store data to table detail_order
        // get data from table keranjang
        $keranjang = \App\Keranjang::with(['product'])->where('user_id', Auth::user()->id)->get();

        // loop data in $keranjang
        foreach ($keranjang as $cart) {
            // store data to table detail_order
            \App\Detailorder::create([
                'order_id' => $order->id,
                'product_id' => $cart->products_id,
                'qty' => $cart->qty
            ]);

            // delete data in table keranjang
            $cart->delete();
        }

        // return response
        return response()->json([
            'success' => true,
            'message' => 'Order berhasil dibuat',
            'data' => $order
        ]);
    }

    /**
     * function to get order detail
     */
    public function show($id){
        // get order detail from model Detailorder
        $detail_order = \App\Detailorder::with('product')->where('order_id', $id)->get();

        // get order from model Order
        $order = \App\Order::with(['status_order'])->where('id', $id)->first();

        // return response
        return response()->json([
            'success' => true,
            'message' => 'Detail Order',
            'data' => [
                'order' => $order,
                'detail_order' => $detail_order
            ]
        ]);
    }
}
