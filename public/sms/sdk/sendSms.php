<?php

require_once "SignatureHelper.php";
use Aliyun\DySDKLite\SignatureHelper;

/**
 * 简单检测手机号码位数
 */
 function CheckPhone ($phone){
	if (strlen($phone) != 11)
		return false;
	return true;
}

/**
 * 发送短信
 */
function sendSms($phoneNum, $phoneVerify) {
    $params = array ();
    $accessKeyId = "LTAI5keGBIhlrMDz";
    $accessKeySecret = "qrF9jlZJfmJIqxjQFKhMr87sVsdbMh";
    $params["PhoneNumbers"] = $phoneNum;
    $params["SignName"] = "大雀";
    $params["TemplateCode"] = "SMS_138545450";
    $params['TemplateParam'] = Array (
        "code" => $phoneVerify
    );
    if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
        $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
    }

    $helper = new SignatureHelper();
    $content = $helper->request(
        $accessKeyId,
        $accessKeySecret,
        "dysmsapi.aliyuncs.com",
        array_merge($params, array(
            "RegionId" => "cn-hangzhou",
            "Action" => "SendSms",
            "Version" => "2017-05-25",
        ))
    );

    return $content;
}

// ini_set("display_errors", "on"); // 显示错误提示，仅用于测试时排查问题
// error_reporting(E_ALL); // 显示所有错误提示，仅用于测试时排查问题
// set_time_limit(0); // 防止脚本超时，仅用于测试使用，生产环境请按实际情况设置
