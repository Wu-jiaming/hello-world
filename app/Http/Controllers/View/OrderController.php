<?php
namespace App\Http\Controllers\View;

use App\Entity\CartItem;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller{
    public function toOrderCommit(Request $request , $product_ids){
        $product_ids_arr = ($product_ids!='' ? explode(',',$product_ids) : array());
        $member = $request->session()->get('member','');
        $cart_items = CartItem::where('member_id' ,$member->id)->whereIn('product_id',$product_ids_arr)->get();

        $cart_items_arr = array();
        foreach ($cart_items as $cart_item){
            $cart_item-> product = Product::find($cart_item->product_id);
            $cart_item -> price = '';

            if($cart_item->product != null){
                array_push($cart_items_arr,$cart_item);
            }
        }
        return view('order_commit')->with('cart_items',$cart_items_arr);
    }

    public function toOrderList(Request $request){
        $member = $request->session()->get('member','');
        //从会员中取出全部订单id
        $orders = Order::where('member_id',$member->id)->get();

        foreach ($orders as $order){
            //根据取出的订单id 获取订单的信息
            $order_items = OrderItem::where('order_id',$order->id)->get();
            //把订单的信息项目 赋给$order->order_items
            $order->order_items = $order_items;

            //同一个订单 order_item可以有多个产品在里面 即order_id相同，product_id可不同
            foreach ($order_items as $order_item){
                $order_item -> product = Product::find($order_item->product_id);
            }
        }
        return view('order_list')->with('orders' , $orders);
    }
}