<?php
namespace App\Http\Controllers\View;

use App\Entity\CartItem;
use App\Entity\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller{
    public  function  toCart(Request $request){

        $cart_items = array();

        $bk_cart = $request -> cookie('bk_cart');

        $bk_cart_arr = ($bk_cart != null ? explode(',',$bk_cart) : array());

        $member = $request -> session()->get('member','');
        if($member != ''){
            //获取登陆之后的member的id
           $cart_items = $this -> syncCart($member -> id ,$bk_cart_arr);
            return response()->view('cart',['cart_items' => $cart_items])->withCookie('bk_cart',null);
        }
        foreach ($bk_cart_arr as $key => $value){
            $index = strpos($value , ':');
            $cart_item = new CartItem();
            $cart_item -> id = $key;
            $cart_item -> product_id = substr($value , 0 , $index);
            $cart_item -> count = (int) substr($value , $index+1);
            $cart_item -> product = Product::find($cart_item -> product_id);//根据获取的cookie获取该商品的id

            if($cart_item -> product != null){
                array_push($cart_items , $cart_item);
            }
        }
        return view('cart')->with('cart_items' , $cart_items);
    }


    private  function syncCart($member_id , $bk_cart_arr){
        $cart_items = CartItem::where('member_id' , $member_id)->get();

        $cart_items_arr = array();

        foreach ($bk_cart_arr as  $value){
            $index = strpos($value ,':');
            $product_id = substr($value , 0 , $index);
            $count = (int) substr($value , $index+1);

            //判断离线购物车中product_id 是否存在 数据库中
            $exist = false;
            foreach ($cart_items as $temp) {
                //判断数据库中的产品id跟cookie的id是否一致
                if($temp -> product_id == $product_id){
                    //如果数据库的购物车数量比cookie记录的多，则同步到数据库
                    if ($temp -> count < $count){
                        $temp -> count = $count;
                        $temp -> save();
                    }
                    $exist = true;
                    break;
                }
            }

            //product_id没有cookie里  就存储进去
            if($exist == false){
                $cart_item = new CartItem;
                $cart_item->member_id = $member_id;
                $cart_item->product_id = $product_id;
                $cart_item->count = $count;
                $cart_item->save();
                $cart_item->product = Product::find($cart_item->product_id);

                array_push($cart_items_arr , $cart_item);
            }
        }

        //为每个对象附加产品对象便于显示
        foreach ($cart_items as $cart_item) {
            $cart_item->product = Product::find($cart_item -> product_id);
            array_push($cart_items_arr , $cart_item);
        }


        return $cart_items_arr;
    }
}