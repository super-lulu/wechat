<?php 
include "./weChat.class.php";
// TOKEN
define("TOKEN", "songjp");
$wechat = new Wechat("wx590d3e945a25dffd", "25880fa4c11602c361f3ac7928ac0c4b");

if($_GET["echostr"]){
	$wechat->valid();	
} else {
	$wechat->responseMsg();
}
 ?>