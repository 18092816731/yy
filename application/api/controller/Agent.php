<?php
namespace app\api\controller;

use app;
use think\Request;
use think\Config;

class Agent
{
    //属性
    protected  $agent;
    protected  $userCard;
    /**
     * 构造函数
     */
    public function index()
    {
        $this->agent = new \app\api\model\Agent();
        $this->userCard  = new \app\api\model\AgentCard();
        dump($this->agent);
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

}