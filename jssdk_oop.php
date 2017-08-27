<?php
include "./weChat.class.php";

$wechat = new Wechat("wx590d3e945a25dffd", "25880fa4c11602c361f3ac7928ac0c4b");
$arr = $wechat->getSignature();
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
            debug: true, 
            appId: '<?php echo $arr["appid"]?>', // appId
            timestamp: '<?php echo $arr["timestamp"]?>', 
            nonceStr: '<?php echo $arr["nonceStr"]?>', 
            signature: '<?php echo $arr["signature"]?>',
            jsApiList: ['chooseImage']
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
