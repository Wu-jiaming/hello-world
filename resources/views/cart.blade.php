@extends('master')

@section('title','购物车')

@section('content')
<div class="page bk_content" style="top: 0;">
    <div class="weui_cells weui_cells_checkbox">
        @foreach($cart_items as $cart_item)
            <label class="weui_cell weui_check_label" for="{{$cart_item->product->id}}">
            <div class="weui_cell_hd" style="width: 23px;">
                <input type="checkbox" class="weui_check" name="cart_item" id="{{$cart_item->product->id}}" checked="checked"/>
                <i class="weui_icon_checked"></i>
            </div>
            <div class="weui_cell_bd weui_cell_primary">
                <div style="position: relative;">
                    <img class="bk_preview" src="{{url($cart_item->product->preview)}}"
                        class="m3_preview" onclick="_toProduct({{$cart_item->product->id}})"/>

                    <div style="position: absolute; left: 100px ; right: 0px; top: 0px;" >
                        <p class="">{{$cart_item->product->name}}</p>
                        <p class="bk_time" style="margin-top: 15px;">
                            数量:<span class="bk_summary" style="">x{{$cart_item->count}}</span>
                        </p>
                        <p class="bk_time" style="">
                            总计：<span class="bk_price">￥{{$cart_item->product->price * $cart_item->count}}</span>
                        </p>
                    </div>
                </div>

            </div>
            </label>
        @endforeach
    </div>
</div>

    <div class="bk_fix_bottom">
        <div class="bk_half_area">
            <button class="weui_btn weui_btn_primary" onclick="_toCharge();">结算</button>
        </div>

        <div class="bk_half_area">
            <button class="weui_btn weui_btn_default" onclick="_onDelete();">删除</button>
        </div>
    </div>


@stop

@section('my-js')
    <script type="text/javascript">
        //判断是否被选中，然后添加或者移除css
        $('input:checkbox[name=cart_item]').click(function () {
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


        function _toCharge() {
            var product_ids_arr = [];
            $('input:checkbox[name=cart_item]').each(function (index , el) {
             if ($(this).attr('checked') == 'checked'){
                 product_ids_arr.push($(this).attr('id'));
             }
            });

            if (product_ids_arr.length == 0){
                $('.bk_toptips').show();
                $('.bk_toptips span').html('请选择提交项');
                setTimeout(function () {
                    $('.bk_toptips').hide();
                },2000);
            return;
            }

            location.href = "{{url('/order_commit/')}}"+ "/" + product_ids_arr ;
        }

        function _onDelete() {
            var product_ids_arr = [];
            $('input:checkbox[name = cart_item]').each(function (index , el) {
               if($(this).attr('checked') == 'checked'){
                   //把选中的项的id放进数组里面
                   product_ids_arr.push($(this).attr('id'));
               }
            });

            if(product_ids_arr.length == 0){
                $('.bk_toptips').show();
                $('.bk_toptips span').html('请选择删除项');
                setTimeout(function () {
                    $('.bk_toptipsk_').hide();
                },2000);
                return;
            }

            $.ajax({
                type:"GET",
                url:"{{url('/service/cart/delete')}}",
                dataType:'json',
                cache:false,
                data:{product_ids:product_ids_arr+''},//+‘’ 意思是为了让这个数组变成id，让控制器里使用
                success:function (data) {
                    if (data == null){
                        $('.bk_toptips').show();
                        $('.bk_toptips').html('服务器错误！')
                        setTimeout(function () {
                            $('.bk_toptips').hide();
                        },2000);
                        return;
                    }
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

