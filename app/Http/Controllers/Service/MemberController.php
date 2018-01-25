<?php

namespace App\Http\Controllers\Service;



use App\Entity\Member;
use App\Entity\TempEmail;
use App\Entity\TempPhone;
use App\Http\Controllers\Controller;
use App\Models\M3Email;
use App\Models\M3Result;
use App\Tool\UUID;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class MemberController extends Controller
{
    public function register(Request $request){
        $email = $request->input('email','');
        $password = $request->input('password','');
        $phone = $request->input('phone','');
        $confirm = $request->input('confirm','');
        $phone_code = $request->input('phone_code', '');
        $validate_code = $request->input('validate_code', '');

        $m3_result = new M3Result();

        if($email == '' && $phone == ''){
            $m3_result->status = 1;
            $m3_result->message = '手机号或者邮箱不能为空';
            return $m3_result->toJson();
        }


        if ($password == '' || strlen($password) < 6 || strlen($password) > 20){
            $m3_result->status = 2;
            $m3_result->message = '密码不能为空 或密码大于6位小于20位';
            return $m3_result->toJson();
        }

        if ($password != $confirm){
            $m3_result->status = 3;
            $m3_result->message = '2次密码不符';
            return $m3_result->toJson();
        }

        if ($phone != ''){
            if ($phone_code == '' || strlen($phone_code)!=6){
                $m3_result->status = 4;
                $m3_result->message = '手机验证码为6位';
                return $m3_result->toJson();
            }

            $tempPhone = TempPhone::where('phone',$phone)->first();
            if ($tempPhone->code == $phone_code){
                if (time() > strtotime($tempPhone->deadline)){
                    $m3_result->status = 6;
                    $m3_result->message='手机验证码已过期';
                    return $m3_result->toJson();
                }//字符串转时间

                $member = new  Member();
                $member->phone = $phone;
                $member->password = md5('bk'+$password);
                $member->active = 1;
                $member->save();

                $m3_result->status = 0;
                $m3_result->message = '注册成功';
                return $m3_result->toJson();
            }else{
                $m3_result->status = 5;
                $m3_result->message= '手机验证码不正确2';
                return $m3_result->toJson();
            }

        }    //邮箱注册
        else{
            if($validate_code == '' || strlen($validate_code) != 4) {
                $m3_result->status = 6;
                $m3_result->message = '验证码为4位';
                return $m3_result->toJson();
            }
            //当session中的验证码跟输入的验证码不正确
            $validate_code_session = $request->session()->get('validate_code','');
            if ($validate_code_session != $validate_code){
                $m3_result->status = 8;
                $m3_result->message = '验证码不正确';
                return $m3_result->toJson();
            }

            $member = new Member();//获取数据库的对象
            $member->email = $email;//$member->email表示数据库对象的email属性
            $member->password = md5('bk'+$password);
            $member->save();

            $uuid = UUID::create();

            $m3_email = new M3Email();
            $m3_email->to = $email;
            $m3_email->cc = 'ndjfhrhge@163.com';
            $m3_email->subject = 'LA书店验证';
            $m3_email->content = '请于24小时内点击该链接完成验证.http://localhost:8080/laravel2/public/service/validate_email'
                                    . '?member_id=' . $member->id
                                    . '&code=' . $uuid;



            $tempEmail = new TempEmail();
            $tempEmail->member_id = $member->id;
            $tempEmail->code = $uuid;
            $tempEmail->deadline = date('Y-m-d H-i-s',time() + 24*60*60);
            $tempEmail->save();


            //email_register视图，把m3_email这个数组放到视图里面，可以直接用
            Mail::send('email_register',['m3_email' => $m3_email],function ($m) use ($m3_email){
             // $m->from('ndjfhrhge@163.com','Your Application');
              $m->to($m3_email->to,'尊敬的用户')
                ->cc($m3_email->cc)
                ->subject($m3_email->subject);
            });

            $m3_result->status = 0;
            $m3_result->message = '注册成功';
            return $m3_result->toJson();
        }


    }


}
