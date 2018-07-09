<?php
/**
 * 关于代理的基本信息控制
 * 代理的信息查询
 * 代理的信息修改
 */
namespace app\api\controller;

use app;
use think\Request;
use think\Config;

class Agentinfo
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

    /**
     * 代理登录
     * @param Request|null $request
     * @return string
     */
    public function agentLogin(Request $request = null)
    {
        //获取参数
        $data = $request->param();
        //调取添加表
        $res = $this->agent->login($data);
        return $res;
    }
    /**
     * 代理申请
     * @param Request|null $request
     * @return string
     */
    public function agentcreated(Request $request = null)
    {
        //获取参数
        $data = $request->param();
        //调取添加表
        $res = $this->agent->agentcreated($data);
        return $res;
    }
    /**
     * 购卡列表
     * @param Request|null $request
     * @return string
     */
    public function buycardlist(Request $request = null)
    {
        //获取参数
        $data = $request->param();
        //调取添加表
        $res = $this->userCard->buycardlist($data);
        return $res;
    }
    /**
     * 购卡
     * @param Request|null $request
     * @return string
     */
    public function buycard(Request $request = null)
    {
        //获取参数
        $data = $request->param();
        //调取添加表
        $res = $this->userCard->buycardlist($data);
        return $res;
    }
    /**
     * 5、发卡列表
     * @param Request|null $request
     * @return string
     */
    public function sendcardlist(Request $request = null)
    {
        //获取参数
        $data = $request->param();
        //调取添加表
        $res = $this->userCard->sendcardlist($data);
        return $res;
    }
    /**
     * 发卡
     * @param Request|null $request
     * @return string
     */
    public function sendcard(Request $request = null)
    {
        //获取参数
        $data = $request->param();
        //调取添加表
        $res = $this->userCard->sendcard($data);
        return $res;
    }

