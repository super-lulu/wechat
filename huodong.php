<?php
$appid="wx590d3e945a25dffd";
$appsecret = "25880fa4c11602c361f3ac7928ac0c4b";
$redirect_url = "http://123.207.190.148/wechat/huodong.php";
// // 外面访问redirect_url时 会转到下面的url 同时
// //访问下面的url时 会在上面的redirect_url后面带上参数?code
$url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".$redirect_url."&response_type=code&scope=snsapi_base&state=123#wechat_redirect";
if(!isset($_GET["code"])){
    header("location:".$url);
    exit;
}
$code = $_GET["code"];
$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$appsecret."&code=".$code
."&grant_type=authorization_code ";
var_dump(https_request($url)); 

//     // 	模拟get请求和post请求
    
function https_request($url, $data=""){
    // 开启curl 初始化
    $ch = curl_init();
    // 设置传输地址
    curl_setopt($ch, CURLOPT_URL, $url);
    // 以文件流的形式返回
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if($data){
        // 以post的方式
        //  设置以POST方式发送
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }
    // 发送curl
    // 返回json对象
    $request = curl_exec($ch);
    // 转换为数组
    $tmpArr = json_decode($request, TRUE);
    
    // 如果能转换成数组
    if(is_array($tmpArr)){
        return $tmpArr;
    } else {
        return $request;
    }
}