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
//  创建菜单的地址
$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;

$data = '{
     "button":[
     {	
          "type":"click",
          "name":"今日歌曲",
          "key":"V1001_TODAY_MUSIC"
      },
      {
           "name":"菜单",
           "sub_button":[
           {	
               "type":"view",
               "name":"搜索",
               "url":"http://www.soso.com/"
            },
            {
               "type":"click",
               "name":"赞一下我们",
               "key":"V1001_GOOD"
            }]
       }]
 }';
 
 
// 开启curl 初始化
$ch = curl_init();
// 设置传输地址
curl_setopt($ch, CURLOPT_URL, $url);
// 以文件流的形式返回
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//  设置以POST方式发送
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
// 发送curl
// 返回json对象
$arr1 = curl_exec($ch);
// 转换为数组
$arrs1 = json_decode($arr1, TRUE);

// 关闭
curl_close($ch);
 
 
