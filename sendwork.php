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

$email = "";
$class = $_GET['class'];
$teachers = array("476909647@qq.com","12204051@qq.com","1822979@qq.com");//王肖，刘志刚，葛晓萍
switch ($class){
    case "王肖":
        $email = $teachers[0];
        break;
    case "刘志刚":
        $email = $teachers[1];
        break;
    case "葛晓萍":
        $email = $teachers[2];
        break;
    default:
        $email = "779956774@qq.com";
        break;
}



$file = $_GET['file'];
$email="779956774@qq.com";
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
$mail->Subject = '计算机1706'.$class.'作业';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
//Replace the plain text body with one created manually
$mail->isHTML(true);                                  // Set email format to HTML
$mail->Body    = '计算机1706'.$class.'作业';
$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
$mail->addAttachment($file);
//send the message, check for errors

if (!$mail->send()) {
    echo '{status:100}';
} else {
    echo '{status:200}';
}