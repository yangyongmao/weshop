<?php

namespace App\Http\Middleware;

use Closure;

class Token
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
        // echo $request->token;
        // var_dump(session($request->token));
        // var_dump(empty(session($request->token)));
        if (!isset($request->token) || empty(session($request->token))) {
            echo 123;
            return response()->json(
                ['code'=>'101','message'=>'令牌不存在']
            );
        }
        if ((time()-session($request->token))>7200) {
            return response()->json(
                ['code'=>'102','message'=>'令牌已经过期']
            );
        }

        return $next($request);
    }
}