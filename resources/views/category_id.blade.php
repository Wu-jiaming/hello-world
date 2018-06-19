@extends('master')

@section('title','类别内容')

@section('content')
    <div class="weui_cells_title">
        <span>{{$category->name}}</span>


    </div>

    <div class="weui_cells">

       @foreach($products as $product)
            <div class="weui_cell">
                <input type="text" class="weui_check" name="cart_item" id="{{$product->id}}" />

                <img src="{{url($product->preview)}}" style="" class="bk_icon" onclick="_toPdt_content({{$product->id}})"/>
            </div>

            <div class="weui_cell_bd weui_cell_primary">
                <p class="bk_summary">{{$product->name}}</p>
            </div>

            <div class="weui_cell_ft">
                ￥<span class="bk_summary" style="color: black;">{{$product->price}}</span>
            </div>


        @endforeach

    </div>
    <div class="weui_cells_tips" style="text-align: right;">
    @stop

@section('my-js')
            <script type="text/javascript">
                function _toPdt_content(id) {
                    location.href = "{{url('/product/')}}"+"/"+id;
                }
            </script>
@stop