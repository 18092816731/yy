<?php
/**
 * 游戏信息的基本统计
 * 和游戏基本信息相关
 */
namespace app\api\controller;
use think\Request;

class Platinfo
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
    }
    /**
     * 1-1 新增平台|游戏账号
     * @param Request $request
     */
    public function platCreated(Request $request = null)
    {
        //获取参数

        $date = $request->param();
        //调取添加表
        $res = $this->agent->created_agent($date);
        return $res;
    }
    public function loginout(Request $request = null)
    {
        $date = $request->param();
        //调取添加表
        $res = $this->agent->plat_loginout($date);
        return $res;
    }
    /**
     * 1-2 平台|游戏账号信息修改
     * @param Request $request
     
    public function plat_change(Request $request = null)
    {
        //获取参数
        //调取添加表
        $res = $this->agent->created_agent();
        return $res;
    }*/
    
    /**
     * 1-3 平台|游戏登录
     * @param Request $request
     */
    public function platlogin(Request $request = null)
    {
        //获取参数
        $data = $request->param();
        //调取添加表
        $res = $this->agent->login_plat($data,1);
        return $res;
    }
    /**
     * 2-1 平台|游戏发房卡
     * @param Request $request
     */
    public function platSendCard(Request $request = null)
    {
        //获取参数
        $data = $request->param();
        //调取添加表
        $res = $this->userCard->send_card($data,1);
        return $res;
    }
    /**
     * 2-2 代理发卡记录
     * @param Request $request
     */
    public function agentSendLog(Request $request = null)
    {
        //获取参数
        $data = $request->param();
        //调取添加表
        $res = $this->userCard->agent_send_log($data,1);
        return $res;
    }
    /**
     * 2-3 平台|游戏发卡记录
     * @param Request $request
     */
    public function platSendLog(Request $request = null)
    {
        //获取参数
        $data = $request->param();
        //调取添加表
        $res = $this->userCard->plat_send_log($data,1);
        return $res;
    }
    /**
     * 3-1 平台|游戏数据查询
     * @param Request $request
     */
    public function platData(Request $request = null)
    {
        //获取参数
        //调取添加表
        $res = $this->agent->created_agent();
        return $res;
    }
    public function login()
    {
        $url = 'www.handgame.com/api/platinfo/platLogin';
        //$url = $this->testUrl.'api/platform/plat_login';
        $data['account'] = '666666';
        $data['password']  = '123456';
        $res = $this->curl_($url, $data);
        dump($res);
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