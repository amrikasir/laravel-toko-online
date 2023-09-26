<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Product extends Component
{
    /*
    * Is this product in a carousel?
    *
    * @var boolean
    */
    public $carousel;

    /*
    * The product instance.
    *
    * @var \App\Product
    */
    public $produk;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($produk, $carousel = false)
    {
        $this->produk = $produk;

        $this->carousel = $carousel;
    }

    /**
     * function to change class if product is in a carousel
     * 
     * @return string
     */
    public function carouselClass(){
        if($this->carousel){
            return 'item';
        }
        
        return 'col-sm-6 col-lg-4 mb-4';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.product');
    }
}
