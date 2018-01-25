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

Route::get('/login', function (){
    return view('login');
});
Route::get('/login','View\MemberController@toLogin');
Route::get('/register', ['uses'=>'View\MemberController@toRegister']);

Route::any('service/validate_code',['uses'=>'Service\ValidateController@create']);
Route::any('service/validate_phone/send',['uses'=>'Service\ValidateController@sendSMS']);
Route::any('service/validate_email',['uses'=>'Service\ValidateController@validateEmail']);

Route::post('/service/register',['uses'=>'Service\MemberController@register']);