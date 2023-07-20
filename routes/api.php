<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * api endpoint for login
 */
Route::post('login', 'Api\AuthController@login');

/**
 * api endpoint for register
 */
Route::post('register', 'Api\AuthController@register');

/**
 * route group with prefix product
 */
Route::prefix('product')->group(function () {
    /**
     * api endpoint to get product list
     */
    Route::get('/list', 'Api\ProductController@index');

    /**
     * api endpoint to get product detail
     */
    Route::get('/{id}', 'Api\ProductController@show');

    /**
     * api endpoint to get all categories in ProductController
     */
    Route::get('/categories', 'Api\ProductController@categories');
    
    /**
     * api endpoint to get product by category
     */
    Route::get('/category/{id}', 'Api\ProductController@productByCategory');
});

/**
 * route group with middleware mobile
 */
Route::middleware('mobile')->group(function () {
    /**
     * route group with prefix user
     */
    Route::prefix('user')->group(function () {
        /**
         * api endpoint to get user detail
         */
        Route::get('/', 'Api\UserController@show');

        /**
         * api endpoint to update user detail
         */
        Route::post('/', 'Api\UserController@update');

        /**
         * api endpoint to update user password
         */
        Route::post('password', 'Api\UserController@updatePassword');
    });

    /**
     * route group with prefix cart
     */
    Route::prefix('cart')->group(function () {
        /**
         * api endpoint to get cart list
         */
        Route::get('/', 'Api\CartController@index');

        /**
         * api endpoint to add product to cart
         */
        Route::post('/', 'Api\CartController@store');

        /**
         * api endpoint to update cart
         */
        Route::post('/{id}', 'Api\CartController@update');

        /**
         * api endpoint to delete cart
         */
        Route::post('/{id}/delete', 'Api\CartController@destroy');
    });

    /**
     * route group with prefix address
     */
    Route::prefix('address')->group(function () {
        /**
         * api endpoint to get address list
         */
        Route::get('/', 'Api\AddressController@index');

        /**
         * api endpoint to add address
         */
        Route::post('/', 'Api\AddressController@store');

        /**
         * api endpoint to get address detail
         */
        Route::get('/{id}', 'Api\AddressController@show');

        /**
         * api endpoint to update address
         */
        Route::post('/{id}', 'Api\AddressController@update');

        /**
         * api endpoint to delete address
         */
        Route::post('/{id}/delete', 'Api\AddressController@destroy');

        /**
         * get list province
         */
        Route::get('/province', 'Api\AddressController@province');

        /**
         * get list city by province
         */
        Route::get('/city/{id}', 'Api\AddressController@city');
        
    });

    /**
     * route group with prefix order
     */
    Route::prefix('order')->group(function () {

        /**
         * api endpoint to checkout order
         */
        Route::get('/checkout', 'Api\OrderController@checkout');

        /**
         * api endpoint to confirm checkout order
         */
        Route::post('/checkout/confirm', 'Api\OrderController@store');

        /**
         * api endpoint to get order list
         */
        Route::get('/', 'Api\OrderController@index');

        /**
         * api endpoint to add order
         * 
         * @Deprecated use checkout/confirm instead
         */
        Route::post('/', 'Api\OrderController@store');

        /**
         * api endpoint to get order detail
         */
        Route::get('/{id}', 'Api\OrderController@show');

        /**
         * api endpoint to cancel order
         */
        Route::post('/{id}/cancel', 'Api\OrderController@cancel');

        /**
         * api endpoint to upload payment proof
         */
        Route::post('/{id}/proof', 'Api\OrderController@uploadProof');

        /**
         * api endpoint to confirm order
         */
        Route::post('/{id}/confirm', 'Api\OrderController@confirm');
    });
});

/**
 * api endpoint for logout
 */
Route::middleware('mobile')->get('logout', 'Api\AuthController@logout');
