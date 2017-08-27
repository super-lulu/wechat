<?php
mysql_connect('localhost:3306','root','root');

mysql_set_charset("utf8");

//选择数据库 
mysql_select_db("WARNING");

$sql = "select * from Readme";

$res = mysql_query($sql);

while ($row = mysql_fetch_assoc($res)){
    var_dump($row);
    echo "<hr>";
}