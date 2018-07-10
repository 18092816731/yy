<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/9
 * Time: 9:39
 */
namespace app\index\controller;
use app;
use think\Request;
class Wx  extends \think\Controller
{
  //属性
    protected  $agent;
    protected  $userCard;
    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->agent = new \app\api\model\Agent();
        $this->userCard  = new \app\api\model\AgentCard();
/*         //验证token
        if(!array_key_exists('HTTP_TOKEN',$_SERVER))
        {
            return  return_json(2,'用户token不存在或已过期');
        }
        if(!array_key_exists('HTTP_ID',$_SERVER))
        {
            return  return_json(2,'用户不存在或已过期');
        } */
        
    }

    public function getopenid(Request $request = null)
    {
       $data = $request->param();
	   //dump($data["code"]);exit;
	   $wxDate = file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid=wxf0c73cda0cc6c9c0&secret=32872c10fd21073464b4b3a63d960c86&code='.$data["code"].'&grant_type=authorization_code');
	   $wxInfo = json_decode($wxDate,'json');
	   $access_token = $wxInfo['access_token'];
	   $openid = $wxInfo['openid'];
	   $res = $this->agent->wxLogin($wxInfo);
	    
        header("Location:http://agency.daque.com/agencyAdmin/index.html#/getOpenId?openid=".$openid);
	    exit;
	   //$game_curl = game_curl('https://api.weixin.qq.com/sns/oauth2/access_token?appid=wxf0c73cda0cc6c9c0&secret=32872c10fd21073464b4b3a63d960c86&code=0017vUiI12ahP70ZGXlI1WA0jI17vUi3&grant_type=authorization_code');
	  // dump($wxDate);
	 
	   $url ='https://api.weixin.qq.com/sns/oauth2/access_token?appid=wxf0c73cda0cc6c9c0&secret=32872c10fd21073464b4b3a63d960c86&code='.$data['code'].'&grant_type=authorization_code';
	   //$this->curl_('https://api.weixin.qq.com/sns/oauth2/access_token?appid=APPID&secret=SECRET&code=CODE&grant_type=authorization_code');
	   $game_curl = game_curl($url);
	  dump($game_curl);
    }
	public function curl_($url,$data)
    {
    $ch = curl_init(); 
    /***在这里需要注意的是，要提交的数据不能是二维数组或者更高
    *例如array('name'=>serialize(array('tank','zhang')),'sex'=>1,'birth'=>'20101010')
    *例如array('name'=>array('tank','zhang'),'sex'=>1,'birth'=>'20101010')这样会报错的*/
    curl_setopt($ch, CURLOPT_URL, $url); 
    curl_setopt($ch, CURLOPT_POST, 1); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
    curl_exec($ch);  
    }

}