<?php
namespace App\Http\Controllers\Service;

use App\Entity\CartItem;
use App\Entity\Category;
use App\Http\Controllers\Controller;
use App\Models\M3Result;
use Illuminate\Http\Request;

class CartController extends Controller{
    public function addCart(Request $request ,$product_id){
        $m3_result = new M3Result();
        $m3_result -> status = 0;
        $m3_result -> message = '添加成功！';

        //已经登录
        $member = $request -> session() ->get('member' , '');
        if($member != ''){
            $cart_items = CartItem::where('member_id' , $member->id)->get();
            $exist = false;
            foreach($cart_items as $cart_item){
                if ($cart_item->product_id == $product_id){
                    $cart_item->count++;
                    $cart_item->save();
                    $exist = true;
                    break;
                }

            }

            if ($exist == false){
                $cart_item = new CartItem();
                $cart_item -> product_id = $product_id;
                $cart_item -> count = 1;
                $cart_item -> member_id = $member->id;
                $cart_item->save();
            }

            return $m3_result->toJson();
        }
        $bk_cart = $request->cookie('bk_cart');
        $bk_cart_arr = ($bk_cart!=null ? explode(',',$bk_cart) : array());

        $count = 1 ;
        foreach($bk_cart_arr as &$value){//$bk_cart_arr这个是基本类型数组，非对象，所有要传引用
            $index = strpos($value , ":");//获取：的索引
            if (substr($value , 0 , $index) == $product_id){
                $count = ((int)substr($value , $index+1))+1;//因位索引从0开始
                $value = $product_id . ':' . $count;
                break;
            }
        }

        if($count == 1){
            //找不到该产品，所以要把该记录push进来
            array_push($bk_cart_arr , $product_id . ':' . $count);
        }



        return response($m3_result -> toJson())->withCookie("bk_cart" , implode( ',' , $bk_cart_arr));


    }

    public function deleteCart(Request $request){

        $product_ids = $request -> input('product_ids','');

        $m3_result = new M3Result();
        $m3_result -> status = 0;
        $m3_result -> message = '删除成功';

        if ($product_ids == null){
            $m3_result->status = 1;
            $m3_result->message = '书籍id为空';
            return $m3_result->toJson();
        }

        $product_ids_arr = explode(',' , $product_ids);

        //判断登录
        $member = $request->session()->get('member' , '');
        if ($member != ''){
            CartItem::whereIn('product_id' , $product_ids_arr)
                        ->where('member_id','=',$member->id)->delete();
            return $m3_result->toJson();
        }

        $bk_cart  = $request->cookie('bk_cart');
        $bk_cart_arr = ($bk_cart != null  ? explode(',' , $bk_cart) : array());



        foreach ($bk_cart_arr as $key => $value){//跟平时的foreach循环就时多了一个将索引放到$key中
            $index = strpos($value , ':');
            $product_id = substr($value , 0 , $index);
            //存在  删除
            if(in_array($product_id , $product_ids_arr)){
                array_splice($bk_cart_arr,$key , 1);//把空字符串 替换 $bk_cart_arr的索引为$key的值
                continue;
            }
        }

        
        return response($m3_result->toJson())->withCookie('bk_cart',implode(',',$bk_cart_arr));

    }


}