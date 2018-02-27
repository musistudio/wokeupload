<?php
/**
 * This example shows making an SMTP connection with authentication.
 */
//Import the PHPMailer class into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
//date_default_timezone_set('Etc/UTC');
//require '../vendor/autoload.php';
//Create a new PHPMailer instance
date_default_timezone_set("Asia/Shanghai");

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';
include "consql.php";
$user = $_POST['user'];
$result=mysql_query("select * from student_info where s_number='".$user."';");
$row=mysql_fetch_array($result);
$email = $row['email'];
$captch_code = "";
for($i=0;$i<4;$i++) {
    $data = 'abcdefghijklmnopqrstuvwxy123456789';
    $fontcontent = substr($data, rand(0, strlen($data) - 1), 1);
    $captch_code .= $fontcontent;
};
$mail = new PHPMailer;
//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 0;
//Set the hostname of the mail server
$mail->Host = 'smtp.qq.com';
//Set the SMTP port number - likely to be 25, 465 or 587
//$mail->Port = 25;
$mail->Port = 25;
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
//Username to use for SMTP authentication
$mail->Username = 'jsj1706@foxmail.com';
//Password to use for SMTP authentication
$mail->Password = 'tmcxwmntzzyvbhgi';
//Set who the message is to be sent from
$mail->setFrom('jsj1706@foxmail.com', '计算机1706班级作业系统');
//Set an alternative reply-to address
$mail->addReplyTo('replyto@example.com', 'First Last');
//Set who the message is to be sent to
$mail->addAddress($email, 'xxx');
//Set the subject line
$mail->Subject = '计算机1706作业系统密码重置';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
//Replace the plain text body with one created manually
$mail->isHTML(true);                                  // Set email format to HTML
$mail->Body    = '请点击以下链接进行密码重置，如无法点击请复制到浏览器打开。<br / ><a href="http://1706.musiiot.top/resetpwd.php?user='.$user.'&yzm='.md5($captch_code).'">http://127.0.0.1/homework/resetpwd.php?user='.$user.'&yzm='.md5($captch_code).'</a>';
$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');
//send the message, check for errors

$res=mysql_query("select * from forgetpwd where username='".$user."' and isuse = 'false' order by starttime desc limit 1;");
$row1=mysql_fetch_array($res);

if (strtotime(date("Y-m-d H:i:s"))-strtotime($row1['starttime'])<60){
    echo "{status:401}";
}else{
    if (!$mail->send()) {
        echo "{status:402}";
    } else {
        $result=mysql_query("INSERT INTO `forgetpwd` (`username`, `yzm`, `starttime`, `isuse`) VALUES ("."'".$user."'".", '".$captch_code."', CURRENT_TIMESTAMP, 'false')");
        echo "{status:200}";
    }
}<?php
/**
 * This example shows making an SMTP connection with authentication.
 */
//Import the PHPMailer class into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
//date_default_timezone_set('Etc/UTC');
//require '../vendor/autoload.php';
//Create a new PHPMailer instance
date_default_timezone_set("Asia/Shanghai");

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';
include "consql.php";
//$user = $_POST['user'];
$user = "2017002635";
$result=mysql_query("select * from student_info where s_number='".$user."';");
$row=mysql_fetch_array($result);
$email = $row['email'];
$captch_code = "";
for($i=0;$i<4;$i++) {
    $data = 'abcdefghijklmnopqrstuvwxy123456789';
    $fontcontent = substr($data, rand(0, strlen($data) - 1), 1);
    $captch_code .= $fontcontent;
};
$mail = new PHPMailer;
//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 0;
//Set the hostname of the mail server
$mail->Host = 'smtp.qq.com';
//Set the SMTP port number - likely to be 25, 465 or 587
//$mail->Port = 25;
$mail->Port = 25;
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
//Username to use for SMTP authentication
$mail->Username = 'jsj1706@foxmail.com';
//Password to use for SMTP authentication
$mail->Password = 'tmcxwmntzzyvbhgi';
//Set who the message is to be sent from
$mail->setFrom('jsj1706@foxmail.com', '计算机1706班级作业系统');
//Set an alternative reply-to address
$mail->addReplyTo('replyto@example.com', 'First Last');
//Set who the message is to be sent to
$mail->addAddress($email, 'xxx');
//Set the subject line
$mail->Subject = '计算机1706作业系统密码重置';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
//Replace the plain text body with one created manually
$mail->isHTML(true);                                  // Set email format to HTML
$mail->Body    = '请点击以下链接进行密码重置，如无法点击请复制到浏览器打开。<br / ><a href="http://1706.musiiot.top/resetpwd.php?user='.$user.'&yzm='.md5($captch_code).'">http://127.0.0.1/homework/resetpwd.php?user='.$user.'&yzm='.md5($captch_code).'</a>';
$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');
//send the message, check for errors

$res=mysql_query("select * from forgetpwd where username='".$user."' and isuse = 'false' order by starttime desc limit 1;");
$row1=mysql_fetch_array($res);

if (strtotime(date("Y-m-d H:i:s"))-strtotime($row1['starttime'])<60){
    echo "{status:401}";
}else{
    if (!$mail->send()) {
        echo "{status:402}";
    } else {
        $result=mysql_query("INSERT INTO `forgetpwd` (`username`, `yzm`, `starttime`, `isuse`) VALUES ("."'".$user."'".", '".$captch_code."', CURRENT_TIMESTAMP, 'false')");
        echo "{status:200}";
    }
}


