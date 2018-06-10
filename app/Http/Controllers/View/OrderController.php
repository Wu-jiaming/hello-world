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
        //订单物品
        $order = new Order();
        $order->member_id = $member->id;
        $order->save();

        $cart_items_arr = array();
        $cart_items_ids_arr = array();
        $total_price =0;
        $name = '';
        foreach ($cart_items as $cart_item){
            $cart_item-> product = Product::find($cart_item->product_id);

            if($cart_item->product != null){
                $name .= $cart_item->count .'*'. $cart_item->product->name;
                array_push($cart_items_arr,$cart_item);
                array_push($cart_items_ids_arr,$cart_item->id);
                $total_price =$cart_item-> product->price * $cart_item->count +$total_price;

                $order_item = new OrderItem();
                $order_item->order_id = $order->id;
                $order_item->product_id = $cart_item->product_id;
                $order_item->count = $cart_item->count;
                $order_item->save();
            }
        }
        //购物车下单后，清空
        CartItem::whereIn('id',$cart_items_ids_arr)->delete();
        $order_id = $this->toOrderId();

        //保存在订单中
        $order->name = $name;
        $order->order_no = $order_id;
        $order->total_price=$total_price;


        $order->save();

        return view('order_commit')->with('cart_items',$cart_items_arr)
                                        ->with('order_id',$order_id)
                                            ->with('name',$name)
                                            ->with('total_price',$total_price);
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

    private function toOrderId(){
        $order_date = date('Y-m-d');

        //订单号码主体（YYYYMMDDHHIISSNNNNNNNN）

        $order_id_main = date('YmdHis') . rand(10000000,99999999);

        //订单号码主体长度

        $order_id_len = strlen($order_id_main);

        $order_id_sum = 0;

        for($i=0; $i<$order_id_len; $i++){

            $order_id_sum += (int)(substr($order_id_main,$i,1));

        }

        //唯一订单号码（YYYYMMDDHHIISSNNNNNNNNCC）

        $order_id = $order_id_main . str_pad((100 - $order_id_sum % 100) % 100,2,'0',STR_PAD_LEFT);

        return $order_id;
    }
}