<?php
namespace app\api\controller;

use app;
use app\api\model\Agent;
use think\Request;


class PlatAgent
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
	 * 获取待审核列表
	 * @param Request $request
	 * @return unknown
	 */
	public function checkagentlist(Request $request = null)
	{
		
		$data = $request->param();
		$res = $this->agent->checkagentlist($data);  
		return $res;
	}
	 /**
	  *执行代理审核 
	  * @param Request $request
	  * @return unknown
	  */
	public function checkagent(Request $request = null)
	{
		$data = $request->param();
		$res = $this->agent->checkagent($data);
		return $res;
	}
	/**
	 * 代理信息列表
	 * @param Request $request
	 * @return unknown
	 */
	public function agentlist(Request $request = null)
	{
		$data = $request->param();
		$res = $this->agent->agentlist($data);
		return $res;
	}
	
}