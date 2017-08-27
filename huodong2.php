<?php
$appid="wx590d3e945a25dffd";
$appsecret = "25880fa4c11602c361f3ac7928ac0c4b";
$redirect_url = "http://123.207.190.148/wechat/huodong2.php";
// // 外面访问redirect_url时 会转到下面的url 同时
// //访问下面的url时 会在上面的redirect_url后面带上参数?code
$url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".$redirect_url."&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect";
if (!isset($_GET["code"])) {
	header('location:'.$url);
	exit;
}

$code=$_GET['code'];
var_dump($code);
// 获取网页授权的access_token 和用户openid
header("location:'midturn.php?code='".$code); 