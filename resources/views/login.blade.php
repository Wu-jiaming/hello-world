@extends('master')

@include('component.loading')

@section('title','登录')

@section('content')
    <div class="weui_cells_title"></div>
<div class="weui_cells weui_cells_form">
    <div class="weui_cell">
        <div class="weui_cell_hd">
            <label class="weui_label">账号</label>
        </div>

        <div class="weui_cell_hd weui_cell_primary">
            <input class="weui_input" type="tel" placeholder="邮箱或手机号" />
        </div>
    </div>

    <div class="weui_cell">
        <div class="weui_cell_hd">
            <label class="weui_label">密码</label>
        </div>
        <div class="weui_cell_hd weui_cell_primary" >
            <input  class="weui_input" type="password" placeholder="不少于6位"/>
        </div>
    </div>

    <div class="weui_cell weui_vcode">
        <div class="weui_cell_hd">
            <label class="weui_label">验证码</label>
        </div>
        <div class="weui_cell_hd weui_cell_primary">

            <input class="weui_input" type="text" placeholder="请输入验证码" name="validate_code"/>

        </div>
        <div class="weui_cell_ft" style="cursor:pointer">
            <img src="{{url('service/validate_code')}}" class="bk_validate_code"  />
        </div>
    </div>
</div>

    <div class="weui_cells_tips">

    </div>

    <div class="weui_btn_area">
        <a class="weui_btn weui_btn_primary" href="javascript:" onclick="onLoginClick();">登录</a>
    </div>
    <a href="{{url('/register')}}" class="bk_bottom_tips bk_important">
        没有账号？去注册
    </a>
@stop

@section('my-js')
    <script type="text/javascript">

        $('.bk_validate_code').click(function () {
           $(this).attr('src',"{{url('/service/validate_code?random=')}}"+Math.random());

        });

    </script>
@stop