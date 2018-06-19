<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/user',function (){
    return \App\Member::all();
});

//加斜杠  表示根目录下
Route::get('/login','View\MemberController@toLogin');
Route::get('/register', ['uses'=>'View\MemberController@toRegister']);
Route::get('/category', ['uses'=>'View\BookController@toCategory']);
Route::get('/product/{product_id}', ['uses'=>'View\BookController@toProduct']);


Route::get('/product/{product_id}',['uses' => 'View\BookController@toPdtContent']);
Route::get('/product/category_id/{category_id}',['uses' => 'View\BookController@toCategory_id']);
Route::get('/cart',['uses' => 'View\CartController@toCart']);

Route::group(['middleware' => 'check.login'] , function (){
    Route::get('/order_commit/{product_ids_arr}',['uses' => 'View\OrderController@toOrderCommit']);
    Route::get('/order_list',['uses' => 'View\OrderController@toOrderList']);

});

Route::group(['prefix' => 'service'] ,function (){
    Route::get('validate_code',['uses'=>'Service\ValidateController@create']);
    Route::post('validate_phone/send',['uses'=>'Service\ValidateController@sendSMS']);
    Route::any('validate_email',['uses'=>'Service\ValidateController@validateEmail']);

    Route::post('register',['uses'=>'Service\MemberController@register']);
    Route::post('login',['uses'=>'Service\MemberController@login']);
    Route::get('category/parent_id/{parent_id}', ['uses'=>'Service\BookController@getCategoryByParentId']);
    Route::get('cart/add/{product_id}', ['uses'=>'Service\CartController@addCart']);
    Route::get('cart/delete', ['uses'=>'Service\CartController@deleteCart']);
    Route::post('upload/{type}',['uses'=>'Service\UploadController@uploadFile']);
    Route::post('order/delete',['uses'=>'Service\OrderController@deleteOrder']);

});

Route::group(['prefix' => 'admin'] , function (){
    Route::group(['prefix' => 'service'] , function (){
      Route::post('login',['uses'=>'Admin\IndexController@login']);
      Route::post('category/add',['uses'=>'Admin\CategoryController@categoryAdd']);
      Route::post('category/delete',['uses'=>'Admin\CategoryController@categoryDelete']);
      Route::post('category/edit',['uses'=>'Admin\CategoryController@categoryEdit']);
      Route::post('category/items_delete',['uses'=>'Admin\CategoryController@itemsDelete']);
      Route::post('upload/{type}',['uses'=>'Admin\UploadController@uploadFile']);

      Route::post('product/add',['uses'=>'Admin\ProductController@productAdd']);
      Route::post('product/edit',['uses'=>'Admin\ProductController@productEdit']);
      Route::post('product/delete',['uses'=>'Admin\ProductController@productDelete']);
      Route::post('product/items_delete',['uses'=>'Admin\ProductController@itemsDelete']);






    });
    Route::get('login',['uses'=>'Admin\IndexController@toLogin']);
    Route::get('index',['uses'=>'Admin\IndexController@toIndex']);
    Route::get('category',['uses'=>'Admin\CategoryController@toCategory']);
    Route::get('category_add',['uses'=>'Admin\CategoryController@toCategoryAdd']);
    Route::get('category_edit',['uses'=>'Admin\CategoryController@toCategoryEdit']);
    Route::get('product',['uses'=>'Admin\ProductController@toProduct']);
    Route::get('product_add',['uses'=>'Admin\ProductController@toProductAdd']);
    Route::get('product_edit',['uses'=>'Admin\ProductController@toProductEdit']);
    Route::get('product_info',['uses'=>'Admin\ProductController@toProductInfo']);


});