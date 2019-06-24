<?php

namespace App\Http\Middleware;

use Closure;

class CheckModule
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
        $controllerName = request()->route()->getActionName();
        $strat = strripos($controllerName,'\\');
        $end = strripos($controllerName,'@');
        $length = $end - $strat;
        $controllerName = strtolower(substr($controllerName,$strat + 1,$length - 11));
        $actionName = strtolower(request()->route()->getActionMethod());
        $module = $controllerName.'/'.$actionName;

//        if(!(in_array($request->path(),$request->session()->get('adminAccess')))){
//            //没权限
//        }else{
//            //从session查出权限验证是否存在
//            return $next($request);
//        }
//        var_dump($request->path());
        return $next($request);

    }
}
