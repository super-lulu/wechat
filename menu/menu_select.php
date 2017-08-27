<?php
include "../weChat.class.php";
$wechat = new Wechat("wx590d3e945a25dffd", "25880fa4c11602c361f3ac7928ac0c4b");
$arr = $wechat->menu_select();
var_dump($arr);