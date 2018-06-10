@extends('master')

@section('title' , '订单列表')

@section('content')

    <div class="weui_cells weui_cells_checkbox">
    @foreach($orders as $order)

        <div class="weui_cells_title">
            <label class="weui_cell weui_check_label" for="{{$order->id}}">

                <div class="weui_cell_hd" style="width: 203px;">
                    <input type="checkbox" class="weui_check" name="order_item" id="{{$order->id}}" checked="checked"/>
                    <i class="weui_icon_checked"></i>
                </div>


                <span style="float: left;">订单号：{{$order->order_no}}</span>

                @if($order->status == 1)
                    <span style="float: right;" class="bk_price">
                    未支付
                </span>
                @else
                    <span style="float:right ;" class="bk_important">
                    已支付
                </span>
                @endif
            </label>

        </div>

        <div class="weui_cells">
            @foreach($order->order_items as $order_item)

                <div class="weui_cell">
                    <img src="{{url($order_item->product->preview)}}" class="bk_icon"/>

                </div>

                <div class="weui_cell_bd weui_cell_primary">
                    <p class="bk_summary">{{$order_item->product->name}}</p>
                </div>

                <div class="weui_cell_ft">
                    <span class="bk_summary">{{$order_item->product->price}}</span>
                    <span> x </span>
                    <span class="bk_important">{{$order_item->count}}</span>
                </div>

            @endforeach
        </div>
        <div class="weui_cells_tips" style="text-align: right;">
            合计：
            <span class="bk_price">{{$order->total_price}}</span>
        </div>
    @endforeach
    </div>



    <div class="bk_fix_bottom">
        <div class="bk_half_area">
            <button class="weui_btn weui_btn_primary" onclick="_toPay();">支付</button>
        </div>

        <div class="bk_half_area">
            <button class="weui_btn weui_btn_default" onclick="_onDelete();">删除</button>
        </div>
    </div>
@stop

@section('my-js')
    <script type="text/javascript">
        //判断是否被选中，然后添加或者移除css
        $('input:checkbox[name=order_item]').click(function () {
            var checked = $(this).attr('checked');
            if(checked == 'checked'){
                $(this).attr('checked',false);
                $(this).next().removeClass('weui_icon_checked');
                $(this).next().addClass('weui_icon_uncchecked');

            }else{
                $(this).attr('checked' , 'checked');
                $(this).next().removeClass('weui_icon_unchecked');
                $(this).next().addClass('weui_icon_checked');
            }
        });


        function _check(tip) {
            var order_ids_arr = [];
            $('input:checkbox[name=order_item]').each(function () {
                if ($(this).attr('checked') == 'checked'){
                    //$(this)指鼠标点击的标签
                    order_ids_arr.push($(this).attr('id'));
                }
            });

            if (order_ids_arr.length == 0){
                $('.bk_toptips').show();
                $('.bk_toptips span').html(tip);
                setTimeout(function () {
                    $('.bk_toptips').hide();
                },2000);
                return;
            }
            return order_ids_arr;
        }

        function _toPay() {
            var order_ids_arr = _check('请选择支付项');
            if (order_ids_arr == null){
                return;
            }

            $.ajax({
                type:'POST',
                url:'{{url('/service/order/pay')}}',
                dataType:'json',
                data:{
                    order_ids:order_ids_arr+'',
                    _token:"{{csrf_token()}}",
                },
                success:function () {
                  if (data == null){
                      $('.bk_toptips').show();
                      $('.bk_toptips span').html('服务器错误！');
                      setTimeout(function () {
                          $('.bk_toptips').hide();
                      },2000);
                    return;
                  }
                  if (data.message!=0){
                      $('.bk_toptips').show;
                      $('.bk_toptips span').html(data.message);
                      setTimeout(function () {
                          $('.bk_toptips').hide();
                      },2000);
                      return;
                  }

                  location.href = '{{url('/login')}}';

                },

                error:function (xhr,status,error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });

        }

        function _onDelete() {
            var order_ids_arr = _check('请选择删除项');
            if(order_ids_arr == null){
                return;
            }

            $.ajax({
                type:'POST',
                url:'{{url('/service/order/delete')}}',
                dataType:'json',
                data:{
                    order_ids:order_ids_arr+'',
                    _token:"{{csrf_token()}}"
                },

                success:function (data) {
                    if (data == null){
                        $('.bk_toptips').show();
                        $('.bk_toptips span').html('服务器错误');
                        setTimeout(function () {
                            $('.bk_toptips').hide();
                        },2000);
                        return;
                    }
                    if (data.status!=0){
                        $('.bk_toptips').show();
                        $('.bk_toptips span').html(data.message);
                        setTimeout(function () {
                            $('.bk_toptips').hide();
                        },2000);
                        return;
                    }
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html('订单删除成功！');
                    setTimeout(function () {
                        $('.bk_toptips').hide();
                    },2000);
                    location.reload();
                },
                error:function (xhr,status,error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });
        }
        </script>
@stop