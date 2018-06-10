<?php
namespace App\Http\Controllers\Service;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Http\Controllers\Controller;
use App\Models\M3Result;
use Illuminate\Http\Request;

class OrderController extends Controller{
    public function deleteOrder(Request $request){
        $order_ids = $request->input('order_ids','');
        $order_ids_arr = explode(',',$order_ids);
        $member = $request->session()->get('member','');

        $m3_result = new M3Result();
        $m3_result->status = 0;
        $m3_result->message='订单删除成功';
        if ($member == null){
            $m3_result->status = 1;
            $m3_result->message='请先登录！';
            return $m3_result;
        }else{
            Order::whereIn('id',$order_ids_arr)
                    ->where('member_id','=',$member->id)->delete();

            OrderItem::whereIn('order_id',$order_ids_arr)->delete();

            return $m3_result->toJson();
        }
        return $m3_result->toJson();

    }
}