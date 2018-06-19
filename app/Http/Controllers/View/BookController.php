<?php
namespace App\Http\Controllers\View;

use App\Entity\Category;
use App\Entity\PdtContent;
use App\Entity\PdtImages;
use App\Entity\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class BookController extends Controller{
    public function toCategory(){
        Log::info("进入书籍类别");
        $categorys = Category::whereNull('parent_id')->get();
        return view('category')->with('categorys',$categorys);
    }

    public function toProduct($category_id)
    {
        $products = Product::where('category_id', $category_id)->get();
        return view('product')->with('products', $products);

    }

    public function toPdtContent(Request $request , $product_id){
        $products = Product::find($product_id);
        $pdt_content = PdtContent::where('product_id',$product_id)->first();
        $pdt_images = PdtImages::where('product_id',$product_id)->get();

        $bk_cart = $request->cookie('bk_cart');
        $bk_cart_arr = ($bk_cart != null ? explode(',' , $bk_cart) : array());

        $count = 0;

        foreach($bk_cart_arr as $value){//因为这里无需修改值 所以不需要引用&
            $index = strpos($value ,':');
            if (substr($value , 0  ,$index) == $product_id){
                $count = (int) substr($value , $index+1);//以为不是加1，只是把这个cookie的值拿出来，所以不用+1
                break;
            }
        }
        return view('pdt_content')->with('product',$products)
            ->with('pdt_content',$pdt_content)
            ->with('pdt_images',$pdt_images)
            ->with('count' , $count);
    }

    public function toCategory_id(Request $request ,$category_id){
        $category = Category::find($category_id);
        $products = Product::where('category_id',$category_id)->get();
        return view('category_id')->with('products',$products)
                                    ->with('category',$category);
    }


    public function toCategory_name(Request $request ,$name){
        $category = Category::where('name', $name)->get();

        $category_id = $category::find('id')->get();
        $products = Product::where('category_id',$category_id)->get();
        return view('category_id')->with('products',$products)
            ->with('category',$category);
    }

}