<?php
namespace App\Http\Controllers\Admin;

use App\Entity\Category;
use App\Entity\Product;
use App\Http\Controllers\Controller;

class ProductController extends Controller{
    public function toProduct(){
        $products = Product::all();
        foreach ($products as $product){
            $product->category = Category::find($product->category_id);
        }
        return view('admin.product')->with('products',$products);

    }
    public function toProductAdd(){
        $categories = Category::all();
        return view('admin.product_add')->with('categories',$categories);
    }
}