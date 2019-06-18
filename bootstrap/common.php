<?php
/**
 * Created by PhpStorm.
 * User: 杨永茂
 * Date: 2019/6/13
 * Time: 10:05
 */

function getTree($catLiat, $pid = 0, $level=1)
{
    static $arr = array();

    foreach ($catLiat as $k => $v){
        if( $v->pid == $pid ){
            $v->level = $level;
            $arr[] = $v;
            getTree($catLiat, $v->cat_id, $level+1);
        }
    }
    return $arr;
}