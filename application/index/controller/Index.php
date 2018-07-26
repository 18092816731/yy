<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/9
 * Time: 9:39
 */
namespace app\index\controller;
use app;
class Index
{

    public function index()
    {
		$APPID='wxf0c73cda0cc6c9c0';//公众号在微信的appid
    $REDIRECT_URI='http://test.91yelang.top/index/Wx/get_openid';//回调页面    
    // $scope='snsapi_base';
    $scope='snsapi_userinfo';//需要授权
    $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$APPID."&redirect_uri=".urlencode($REDIRECT_URI)."&response_type=code&scope=".$scope."&state=STATE#wechat_redirect";
    header("Location:".$url);

        //echo '您好，请联系管理员 18092816731';
    }
}