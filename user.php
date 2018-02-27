<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-02-04
 * Time: 13:01
 */



/*
 * 状态码：
 * 200：已登录
 * 100：未登录
 * 404：未选择课程
 * 101：用户名或密码错误
 * 401：邮件发送时间不足1分钟
 * 402：邮件发送失败*/
include "consql.php";
session_start();
if (!isset($_SESSION['id']))
{
    echo "{status:100,user:''}";
    return 0;
}else{
    $result=mysql_query("select * from student_info where s_number='".$_SESSION['id']."';");
    $row=mysql_fetch_array($result);
    $name=$row["name"];
    $sex=$row["sex"];
    $num=$_SESSION['id'];
    $email=$row['email'];

}


switch ($_POST['act']){
    case "name":
        echo "{status:200,user:"."\"".$name."\""."}";
        break;
    case "logout":
        session_destroy();
        echo "{status:100,user:''}";
        break;
    case "checkinfo":
        echo "{status:200,name:"."\"".$name."\",sex:"."\"".$sex."\",number:"."\"".$num."\",email:"."\"$email"."\"}";
        break;
    case "changepwd":
        $newpwd = md5($_POST['newpwd']);
        $row1 = mysql_query("update student_info set password ="."'".$newpwd."'"." WHERE s_number = " ."'". $num."'");
        echo "{status:200}";
        break;
    case "changeemail":
        $newemail = $_POST['newemail'];
        $row1 = mysql_query("update student_info set email ="."'".$newemail."'"." WHERE s_number = " ."'". $num."'");
        echo "{status:200}";
        break;
    case "checkwork":
        $res=mysql_query("select * from homework");
        $row1=mysql_fetch_array($res);
        $workinfo=$row1['work'];
        $csharp=$row['csharp'];
        $ps=$row['Photoshop'];
        $wy=$row['webpage'];
        $zy=$row['zy'];
        $classes = array();
        $classesed = array();
        if($row1["csharp"]){
            array_push($classes, "c#");
        }
        if($row1["Photoshop"]){
            array_push($classes, "ps");
        }
        if($row1["webpage"]){
            array_push($classes, "网页");
        }
        if($csharp){
            array_push($classesed, "c#");
        }
        if($ps){
            array_push($classesed, "photoshop");
        }
        if($zy){
            array_push($classesed, "zy");
        }
        if($wy){
            array_push($classesed, "网页");
        }
        $len = sizeof($classes);
        $len1 = sizeof($classesed);
        $class = "";
        $classed = "";
        for ($i=0;$i<$len;$i++){
            $class .= "\"".$classes[$i]."\"";
            if ($i != $len-1){
                $class .= ",";
            }
        }
        for ($j=0;$j<$len1;$j++){
            $classed .= "\"".$classesed[$j]."\"";
            if ($j != $len1-1){
                $classed .= ",";
            }
        }
        echo "{status:200,workinfo:"."\"".$workinfo."\",classes:[".$class."],classesed:[".$classed."]}";
        break;
}

?>