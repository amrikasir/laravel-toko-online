<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * function to get user detail
     */
    public function show(){
        // return user detail in json format
        return response()->json(['data' => auth()->user()]);
    }

    /**
     * function to update user
     */
    public function update(Request $request, $id){
        // find user by id
        $user = \App\User::find($id);

        // update user
        $user->update($request->all());

        // return user detail in json format with message
        return response()->json([
            'data'      => $user,
            'message'   => 'User has been updated'
        ]);
    }

    /**
     * function to update user password
     */
    public function updatePassword(Request $request, $id){
        // find user by id
        $user = \App\User::find($id);

        // update user password with Hash::make
        $user->update([
            'password'  => Hash::make($request->password)
        ]);

        // return user detail in json format with message
        return response()->json([
            'data'      => $user,
            'message'   => 'User password has been updated'
        ]);
    }
}
