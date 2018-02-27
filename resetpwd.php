<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-02-06
 * Time: 21:42
 */
header("Content-type:text/html;charset=utf-8");
include "consql.php";

$user = $_GET["user"];
$yzm = $_GET["yzm"];
$result=mysql_query("select * from forgetpwd where username='".$user."'and isuse = 'false' order by starttime desc limit 1;;");
$row=mysql_fetch_array($result);
$start = $row['starttime'];
$inserttime = strtotime($start);
$now = strtotime(date("Y-m-d H:i:s"));
$datayzm = md5($row['yzm']);
$mm = md5($user);
if ($yzm==$datayzm && $now-$inserttime<1800){
    $row = mysql_query("update forgetpwd set isuse = 'true' WHERE starttime = " ."'". $start."'");
    $row1 = mysql_query("update student_info set password ="."'".$mm."'"." WHERE s_number = " ."'". $user."'");
//    $sqlcmd = mysql_query("update student_info set password = "."\"".$user."\""."where username="."\"".$user."\"");
//    $sqlcmd1 = mysql_query("update forgetpwd set isuse = \"true\" WHERE starttime = "."\"".$inserttime."\"");

    echo "密码已重置成学号，登陆后请修改密码！";
}else{
    echo "连接有误或时间已过期";
}