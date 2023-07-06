<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

/**
 * artisan command to generate data from https://fakestoreapi.com/
 */
Artisan::command('generate:product', function () {
    // get data categories from https://fakestoreapi.com/
    $categories = file_get_contents('https://fakestoreapi.com/products/categories');
    $categories = json_decode($categories);
    // loop categories
    foreach ($categories as $key => $value) {
        // display category name to console
        $this->info('Generate category '. $value);
        // create category
        $category = new \App\Categories;
        $category->name = $value;
        $category->save();
    }

    // get data from https://fakestoreapi.com/
    $data = file_get_contents('https://fakestoreapi.com/products');
    $data = json_decode($data);
    // loop data
    foreach ($data as $key => $value) {
        // display product name to console
        $this->info('Generate product '. $value->title);
        
        // create product
        $product = new \App\Product;
        $product->name = $value->title;
        
        // convert price from usd to idr
        $product->price = $value->price * 14000;

        // search category id by name
        $category = \App\Categories::where('name', $value->category)->first();
        $product->categories_id = $category->id;

        // use random number for weigth from 10 to 200
        $product->weigth = rand(10,200);

        $product->stok = $value->rating->count;
        $product->description = $value->description;
        $product->image = $value->image;
        $product->save();
    }
    $this->info('Generate product success');
})->describe('Generate product from https://fakestoreapi.com/');
