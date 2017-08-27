<?php
// $appid="wx590d3e945a25dffd";
// $appsecret = "25880fa4c11602c361f3ac7928ac0c4b";
// $url="https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$appsecret}&code={$code}&grant_type=authorization_code";
var_dump($_GET["code"]);
// exit;
// var_dump(https_request($url)); 
// $access_token=$arr['access_token'];
// $openid=$arr['openid'];


// 获取用户的基本情况

// $url="https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";

// $userInfo=https_request($url);

// var_dump($userInfo);

// 	模拟get请求和post请求
// function https_request($url, $data=""){
//     // 开启curl 初始化
//     $ch = curl_init();
//     // 设置传输地址
//     curl_setopt($ch, CURLOPT_URL, $url);
//     // 以文件流的形式返回
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//     if($data){
//         // 以post的方式
//         //  设置以POST方式发送
//         curl_setopt($ch, CURLOPT_POST, 1);
//         curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//     }
//     // 发送curl
//     // 返回json对象
//     $request = curl_exec($ch);
//     // 转换为数组
//     $tmpArr = json_decode($request, TRUE);
    
//     // 如果能转换成数组
//     if(is_array($tmpArr)){
//         return $tmpArr;
//     } else {
//         return $request;
//     }
// }