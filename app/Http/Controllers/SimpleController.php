<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SimpleController extends Controller
{
    // index function for simple program
    public function index()
    {
        // return json data from simple program
        return response()->json([
            'status' => 'success',
            'data' => DB::table('simple_program')->get()
        ]);
    }

    // simpan function for simple program
    public function simpan(Request $request){
        // loop request data to validate each data from request
        foreach($request->all() as $key => $value){
            // check if value is in array
            if(in_array($key,['faktur','tanggal','barang','harga','qty','total'])){
                // return json message if value is empty
                if(empty($value)){
                    return response()->json([
                        'status' => 'error',
                        'message' => $key.' tidak boleh kosong'
                    ]);
                }
            }
        }

        // check if value of each array is exist in request
        
        try {
            // insert data to simple program
            DB::table('simple_program')->insert([
                'faktur' => $request->faktur,
                'tanggal' => $request->tanggal,
                'barang' => $request->barang,
                'harga' => $request->harga,
                'qty' => $request->qty,
                'total' => $request->total
            ]);

            // return json data from simple program
            return response()->json([
                'status' => 'success',
            ]);
        } catch (\Throwable $th) {
            // if error in DB, SQLSTATE[23000] then return json message
            if($th->getCode() == '23000'){
                return response()->json([
                    'status' => 'error',
                    'message' => 'data tidak valid'
                ]);
            }
        }
    }
    
}
