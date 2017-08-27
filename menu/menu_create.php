<?php
include "../weChat.class.php";
$wechat = new Wechat("wx590d3e945a25dffd", "25880fa4c11602c361f3ac7928ac0c4b");
$data = '{
     "button":[
     {	
          "type":"click",
          "name":"新闻",
          "key":"NEWS"
      },
      {
           "name":"菜单",
           "sub_button":[
           {	
               "type":"view",
               "name":"搜索",
               "url":"http://123.207.190.148/wechat/jssdk_oop.php"
            },
            {
               "type":"click",
               "name":"赞一下我们",
               "key":"ZAN"
            }]
       }]
 }';
 $arr = $wechat->menu_create($data);
 var_dump($arr);