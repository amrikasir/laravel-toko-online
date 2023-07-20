<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * function to get address list
     */
    public function index(){
        // get address list with model alamat
        $addresses = \App\Alamat::where('user_id', auth()->id())->get();

        // return address list in json format
        return response()->json(['data' => $addresses]);
    }

    /**
     * function to add address
     */
    public function store(Request $request){
        // check if city is exists in City model
        if(!\App\City::find($request->city_id)){
            // return error message in json format
            return response()->json(['message' => 'City not found'], 404);
        }

        // create address
        $address = \App\Alamat::create([
            'user_id'       => auth()->id(),
            'city_id'       => $request->city_id,
            'detail'        => $request->detail
        ]);

        // return address detail in json format with message
        return response()->json([
            'data'      => $address,
            'message'   => 'Address has been added'
        ]);
    }

    /**
     * function to update address
     */
    public function update(Request $request, $id){
        // find address by id
        $address = \App\Alamat::find($id);

        // update address
        $address->update($request->all());

        // return address detail in json format with message
        return response()->json([
            'data'      => $address,
            'message'   => 'Address has been updated'
        ]);
    }

    /**
     * function to get address detail
     */
    public function show($id){
        // find address by id
        $address = \App\Alamat::find($id);

        // return address detail in json format
        return response()->json(['data' => $address]);
    }

    /**
     * function to delete address
     */
    public function destroy($id){
        // find address by id
        $address = \App\Alamat::find($id);

        // delete address
        $address->delete();

        // return success message in json format
        return response()->json(['message' => 'Address has been deleted']);
    }

    /**
     * function to get province list
     */
    public function province(){
        // get province list with model province
        $provinces = \App\Province::all();

        // return province list in json format
        return response()->json(['data' => $provinces]);
    }

    /**
     * function to get city list by province
     */
    public function city($id){
        // get city list with model city
        $cities = \App\City::where('province_id', $id)->get();

        // return city list in json format
        return response()->json(['data' => $cities]);
    }
}
