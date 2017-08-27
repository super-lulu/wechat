<?php
$appid = "wx590d3e945a25dffd";
$appsecret = "25880fa4c11602c361f3ac7928ac0c4b";
$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;

// 开启curl 初始化
$ch = curl_init();
// 设置传输地址
curl_setopt($ch, CURLOPT_URL, $url);
// 以文件流的形式返回
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// 发送curl
// 返回json对象
$arr = curl_exec($ch);
// 转换为数组
$arrs = json_decode($arr, TRUE);
$access_token = $arrs['access_token'];
curl_close($ch);

$url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=".$access_token;

// 开启curl 初始化
$ch = curl_init();
// 设置传输地址
curl_setopt($ch, CURLOPT_URL, $url);
// 以文件流的形式返回
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// 发送curl
// 返回json对象
$arr = curl_exec($ch);
// 转换为数组
$arrs = json_decode($arr, True);
curl_close($ch);
var_dump($arrs);


