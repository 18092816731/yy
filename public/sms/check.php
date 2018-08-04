<?php
header("Content-Type:text/html; charset=utf-8");
require "./database.php";
// TODO:接受参数 phone 
// 接受参数 verify
if($_SERVER['REQUEST_METHOD']=="POST"){
    $phoneNum = $_POST['phone'];
    $phoneVerify = $_POST['code'];
}else if($_SERVER['REQUEST_METHOD']=="GET"){
    $phoneNum = $_GET['phone'];
    $phoneVerify = $_GET['code'];
}
if(!$phoneNum or $phoneNum=='')
{
    die('电话号码不能为空');
}
if(!$phoneVerify or $phoneVerify=='')
{
    die('验证码不能为空');
}

// TODO:检索数据库
$sql = "select * from user_code where phone = $phoneNum and code = $phoneVerify and status = 1";
$find = mysqli_query($con,$sql);


// TODO:检测时间戳，10分钟
$findinfo=mysqli_fetch_array($find);
if(!$findinfo)
{
    die('验证码错误');
}
$nowTime = time() - $findinfo['created_at'] ;
if($nowTime >(10*60*1000))
{
    die('验证码超时');
}else{
    $sql = "update user_code set status = 2 where phone = $phoneNum and code = $phoneVerify";
    $findinfo = mysqli_query($con,$sql);
	if(!$findinfo){
		echo 'error';
	}
    echo "success";
}

// 检测成功与否
