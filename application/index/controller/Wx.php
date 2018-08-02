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
    protected $appid;
    protected  $appsecret;
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
      $this->appid = 'wxf0c73cda0cc6c9c0';
      $this->appsecret = '32872c10fd21073464b4b3a63d960c86';
        
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
        //dd($wxInfo);
        if(!isset($wxInfo['openid'])) {
            exit('非法登陆，请联系管理员!');
        }
       if(array_key_exists('id',$data))
        {
            $wxInfo['pid'] = $data["id"];
        }
        //获取用户信息
        $userInfo = $this->get_openid($wxInfo);
        $wxInfo['wx_name'] = $userInfo['nickname'];
        $wxInfo['img_url'] = $userInfo['headimgurl'];
	  //微信登陆
	   $res = $this->agent->wxLogin($wxInfo);
	/*   if($res == 'error') {
           header("Location:http://agency.daque.com/agencyAdmin/index.html#/imprison");
       }*/
	   if($res != 'ok'){
           header("Location:http://agency.daque.com/agencyAdmin/index.html#/imprison");
       }
        $openid = $wxInfo['openid'];
        if(array_key_exists('id',$data))
        {
            header("Location:http://agency.daque.com/agencyAdmin/index.html#/getOpenId?openid=".$openid."&pid=".$data["id"]);
            exit;
        }
         header("Location:http://agency.daque.com/agencyAdmin/index.html#/getOpenId?openid=".$openid);
	    exit;
    }
	/**
	*惟信第三方网站
	*
	*/
	    public function get_openid($data)
    {
        $access_token = $data['access_token'];
        $openid = $data['openid'];
    /*    $data = $request->param();
		$code = $_GET['code'];
        $state = $_GET['state'];*/

        //访问地址
        //https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxf0c73cda0cc6c9c0&redirect_uri=http://test.91yelang.top/index/wx/get_openid&response_type=code&scope=snsapi_userinfo&state=ssaweqeqew&connect_redirect=1#wechat_redirect

        /*根据code获取用户openid*/
/*        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=wxf0c73cda0cc6c9c0&secret=32872c10fd21073464b4b3a63d960c86&code=".$code."&grant_type=authorization_code";

        $abs = file_get_contents($url);
        $obj=json_decode($abs);
        $access_token = $obj->access_token;
        $openid = $obj->openid;*/



        /*根据用户openid获取用户基本信息*/
        $abs_url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
        $abs_url_data = file_get_contents($abs_url);
        $obj_data=json_decode($abs_url_data,'json');
        return $obj_data;



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
    //获取令牌
    public function getAccessToken(){

        //指定保存文件位置
        if(!is_dir('./access_token/')){
            mkdir(iconv("GBK","UTF-8",'./access_token/'),0777,true);
        }
        $file = './access_token/token';
        if(file_exists($file)){
            $content = file_get_contents($file);
            $cont = json_decode($content);
            if( (time()-filemtime($file)) < 100){   //当前时间-文件创建时间<token过期时间
                return $cont->access_token;
            }
        }

        $curl = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$this->appid.'&secret='.$this->appsecret;
        $abs_url_data = file_get_contents($curl);

        file_put_contents($file,$abs_url_data);
        $cont = json_decode($abs_url_data);
        return $cont->access_token;

    }
    /**
     * 通过openid拉取用户信息
     * @param  string $openid [description]
     * @return [type]         [description]
     */
    public function getUserInfo($openid='oW_EE1vjoSNtVoEMGY6KbXBl7IT4')
    {
        if (!$openid) return false;
        $access_token = $this->getAccessToken();
        $urlStr = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token=12_JvYjXaZbrBP819_ZoAtzuqiLgWZa9DPlCD5XQcWUZcieoZVtLa6q2M10IIF-PCH3IZEDZ3ocMN6ZA5Mhjo4_0dycmeocQm0nWg-PVw8RsLhL7SXPNlJiWbgf3nwVNZiACADVH&openid=oW_EE1m9TymxIyrXpjgL97Dsfu0M&lang=zh_CN';
        $res = file_get_contents($urlStr);
        dd($res);
        $url = sprintf($urlStr, $access_token, $openid);
        $result = json_decode($this->_request($url), true);
        return $result;
    }
    //设置网络请求配置
    public function _request($curl,$https=true,$method='GET',$data=null){
        // 创建一个新cURL资源
        $ch = curl_init();

        // 设置URL和相应的选项
        curl_setopt($ch, CURLOPT_URL, $curl);    //要访问的网站
        curl_setopt($ch, CURLOPT_HEADER, false);    //启用时会将头文件的信息作为数据流输出。
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  //将curl_exec()获取的信息以字符串返回，而不是直接输出。

        if($https){
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  //FALSE 禁止 cURL 验证对等证书（peer's certificate）。
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);  //验证主机
        }
        if($method == 'POST'){
            curl_setopt($ch, CURLOPT_POST, true);  //发送 POST 请求
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  //全部数据使用HTTP协议中的 "POST" 操作来发送。
        }


        // 抓取URL并把它传递给浏览器
        $content = curl_exec($ch);
        if ($content  === false) {
            return "网络请求出错: " . curl_error($ch);
            exit();
        }
        //关闭cURL资源，并且释放系统资源
        curl_close($ch);

        return $content;
    }



}