/*************之前代码******************/
/*    /**
     * 1-1 新增代理账号
     * @param Request $request
     */
    public function agentCreated1(Request $request = null)
    {
        //获取参数 
        //调取添加表
        $res = $this->agent->created_agent();        
        return $res;
    }
    
    /**
     * 1-2 代理账号信息修改
     * @param Request $request
     */
    public function agentChange(Request $request = null)
    {
        //获取参数 

        $data = $request->param();
        //调取添加表
        $res = $this->agent->agent_change($data);        
        return $res;
    }

    /**
     * 1-4 代理房卡总数
     * @param Request $request
     */
    public function agentCardNum(Request $request = null)
    {
        //获取参数
        $data = $request->param();
        //调取添加表
        $res = $this->agent->agent_card_num($data);
        return $res;
    }
    /**
     * 1-5  代理列表
     * @param Request $request
     */
    public function agentList(Request $request = null)
    {
        //获取参数
        $data = $request->param();
        //调取添加表
        $res = $this->agent->agentList($data);
        return $res;
    }
    /**
     * 1-6 代理商修改
     */
    public function agentInfoChange(Request $request = null)
    {
        //获取参数
        $data = $request->param();
        //调取添加表
        $res = $this->agent->agentInfoChange($data);
        return $res;
    }
    /**
     * 1-7 代理商状态修改
     */
    public function agentStatus(Request $request = null)
    {
        //获取参数
        $data = $request->param();
        //调取添加表
        $res = $this->agent->agentStatus($data);
        return $res;
    }
    /**
     * 1-8 代理商状态修改
     */
    public function agentInfo(Request $request = null)
    {
        //获取参数
        $data = $request->param();
        //调取添加表
        $res = $this->agent->agentInfo($data);
        return $res;
    }
    /**
     * 1-8 代理商状态修改
     */
    public function newsPassword(Request $request = null)
    {
        //获取参数
        $data = $request->param();
        //调取添加表
        $res = $this->agent->newsPassword($data);
        return $res;
    }
    /**
     * 1-8 代理账号获取代理信息
     */
    public function agentAcInfo(Request $request = null)
    {
        //获取参数
        $data = $request->param();
        //调取添加表
        $res = $this->agent->agentAcInfo($data);
        return $res;
    }
    /**
     * 1-9 代理账号获取代理信息
     */
    public function cardInfo(Request $request = null)
    {
        //获取参数
        $data = $request->param();
        //调取添加表
        $res = $this->agent->cardInfo($data);
        return $res;
    }
    
    /**
     * 2-1 代理发房卡
     * @param Request $request
     */
    public function agentSendCard(Request $request = null)
    {
        //获取参数
        $data = $request->param();
        //调取添加表
        $res = $this->userCard->send_card($data,2);
        return $res;
    }
    /**
     * 2-2 代理向平台购卡记录
     * @param Request $request
     */
    public function agentGetCard(Request $request = null)
    {
        //获取参数
        $data = $request->param();
        //调取添加表
        $res = $this->userCard->plat_send_log($data,2);
        return $res;
    }
    /**
     * 2-3 代理发卡记录
     * @param Request $request
     */
    public function agentSendLog(Request $request = null)
    {
        //获取参数
         $data = $request->param();
        //调取添加表
        $res = $this->userCard->agent_send_log($data,2);
        return $res;
    }
    /**
     * 2-4 代理单发
     * @param Request $request
     */
    public function agentOneSend(Request $request = null)
    {
    	//获取参数
    	$data = $request->param();
    	//调取添加表
    	$res = $this->userCard->agentOneSend($data);
    	return $res;
    }
    /**
     * 2-5 代理给代理发
     * @param Request $request
     */
    public function agentToAgent(Request $request = null)
    {
    	//获取参数
    	$data = $request->param();
    	//调取添加表
    	$res = $this->userCard->agentToAgent($data);
    	return $res;
    }
    /**
     * 2-5 代理给代理发记录
     * @param Request $request
     */
    public function agentOneLog(Request $request = null)
    {
    	//获取参数
    	$data = $request->param();
    	//调取添加表
    	$res = $this->userCard->agentOneLog($data);
    	return $res;
    }
    /**
     * 2-6 代理给用户单发记录
     * @param Request $request
     */
    public function agentToLog(Request $request = null)
    {
    	//获取参数
    	$data = $request->param();
    	//调取添加表
    	$res = $this->userCard->agentToLog($data);
    	return $res;
    }
    /**
     * 3-1根据id昵称
     */
    public function nickname(Request $request = null)
    {
        $data = $request->param();    
        if(!array_key_exists('account',$data))
        {
            return return_json(2,'代理信息故障');
        }
        if(array_key_exists('user_account',$data))
        {            
            $dataGame['userId'] = $data['user_account'];
            $dataGame['reqIp'] = get_client_ip();            
            $dataGame['master'] =$data['account'];
            $dataGame['time'] = time();
            $dataGame['auth'] = get_auth($dataGame);            
            $url ="http://".Config::get('web_url')."/msh/QueryNickName?userId=".$dataGame['userId']."&master=".$dataGame['master']."&reqIp=".$dataGame['reqIp']."&time=".$dataGame['time']."&auth=".$dataGame['auth'];
    
        }else{
           return return_json(2,'用户不存在');
        } 
        
         $res = game_curl($url);
         $res = json_decode($res,true);
         if($res['result'] =='OK')
        {
            $data['name'] = $res['data']['name'];
            return  return_json(1,'用户存在验证成功',$data);
        }else{
            return return_json(2,'用户验证失败');
        }
    
    }
    /* 代理下招代理 */
    /**
     * 代理新增代理
     */
    public function agentCdCreated(Request $request = null)
    {
        //获取参数
        $date = $request->param();
        //调取添加表
        $res = $this->agent->created_agent($date);
        return $res;
    }
    /**
     * 代理下代理列表
     */
    public function agentCdList(Request $request = null)
    {
        //获取参数
        $data = $request->param();
        //调取添加表
        $res = $this->agent->agentCdList($data);
        return $res;
    }
    
    
    /**
     * 验证码接口
     */

}