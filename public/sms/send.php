<?php

require "sdk/sendSms.php";
require "./database.php";

// TODO:接受参数 phone


if($_SERVER['REQUEST_METHOD']=="POST"){
    $phoneNum = $_POST['phone'];
}else if($_SERVER['REQUEST_METHOD']=="GET"){
    $phoneNum = $_GET['phone'];
}
$phoneVerify = mt_rand(300000, 999999);
if(!$phoneNum)
{
    die('电话号码不能为空');
}
if (!CheckPhone($phoneNum)){
	die("请正确填写手机号！");
}

// 调用sdk
$ret = sendSms($phoneNum, $phoneVerify);

//echo $ret->Code;

// 检测成功与否
if (strcmp($ret->Code, "OK") == 0){
	// TODO: 记录数据库
	// phone, verify, date
	$time = time();
		$sql = 'INSERT INTO user_code (phone,code,created_at,status) values ("'.$phoneNum.'","'.$phoneVerify.'","'.$time.'",1)';

	
	$res = mysqli_query($con,$sql);
	if(!$res){
	    echo "Fail";
	}else{
	    echo "success";
	}
}else{
	// 返回错误情况
	echo $ret->Message;
}