<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-02-04
 * Time: 22:23
 */

include "consql.php";

$username=(int)$_POST["username"];
$password=$_POST["password"];
$mdpwd = md5($password);

$result=mysql_query("select * from student_info where s_number='".$username."';");
$row=mysql_fetch_array($result);
$dbusername=$row["s_number"];
$dbpassword=$row["password"];

if($mdpwd==$dbpassword){
    $name = $row["name"];
    session_start();
    $_SESSION["id"]=$username;
    echo "{status:200,user:"."\"".$name."\""."}";
    return 0;
}else{
    echo "{status:101}";
}

?>