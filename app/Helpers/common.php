<?php
/**
 * Created by PhpStorm.
 * User: 贾鑫晨
 * Date: 2019/6/21
 * Time: 9:36
 */

 /**
      * 发送请求
      * @param $Url
      * @param string $method
      * @param array $data
      * @param string $dataType
      */
 function curl($Url,$method =  'GET',$data = array()){
         $curl = curl_init();
         curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);           //设置返回值以变量形式输出  不输出在浏览器上
         curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);       //禁止验证证书
         curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);       //

         if(!empty($data)){
             $data = http_build_query($data);
         }

         switch ($method){
             case 'GET':
                 curl_setopt($curl,CURLOPT_POST,1);
                 curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
                 break;
             case 'POST';
                 curl_setopt($curl,CURLOPT_POST,1);
                 curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
                 break;
             case 'PUT':
                 curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'PUT');
                 curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
                 break;
             case 'DELETE':
                 curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'DELETE');
                 curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
                 break;
         }

         curl_setopt($curl,CURLOPT_URL,$Url);  //设置的访问的地址
         $data = curl_exec($curl);
         curl_close($curl);
         return $data;
     }