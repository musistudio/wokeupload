<?php
include "consql.php";
header("Content-type:text/html;charset=utf-8");
session_start();
$result=mysql_query("select * from student_info where s_number=".$_SESSION['id']);
$row=mysql_fetch_array($result);
$username=$row["name"];
$dr=null;
$class=null;
if(isset($_POST["type"])){
    $type=$_POST["type"];
    if($type=="c#"){
        $dr="c#/";
        $class="csharp";
    }else if ($type=="ps"){
        $dr="ps/";
        $class="Photoshop";
    }else if ($type=="zy"){
        $dr="zy/";
        $class="zy";
    }else if($type=="wp"){
        $dr="wp/";
        $class="webpage";
    }else{
        echo "{status:404}";
        exit();
    }
}else{
    echo "{status:404}";
    exit();
}


// 允许上传文件的后缀
$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);     // 获取文件后缀名
if ($_FILES["file"]["size"] < 1024000000)   // 限制文件大小
{
    if ($_FILES["file"]["error"] > 0)
    {
//        echo "错误：: " . $_FILES["file"]["file"] . "<br>";
    }
    else
    {
//        echo "上传文件名: " . $_FILES["file"]["name"] . "<br>";
//        echo "文件类型: " . $_FILES["file"]["type"] . "<br>";
//        echo "文件大小: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
//        echo "文件临时存储的位置: " . $_FILES["file"]["tmp_name"] . "<br>";

        // 判断当期目录下的 upload 目录是否存在该文件
        // 如果没有 upload 目录，你需要创建它，upload 目录权限为 777
        if (file_exists("upload/" . $_FILES["file"]["name"]))
        {
//            echo $_FILES["file"]["name"] . " 文件已经存在。 ";
        }
        else
        {
            // 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
            move_uploaded_file($_FILES["file"]["tmp_name"], "upload/".$dr . $_SESSION['id'].$username.".".$extension);
            $sqlcmd = "UPDATE student_info SET ".$class." ='1' WHERE s_number ='".$_SESSION['id']."'";
            $result=mysql_query($sqlcmd);
            echo "{status:200}";
            //echo "文件存储在: " . "upload/".$dr . $_SESSION['id'].$username.".".$extension."<br />文件上传成功,将于3秒后跳转";
//            sleep(3);
//            header("location:user.php");
        }
    }
}
else
{
    echo "非法的文件格式";
}
?>

