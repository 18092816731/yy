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
    public function index(Request $request = null)
    {
        $data = $request->param();
        echo $data['echostr'];exit;
    }

    public function getopenid(Request $request = null)
    {
       $data = $request->param();
	 
			
	   $wxDate = file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid=wxf0c73cda0cc6c9c0&secret=32872c10fd21073464b4b3a63d960c86&code='.$data["code"].'&grant_type=authorization_code');
 
	  $wxInfo = json_decode($wxDate,'json');	
   if(array_key_exists('id',$data))
            {  
                $wxInfo['pid'] = $data["id"];
            }  	  
	   $access_token = $wxInfo['access_token'];
	   $openid = $wxInfo['openid'];
	  
	   $res = $this->agent->wxLogin($wxInfo); 
	    	if(array_key_exists('id',$data))
            {
				  header("Location:http://agency.daque.com/agencyAdmin/index.html#/getOpenId?openid=".$openid."&pid=".$data["id"]);
				  exit;
            } 
			 header("Location:http://agency.daque.com/agencyAdmin/index.html#/getOpenId?openid=".$openid);
			 
        //header("Location:http://agency.daque.com/agencyAdmin/index.html#/getOpenId?openid=".$openid);
	    exit;
	   //$game_curl = game_curl('https://api.weixin.qq.com/sns/oauth2/access_token?appid=wxf0c73cda0cc6c9c0&secret=32872c10fd21073464b4b3a63d960c86&code=0017vUiI12ahP70ZGXlI1WA0jI17vUi3&grant_type=authorization_code');
	  // dump($wxDate);
	 
	   //$url ='https://api.weixin.qq.com/sns/oauth2/access_token?appid=wxf0c73cda0cc6c9c0&secret=32872c10fd21073464b4b3a63d960c86&code='.$data['code'].'&grant_type=authorization_code';
	   $this->curl_('https://api.weixin.qq.com/sns/oauth2/access_token?appid=APPID&secret=SECRET&code=CODE&grant_type=authorization_code');
	   $game_curl = game_curl($url);
	  dump($game_curl);
    }
	/**
	*惟信第三方网站
	*
	*/
	    public function get_openid(Request $request = null)
    {
        $data = $request->param();
		$code = $_GET['code'];
        $state = $_GET['state'];
        

/*根据code获取用户openid*/
$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=wxf0c73cda0cc6c9c0&secret=32872c10fd21073464b4b3a63d960c86&code=".$code."&grant_type=authorization_code";
 
$abs = file_get_contents($url);
$obj=json_decode($abs);
$access_token = $obj->access_token;
$openid = $obj->openid;
/*根据code获取用户openid end*/
 
 
/*根据用户openid获取用户基本信息*/
$abs_url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
$abs_url_data = file_get_contents($abs_url);
$obj_data=json_decode($abs_url_data);
dump($obj_data);


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