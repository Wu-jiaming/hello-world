<?php
namespace App\Http\Middleware;

use Closure;

class CheckLogin{
    public function handle($request , Closure $next){
        $http_referer = '';
        if(isset($_SERVER['HTTP_REFERER'])){//因为如果没有上一个页面记录会报错！
            $http_referer = $_SERVER['HTTP_REFERER'];//获取上次的页面记录
        }

        $member = $request->session()->get('member','');
        if ($member == ''){
            return redirect(url('/login?return_url=' . urlencode($http_referer)));

        }
        return $next($request);
    }
}