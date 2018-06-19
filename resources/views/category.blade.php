@extends('master')

@section('title','书籍类别')

@section('content')
    <div class="page__bd">
        <!--<a href="javascript:;" class="weui-btn weui-btn_primary">点击展现searchBar</a>-->
        <div class="weui-search-bar" id="searchBar">
            <form class="weui-search-bar__form">
                <div class="weui-search-bar__box">
                    <i class="weui-icon-search"></i>
                    <input type="search" class="weui-search-bar__input" id="searchInput" placeholder="搜索" required/>
                    <input type="button" name="search" value="搜索" onclick="_search()"></input>
                </div>

            </form>
        </div>
    </div>

    <div class="weui_cells_title">选择书籍类别</div>
    <div class="weui_cells weui_cells_split">
        <div class="weui_cell weui_cell_select">
            <div class="weui_cell_bd weui_cell_primary">
                <select class="weui_select" name="category">
                    @foreach($categorys as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>

        </div>
    </div>

    <div class="weui_cells weui_cells_access">
        <a class="weui_cell" href="javascript:;">
            <div class="weui_cell_bd weui_cell_primary">
                <p>cell standard</p>
            </div>
            <div class="weui_cell_ft">说明文字</div>
        </a>

        <a class="weui_cell" href="javascript:;">
            <div class="weui_cell_bd weui_cell_primary">
               <p>cell standard2</p>
            </div>
            <div class="weui_cell_ft">说明文字2</div>
        </a>
    </div>
@stop

@section('my-js')
    <script type="text/javascript">
        function _search() {
            location.href = "{{url('/product/category_id/7')}}";
        }

        function search() {
            var name = $('.weui-search-bar__box').val();
            console.log('name:'+name);

            $.ajax({
                type:"GET",
                url:"{{url('/service/category/name/')}}"+"/"+ name ,
                dataType:'json',
                cache:false,
                success:function (data) {
                    console.log('获取商品数据！');
                    console.log(data);

                    if(data == null){
                        $('.bk_toptips').show();
                        $('.bk_toptips span').html('服务器错误');
                        setTimeout(function () {
                            $('.bk_toptips').hide();
                        },2000);
                        return;
                    }

                    if(data.status != 0){
                        $('.bk_toptips').show();
                        $('.bk_toptips').html('data.message');
                        setTimeout(function () {
                            $('.bk_toptips').hide();
                        },2000);
                        return;
                    }
                    location.href = "{{url('/product/')}}"+"/"+data.id;


                },
                error:function (xhr,status,error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });
        }

        _getCategory();

        $('.weui_select').change(function (event) {
            _getCategory();
        });

        function _getCategory() {
            var parent_id = $('.weui_select option:selected').val();
            console.log('parent_id'+parent_id);

            $.ajax({
                type:"GET",
                url: "{{url('/service/category/parent_id/')}}"+"/"+ parent_id ,
                dataType:'json',
                cache:false,
                success:function (data) {
                    console.log('获取类别数据！');
                    console.log(data);

                    if(data == null){
                        $('.bk_toptips').show();
                        $('.bk_toptips span').html('服务器错误');
                        setTimeout(function () {
                            $('.bk_toptips').hide();
                        },2000);
                    return;
                    }

                    if(data.status != 0){
                        $('.bk_toptips').show();
                        $('.bk_toptips').html('data.message');
                        setTimeout(function () {
                            $('.bk_toptips').hide();
                        },2000);
                    return;
                    }


                    $('.weui_cells_access').html('');
                    for(var i = 0 ; i < data.categorys.length ; i++){
                        var next = "{{url('/product/category_id/')}}"+"/" + data.categorys[i].id;
                        var node =  '<a class="weui_cell" href=" ' +next+ ' ">'+

                                    '<div class="weui_cell_bd weui_cell_primary">'+

                                    '<p>'+data.categorys[i].name+'</p>'+

                                    '</div>'+

                                    '<div class="weui_cell_ft"></div>'+

                                     '</a>';

                        $('.weui_cells_access').append(node);

                    }
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