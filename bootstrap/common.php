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

function getData($data)
{
    static $array = array();

    foreach ($data as $k => $v)
    {
        if($v->cat_id == $data[$k]->cat_id ){
            $array[$v->cat_id]['cat_id'] = $v->cat_id;
            $array[$v->cat_id]['cat_name'] = $v->cat_name;
            if( isset($array[$v->cat_id]['goods']) && count($array[$v->cat_id]['goods']) >=4 ){
                continue;
            }
            $array[$v->cat_id]['goods'][$v->goods_id]['goods_id'] = $v->goods_id;
            $array[$v->cat_id]['goods'][$v->goods_id]['goods_name'] = $v->goods_name;
            $array[$v->cat_id]['goods'][$v->goods_id]['goods_img'] = $v->goods_img;

        }
    }
    return $array;
}