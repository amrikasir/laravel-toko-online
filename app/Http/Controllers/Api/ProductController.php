<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * create api endpoint to get product list
     */
    public function index()
    {
        // get all product list
        $products = \App\Product::orderBy('created_at', 'DESC');
        
        // use model when if request has query limit
        $products->when(request()->has('limit'), function ($query) {
            
            // limit the product list
            return $query->limit(request()->limit);
        });
        
        // use model when if request has query page
        $products->when(request()->has('page'), function ($query) {
            
            // set offset product list
            return $query->offset(request()->page);
        });
        
        // get data product list
        $products = $products->get();
        
        // return product list in json format
        // contain count of all product list aggregated, total page, and current page
        return response()->json([
            'data'      => $products,
            'total'     => $total = \App\Product::count(),
            'page'      => (int) request()->query('page', 1),
            'totalPage' => ceil($total / request()->query('limit', $total))
        ]);
    }

    /**
     * get all categories
     */
    public function categories(){
        // get all categories
        $categories = \App\Categories::orderBy('name', 'ASC')->get();

        // return categories in json format
        return response()->json(['data' => $categories]);
    }

    /**
     * function to get product detail
     */
    public function show($id){
        // find product by id
        $product = \App\Product::find($id);

        // return product detail in json format
        return response()->json(['data' => $product]);
    }

    /**
     * create function to get product by category
     */
    public function productByCategory($id){
        // get product by category
        $products = \App\Product::where('categories_id', $id)->orderBy('created_at', 'DESC')->get();

        // return product by category in json format
        return response()->json(['data' => $products]);
    }
}
