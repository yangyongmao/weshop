<?php

namespace App\Http\Middleware;

use Closure;
use http\Env\Request;
use Illuminate\Support\Facades\DB;
class Token
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle( $request, Closure $next)
    {
        $token = $request->input('token');
        $data = DB::table('user')->where('token',$token)->first();
        if (!isset($request->token) || empty($data->token)) {

            return response()->json(
                ['code'=>'101','message'=>'令牌不存在']
            )->setEncodingOptions(JSON_UNESCAPED_UNICODE);
        }

        if ((time()-($data->time)) > 7200) {
            return response()->json(
                ['code'=>'102','message'=>'令牌已经过期']
            )->setEncodingOptions(JSON_UNESCAPED_UNICODE);
        }

        return $next($request);
    }
}