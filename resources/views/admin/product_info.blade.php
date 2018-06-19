@extends('admin.master')

@section('content')
    <style>
        .row.cl {
            margin: 20px 0;
        }
    </style>

<form class="form form-horizontal" action="" method="post">
    <div class="row cl">
        <label class="form-label col-xs-6 col-sm-3"><span class="c-red">名称：</span></label>
        <div class="formControls col-xs-10 col-sm-5">
            {{$product->name}}
        </div>
        <div class="col-xs-8 col-sm-4">

        </div>
    </div>

    <div class="row cl">
        <label class="form-label col-xs-6 col-sm-3"><span class="c-red">简介：</span></label>
        <div class="formControls col-xs-10 col-sm-5">
            {{$product->summary}}
        </div>
        <div class="col-xs-8 col-sm-4">

        </div>
    </div>

    <div class="row cl">
        <label class="form-label col-xs-6 col-sm-3"><span class="c-red">价格：</span></label>
        <div class="formControls col-xs-10 col-sm-5">
            <span class="c-red">￥</span>{{$product->price}}
        </div>
        <div class="col-xs-8 col-sm-4">

        </div>
    </div>

    <div class="row cl">
        <label class="form-label col-xs-6 col-sm-3"><span class="c-red">类别：</span></label>
        <div class="formControls col-xs-10 col-sm-5">
            {{$product->category->name}}
        </div>
    </div>

    <div class="row cl">
        <div class="form-label col-xs-6 col-sm-3">预览图：</div>
        <div class="formControls col-xs-10 col-sm-5">
            @if($product->preview != null)
                <img id="preview_id" src="{{url($product->preview)}}" style="border: 1px solid #B8B9B9; width: 100px; height: 100px;"/>
            @endif
        </div>
    </div>

    <div class="row col">
        <label class="form-label col-xs-6 col-sm-3">详细内容：</label>
        <div class="formControls col-xs-12 col-sm-8">
            @if($pdt_content != null)
            {{$pdt_content->content}}
                @endif
        </div>
    </div>

    <div class="row cl">
        <label class="form-label col-xs-6 col-sm-3">产品图片：</label>
        <div class="formControls col-xs-12 col-sm-8">
            @if($pdt_images != null)
                @foreach($pdt_images as $pdt_image)
                <img src="{{url($pdt_image->image_path)}}" style="border: 1px solid #B8B9B9; width: 100px; height: 100px;" />
                @endforeach
            @endif
        </div>
    </div>

</form>
@stop