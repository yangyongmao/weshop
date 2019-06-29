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
        $json = json_encode($request->session()->get('adminAccess'));
        $array = json_decode($json,true);

        if(!empty($array)){
            if(!(in_array($request->path(),array_column($array,'n_name')))){
                echo "<script>
                        alert('无权限');
                       </script>";die();
            }else{
                //从session查出权限验证是否存在
                return $next($request);
            }
        }else{
            echo "<script>
                        alert('无权限');
                       </script>";die();
        }


    }
}
