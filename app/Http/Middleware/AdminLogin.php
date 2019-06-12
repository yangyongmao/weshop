<?php

namespace App\Http\Middleware;

use Closure;

class AdminLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /**
         * 检查登录访问者是否登录
         * 不存在session重定向到登录页面
         */
        $thisAdmin = $request->session()->get('thisAdmin');
        if(empty($thisAdmin)){
            return redirect("admin/login");
        }
        return $next($request);
    }
}
