<?php
/**
 * 游戏信息的基本统计
 * 和游戏基本信息相关
 */
namespace app\api\controller;
use think\Request;
use app\api\model\Agent;

class Platinfo
{
    //属性
    protected  $userCard;
    protected  $Platlog;
    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->Platlog = new \app\api\model\Platlog();
        $this->userCard  = new \app\api\model\AgentCard();
    }
    /**
     * 平台等录
     * @param Request|null $request
     * @return string
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
     * 平台退出
     * @param Request|null $request
     * @return string
     */
    public function loginout(Request $request = null)
    {
        $date = $request->param();
        //调取添加表
        $res = $this->agent->plat_loginout($date);
        return $res;
    }
    /*****************************购卡设计**************************************/
    /**
     * 购卡设置列表
     * @param Request|null $request
     * @return string
     */
    public function buycardlist(Request $request = null)
    {
        $date = $request->param();
        //调取添加表
        $res = $this->userCard->buycardlist($date);
        return $res;
    }
    /**
     * 购卡设置
     * @param Request|null $request
     * @return string
     */
    public function buycardset(Request $request = null)
    {
        $date = $request->param();
        //调取添加表
        $res = $this->userCard ->buycardset($date);
        return $res;
    }
    /**
     * 购卡设置编辑
     * @param Request|null $request
     * @return string
     */
    public function buycardedit(Request $request = null)
    {
        $date = $request->param();
        //调取添加表
        $res = $this->userCard ->buycardedit($date);
        return $res;
    }
    /**
     * 购卡设置删除
     * @param Request|null $request
     * @return string
     */
    public function buycarddel(Request $request = null)
    {
        $date = $request->param();
        //调取添加表
        $res = $this->userCard ->buycarddel($date);
        return $res;
    }
    /*****************************发卡设计**************************************/
    /**
     * 购卡设置列表
     * @param Request|null $request
     * @return string
     */
    public function sendcardlist(Request $request = null)
    {
        $date = $request->param();
        //调取添加表
        $res = $this->userCard->sendcardlist($date);
        return $res;
    }
    /**
     * 购卡设置
     * @param Request|null $request
     * @return string
     */
    public function sendcardset(Request $request = null)
    {
        $date = $request->param();
        //调取添加表
        $res = $this->userCard ->sendcardset($date);
        return $res;
    }
    /**
     * 购卡设置编辑
     * @param Request|null $request
     * @return string
     */
    public function sendcardedit(Request $request = null)
    {
        $date = $request->param();
        //调取添加表
        $res = $this->userCard ->sendcardedit($date);
        return $res;
    }
    /**
     * 购卡设置删除
     * @param Request|null $request
     * @return string
     */
    public function sendcarddel(Request $request = null)
    {
        $date = $request->param();
        //调取添加表
        $res = $this->userCard ->sendcarddel($date);
        return $res;
    }
    /**
     * 返利设置
     * @param Request|null $request
     * @return string
     */
    public function refee(Request $request = null)
    {
        $date = $request->param();
        //调取添加表
        $res = $this->agent->refee();
        return $res;
    }
    /**
     * 返利设置
     * @param Request|null $request
     * @return string
     */
    public function refeeset(Request $request = null)
    {
        $date = $request->param();
        //调取添加表
        $res = $this->agent->refeeset($date);
        return $res;
    }
    /**
     *列表
     * @param Request|null $request
     * @return string
     */
    public function returnfeelist(Request $request = null)
    {
        $date = $request->param();
        //调取添加表
        $res = $this->agent->returnfeelist($date);
        return $res;
    }
	    /**
     * 提现shenqing
     * @param Request|null $request
     * @return string
     */
    public function platreturn(Request $request = null)
    {
        $date = $request->param();
        //调取添加表
        $res = $this->agent->platreturn($date);
        return $res;
    }
	    /**
     * 提现审核列表
     * @param Request|null $request
     * @return string
     */
    public function platreturnfee(Request $request = null)
    {
        $date = $request->param();
        //调取添加表
        $res = $this->agent->feelist($date);
        return $res;
    }
    /**
     * 提现审核
     * @param Request|null $request
     * @return string
     */
    public function returnfee(Request $request = null)
    {
        $date = $request->param();
        //调取添加表
        $res = $this->agent->returnfee($date);
        return $res;
    }
    /*****************************日志**************************************/
    /***
     * 进卡日志
     * @param Request|null $request
     * @return string
     */
    public function buycardlogs(request $request = null)
    {
        $date = $request->param();
        //调取添加表
        $res = $this->Platlog->buycardlogs($date);
        return $res;
    }

    /**
     * 发卡日志
     * @param Request|null $request
     * @return string
     */
    public function sendcardlogs(request $request = null)
    {
        $date = $request->param();
        //调取添加表
        $res = $this->Platlog->sendcardlogs($date);
        return $res;
    }
    /**
     * 返利日志
     * @param Request|null $request
     * @return string
     */
    public function returnfeelogs(request $request = null)
    {
        $date = $request->param();
        //调取添加表
        $res = $this->Platlog->returnfeelogs($date);
        return $res;
    }
    /**
 * 返利日志
 * @param Request|null $request
 * @return string
 */
    public function putfeelogs(request $request = null)
    {
        $date = $request->param();
        //调取添加表
        $res = $this->Platlog->putfeelogs($date);
        return $res;
    }
    /**
     * 补卡日志
     * @param Request|null $request
     * @return string
     */
    public function havecardlog(request $request = null)
    {
        $date = $request->param();
        //调取添加表
        $res = $this->Platlog->havecardlog($date);
        return $res;
    }
    public function agentinfo(request $request = null)
    {
        $date = $request->param();
        //调取添加表
        $res = $this->Platlog->agentinfo($date);
        return $res;
    }


/*************之前***************/

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
        $url = 'http://test.91yelang.top/api/platagent/checkagentlist';
        //$url = $this->testUrl.'api/platform/plat_login';
        $data['account'] = 'xamsh001';
        $data['password']  = 'xamsh001';
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