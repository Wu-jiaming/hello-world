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
Route::get('/product/category_id/{category_id}', ['uses'=>'View\BookController@toProduct']);
/*Route::get('/product/category_id/{category_id}', function (){
    return view('login');
});*/




Route::group(['prefix' => 'service'] ,function (){
    Route::get('validate_code',['uses'=>'Service\ValidateController@create']);
    Route::post('validate_phone/send',['uses'=>'Service\ValidateController@sendSMS']);
    Route::any('validate_email',['uses'=>'Service\ValidateController@validateEmail']);

    Route::post('register',['uses'=>'Service\MemberController@register']);
    Route::post('login',['uses'=>'Service\MemberController@login']);
    Route::get('category/parent_id/{parent_id}', ['uses'=>'Service\BookController@getCategoryByParentId']);
});