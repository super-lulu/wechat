<?php
include "./weChat.class.php";
// 随机数
$noncestr = "Wm3WZYTPz0wzccnW";
// 时间戳
$time = time();
$wechat = new Wechat("wx590d3e945a25dffd", "25880fa4c11602c361f3ac7928ac0c4b");
// 获取ticket
$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$wechat->get_access_token()."&type=jsapi";
$arr = $wechat->https_request($url);
$ticket = $arr["ticket"];
$str = "jsapi_ticket=".$ticket."&noncestr=".$noncestr."&timestamp=".$time."&url=http://123.207.190.148/wechat/jssdk.php";
$str = sha1($str);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <button id="btn">按钮</button>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
</head>
<body>
    <script>
        wx.config({
            debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
            appId: 'wx590d3e945a25dffd', // appId
            timestamp: <?php echo $time?>, // 必填，生成签名的时间戳
            nonceStr: '<?php echo $noncestr?>', // 必填，生成签名的随机串
            signature: '<?php echo $str?>',// 必填，签名，见附录1
            // 接口
            jsApiList: ['chooseImage'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
        });
        wx.ready(function(){
            var btn = document.getElementById('btn');
            btn.onclick = function(){
                wx.chooseImage({
                    success: function (res) {
                        var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
                    }
                });
            }
        });
    </script>
</body>
</html>
