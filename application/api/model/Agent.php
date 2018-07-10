<?php
namespace app\api\model;

use think\Model;
use think\Log;
use think\Cache;

class Agent extends Model
{
    /**
     * 代理登录接口
     * @param $data 请求数组
     * @return string 返回参数值类型为json
     */
    public function login($data)
    {
        Log::info('调用登录接口——请求开始');
        /*     //检测数据
         $response = testing(['username','password','captcha']);
         $response = json_decode($response);
         if ($response->result_code != 200) {
         return $response;
         } */
        /*     //校验验证码
         if(!captcha_check($data['captcha'],'login')){
         //验证失败
         return return_json(2,'验证码输入错误');
         }; */
        if(!array_key_exists('account',$data))
        {
            return  return_json(2,'代理账号不能为空');
        }
        if(!array_key_exists('password',$data))
        {
            return  return_json(2,'代理密码不能为空');
        }
        $find['account'] = $data['account'];
        $find['password'] = md5($data['password']);
        $find['pid'] = array('neq',0);
    
        //查询数据
        $response = $this->where($find)->field('id,pid,account,status,card_num,token')->find();
         
        if(!$response) {
            return return_json(2,'账号或者密码有误,请重试');
        }
        if($response['pid']===0)
        {
            return return_json(2,'账号或者密码有误,请重试');
        }else{
            $pidname = $this->where(['id'=>$response['pid']])->field('account')->find();
            $response['pname'] = $pidname['account'];
        }
    
        if ($response)
        {
            if($response['status'] == 2)
            {
                return return_json(2,'账号异常已被禁用');
            }
            Log::info('调用登录接口——查询成功');
            $insert['agent_id'] = $response['id'];
            $insert['login_time'] = time();
            $insert['operation'] = '用户登录';
            $result = db('agent_log')->insert($insert);
            if (!$result) {
                return return_json(2,'账号或者密码有误,请重试');
            }
            //缓存token
            /*       $token = md5(time().'hand_game');
             $res = $this->where($find)->update(['token'=>$token]);
             Cache::set('user_'.$response['id'],'123456',1800); */
            return return_json(1,'登录成功',$response);
        } else {
            Log::info('调用登录接口——查询失败');
            return return_json(2,'账号或者密码有误,请重试');
        }
    }
    /**
     * 创建代理
     * @param unknown $data
     * @return string
     */
    public function  agentcreated($data)
    {
        //获取id
        if(!array_key_exists('wx_name', $data))
        {
            return  return_json(2,'请输入正确的微信号');
        } else {
            $insert['wx_name'] = $data['wx_name'];
        }
        if(!array_key_exists('phone', $data))
        {
            return  return_json(2,'电话不能为空');
        } else {
            $insert['phone'] = $data['phone'];
        }
        if(!array_key_exists('rname', $data))
        {
            return  return_json(2,'真实姓名不能为空');
        } else {
            $insert['rname'] = $data['rname'];
        }
        if(!array_key_exists('pid', $data))
        {
            return  return_json(2,'推荐码不能为空');
        } else {
            $insert['pid'] = $data['pid'];
        }

        //检测看是否已经修改
        $result = $this->insert($insert);
        if(!$result){
            return  return_json(2,'申请失败');
        }
        return  return_json(1,'申请成功');

    }
    
    /**
     * 待审审核代理列表
     * @param unknown $data
     * @return string
     */
    public function checkagentlist($data)
    {
        //分页
        $where = ' where  a.status = 3 and a.pid = b.id';//注意下面计算页数的sql
        //计算总页数
        $sqlc =  "select count(id)  from hand_agent where status = 3 ";
        $count = db()->Query($sqlc);
        $totle = $count[0]["count(id)"];//总数
        if(!array_key_exists('limit_page', $data))
        {
            $limit = 15;
        } else {
            $limit = $data['limit_page'];
        }
        //$limit = 15;//每页条数
        $pageNum = ceil ( $totle/$limit); //总页数
        //当前页
        if(array_key_exists('npage', $data))
        {
            $npage = $data['npage'];
        }else{
            $npage = 1;
        }
        $start = ($npage-1)*$limit;
        $page = [];
        $page['npage'] = $npage;//当前页
        $page['totle'] = $totle;//总条数
        $page['tpage'] = $pageNum;//总页数
        //开始数$start $limie
        $sql =  "select a.id,a.wx_name,a.rname,a.phone,a.created_at,b.account as p_account from  hand_agent as a , hand_agent b ".$where."  limit ".$start.",".$limit;
    
        $res = db()->Query($sql);
        if(!$res)
        {
            return return_json(1,'暂无信息 ');
        }
        //返回结果
        return return_json(1,'平台发卡记录',$res,$page);
    }
    /**
     * 完成平台对代理的审核
     * @param unknown $data
     * @return string
     */
    public function  checkagent($data)
    {
        //获取id
        if(!array_key_exists('id', $data))
        {
            return  return_json(2,'该用新增代理异常');
        } else {
            $where['id'] = $data['id'];
        }
        //获取状态 状态1为审核通过 status修改为1  状态1为审核不通过 status修改为3
        if(!array_key_exists('status', $data))
        {
            return  return_json(2,'新增代理状态异常');
        } else {
            if($data['status'] == 1 ) {
                $update['status'] = 1;
            } else {
                $update['status'] = 4;
            }
        }
        //获取拒绝原因
        if($update['status'] == 4){
            if(!array_key_exists('id', $data))
            {
                return  return_json(2,'该用新增代理异常');
            } else {
                $update['reject_cause'] =  $data['reject_cause'];
            }
        }
        //检测看是否已经修改
        $result = $this->where(['status' => 1,'id' => $where['id']])->find();
        if($result){
            return  return_json(2,'代理已审核');
        }
        //执行更新数据库
        $res = $this->where($where)->update($update);
        if($res) {
            return  return_json(1,'操作成功');
        } else {
            return  return_json(2,'操作失败');
        }
    }
/*     public function getstatus($data)
    {
        if(!array_key_exists('id', $data))
        {
            return  return_json(2,'该用新增代理异常');
        } else {
            $where['id'] = $data['id'];
        }
        $result = $this->where(['id' => $where['id']])->find();
        return return_json(1,'平台发卡记录',$result);
    } */
    
	/**************************************************************************之前的************************************************************************************/


	public function agentlist($data)
	{
		//分页
		$where = ' where  a.status = 1 and a.pid = b.id';//注意下面计算页数的sql
		//计算总页数
		$sqlc =  "select count(id)  from hand_agent where status = 1 ";
		$count = db()->Query($sqlc);
		$totle = $count[0]["count(id)"];//总数
		$limit = 15;//每页条数
		$pageNum = ceil ( $totle/$limit); //总页数
		//当前页
		if(array_key_exists('npage', $data))
		{
			$npage = $data['npage'];
		}else{
			$npage = 1;
		}
		$start = ($npage-1)*$limit;
		$page = [];
		$page['npage'] = $npage;//当前页
		$page['totle'] = $totle;//总条数
		$page['tpage'] = $pageNum;//总页数
		//开始数$start $limie
		$sql =  "select a.id,a.account,a.rname,a.pid,a.phone,a.card_num,a.child_num,a.rebate,a.created_at,b.account as p_account from  hand_agent as a , hand_agent b ".$where."  limit ".$start.",".$limit;
		//获取信息列表
		$res = db()->Query($sql);
		if(!$res)
		{
			return return_json(1,'暂无信息 ');
		}
		dump($res);
		//获取列表相关信息
		foreach($res as $key => $val) {
			$where1['agent_id'] = $val['id'];
			$res = db('agent_card')->where($where1)->order('created_at desc')->limit(1)->find();//最后进卡
			$res = db('agent_card')->where($where1)->order('created_at desc')->limit(1)->find();//最后发卡
			$res = db('agent_card')->where($where1)->order('created_at desc')->limit(1)->find();//最后登陆
		}
		//返回结果
		return return_json(1,'平台发卡记录',$res,$page);	
	}
	/****************************************************************************之前的接口************************************************************************************/
    /**
     * 新增代理
     *  
     */
    public function created_agent($data)
    {
        //系统日志
        return 'ok';
        //字段验证
        if(!array_key_exists('account',$data))
        {
            return  return_json(2,'新增代理账号不能为空');
        }
        if(!array_key_exists('phone',$data))
        {
            return  return_json(2,'新增代理手机号不能为空');
        }else{
            $mobile = is_mobile($data['phone']);
            if(!$mobile){
                return return_json(2,'请输入正确手机号');
            }
        }
        if(!array_key_exists('wx_name',$data))
        {
            return  return_json(2,'新增代理微信号不能为空');
        }
        if(!array_key_exists('rname',$data))
        {
            return  return_json(2,'新增代理真实姓名不能为空');
        }
        if(!array_key_exists('password',$data))
        {
            return  return_json(2,'新增代理密码不能为空');
        }
        if(!array_key_exists('pid',$data))
        {
            return  return_json(2,'新增代理未定义');
        }
        
        //参数验证       
        $insert['account'] = $data['account'];

        //防止重复
        $find = $this->where($insert)->find();
        if($find)
        {
           return return_json(2,'账号已存在');
        }
        $insert['password']= md5($data['password']);
        $insert['phone'] = $data['phone'];
        $insert['wx_name'] = $data['wx_name'];
        $insert['rname'] = $data['rname'];
        //执行添加
        $insert['pid']     = $data['pid'];
        $insert['created_at'] = time();
        $res = $this->insert($insert);
        if(!$res)
        {
           return  return_json(2,'创建失败');
        }else{
            unset($insert['password']);
            $res = $this->where($insert)->find();
           return return_json(1,'创建成功',$res);
        }
    }
    /**
     * 代理下代理列表 param $type = 1  平台下的代理列表
     * @param unknown $data
     * @return string
     */
    public function agentCdList($data)
    {
        if(!array_key_exists('pid', $data)){
            return  return_json(2,'代理信息异常，请联系客服');
        }
        if(array_key_exists('account',$data) && $data['account'] !='')
        {
            $where = 'where  account like  "%'.$data["account"].'%"  and  pid = '.$data['pid'];
        }else{
            $where = 'where pid ='.$data['pid'];
        }
       
        //分页
        //计算总页数
        $sqlc =  "select count(id)  from hand_agent ".$where;  
        $count = db()->Query($sqlc);      
        $totle = $count[0]["count(id)"];//总数
        $limit = 15;//每页条数
        $pageNum = ceil ( $totle/$limit); //总页数
        //当前页
        if(array_key_exists('npage', $data))
        {
            $npage = $data['npage'];
        }else{
            $npage = 1;
        }
        $start = ($npage-1)*$limit;
        $page = [];
        $page['npage'] = $npage;//当前页
        $page['totle'] = $totle;//总条数
        $page['tpage'] = $pageNum;//总页数
        //开始数$start $limie
        $sql =  "select * from  hand_agent ".$where."  limit ".$start.",".$limit;
  
        $res = db()->Query($sql);
        if(!$res)
        {
            return return_json(1,'暂无信息 ');
        }
        //返回结果
        return return_json(1,'平台发卡记录',$res,$page);
    }
    /**
     * 平台下代理列表 param $type = 1  平台下的代理列表
     * @param unknown $data
     * @return string
     */
    public function agentList1($data)
    {
        if(array_key_exists('account',$data) && $data['account'] !='')
        {
            $where = 'where  account like  "%'.$data["account"].'%" and where pid > 0';
        }else{
            $where = 'where pid > 0';
        }
         
        //分页
        //计算总页数
        $sqlc =  "select count(id)  from hand_agent ".$where;
    
    
        $count = db()->Query($sqlc);
        $totle = $count[0]["count(id)"];//总数
        $limit = 15;//每页条数
        $pageNum = ceil ( $totle/$limit); //总页数
        //当前页
        if(array_key_exists('npage', $data))
        {
            $npage = $data['npage'];
        }else{
            $npage = 1;
        }
        $start = ($npage-1)*$limit;
        $page = [];
        $page['npage'] = $npage;//当前页
        $page['totle'] = $totle;//总条数
        $page['tpage'] = $pageNum;//总页数
        //开始数$start $limie
        $sql =  "select * from  hand_agent ".$where." limit ".$start.",".$limit;
        $res = db()->Query($sql);
        if(!$res)
        {
            return return_json(1,'暂无信息 ');
        }
        //返回结果
        return return_json(1,'平台发卡记录',$res,$page);
    }


    /**
     * 平台房卡数
     */
    public function agent_card_num($data)
    {
        if(!array_key_exists('id',$data))
        {
            return  return_json(2,'代理账号不存在');
        }
    
        $where['id'] = $data['id'];
        $find = $this->field('card_num')->where($where)->find();
        if(!$find)
        {
            return return_json(2,'账号信息有误');
        }
        return return_json(1,'代理房卡',$find);
    }
    /**
     * 平台房卡数
     */
    public function cardInfo($data)
    {
        if(!array_key_exists('id',$data))
        {
            return  return_json(2,'代理账号不存在');
        }
    
        $where['id'] = $data['id'];
        $find = $this->field('card_num')->where($where)->find();
        if(!$find)
        {
            return return_json(2,'账号信息有误');
        }
        return return_json(1,'代理房卡',$find);
    }
    /**
     * 平台退出
     */
    public function plat_loginout($data)
    {
        if(!array_key_exists('account',$data))
        {
            return  return_json(2,'代理账号不能为空');
        }

        $where['account'] = $data['account'];
        $find = $this->where($where)->find();
        if(!$find)
        {
            return return_json(2,'账号信息有误');
        }
        return return_json(1,'成功退出');                
    }
    public  function agent_change($data)
    {
        //字段检验  id account password
        //参数检验 
        if(!array_key_exists('account',$data))
        {
            return  return_json(2,'代理账号不能为空');
        }
        if(!array_key_exists('opassword',$data))
        {
            return  return_json(2,'旧密码不能为空');
        }
        if(!array_key_exists('password',$data))
        {
            return  return_json(2,'代理密码不能为空');
        }
        if(!array_key_exists('id',$data))
        {
            return  return_json(2,'代理不存在');
        }
        $where['password'] =  md5($data['opassword']); 
        $where['account'] =  $data['account'];  
        $update['password'] = md5($data['password']);
        unset($data['password']);
        //检查账号是否存在
        $find = $this->where($where)->find();
        if($find['password']==$update['password'])
        {
            return return_json(2,'修改密码相同');
        }
        //执行修改
        $response  = $this->where(['id'=>$data['id']])->update($update);
        if(!$response)
        {
            return return_json(2,'修改失败');
        }
        //返回结果 
        $return = $this->where($where)->find();
        return return_json(1,'修改成功',$return);
        
    }
    /**
     * 平台登录接口
     * @param $data 请求数组
     * @return string 返回参数值类型为json
     */
    public function login_plat($data)
    {
        Log::info('调用登录接口——请求开始');
        /*     //检测数据
         $response = testing(['username','password','captcha']);
         $response = json_decode($response);
         if ($response->result_code != 200) {
         return $response;
         } */
        /*     //校验验证码
         if(!captcha_check($data['captcha'],'login')){
         //验证失败
         return return_json(2,'验证码输入错误');
         }; */
        //数据组装
        if(!array_key_exists('account',$data))
        {
            return  return_json(2,'代理账号不能为空');
        }
        if(!array_key_exists('password',$data))
        {
            return  return_json(2,'代理密码不能为空');
        }
        Log::info('调用登录接口——数据组装');
        $find['account'] = $data['account'];
        $find['password'] = md5($data['password']);
        $find['status']   = 1;
        //查询数据
        $response = $this->where($find)->field('id,pid,account,card_num,token')->find();
        if($response['pid'] !=0)
        {
            return return_json(2,'非平台账号');
        }
        if ($response) {
            Log::info('调用登录接口——查询成功');
            $insert['agent_id'] = $response['id'];
            $insert['login_time'] = time();
            $insert['operation'] = '用户登录';
            $result = db('agent_log')->insert($insert);
            if (!$result) {
                return return_json(2,'账号或者密码有误,请重试');
            }
            return return_json(1,'登录成功',$response);
        } else {
            Log::info('调用登录接口——查询失败');
            return return_json(2,'账号或者密码有误,请重试');
        }
    }
    /**
     * 代理商列表信息修改
     */
    public function agentInfoChange($data)
    {
        if(!array_key_exists('id',$data))
        {
            return  return_json(2,'代理账号不能为空');
        }
        if(!array_key_exists('rname',$data))
        {
           return  return_json(2,'代理真实姓名不能为空');
        }else{
            $updata['rname'] = $data['rname'];
        }
         if(!array_key_exists('wx_name',$data))
        {
           return  return_json(2,'代理微信号不能为空');
        }else{
            $updata['wx_name'] = $data['wx_name'];
        }
        if(!array_key_exists('phone',$data))
        {
            return  return_json(2,'代理手机号不能为空');
        }else{
            $updata['phone'] = $data['phone'];
        }
        $res = $this->where(['id'=>$data['id']])->update($updata);
        if (!$res && $res['status']!=1) {
            return return_json(2,'代理账号异常已被禁用');
        }else{
            $result = $this->where(['id'=>$data['id']])->find();
        }
        return return_json(1,'更新成功',$result);
    }
    /**
     * 代理商列表信息修改
     */
    public function agentStatus($data)
    {
        if(!array_key_exists('id',$data))
        {
            return  return_json(2,'代理账号不能为空');
        }
        if(!array_key_exists('status',$data))
        {
            return  return_json(2,'代理状态异常');
        }else{
            $updata['status'] = $data['status'];
        }
        $res = $this->where(['id'=>$data['id']])->update($updata);
        if (!$res && $res['status']!=1) {
            return return_json(2,'代理账号异常已被禁用');
        }else{
            $result = $this->where(['id'=>$data['id']])->find();
        }
        return return_json(1,'更新成功',$result);
    }    
    /**
     * 代理商列表信息修改
     */
    public function agentInfo($data)
    {
        if(!array_key_exists('id',$data))
        {
            return  return_json(2,'代理账号不能为空');
        }

        $result = $this->where(['id'=>$data['id']])->find();
        if (!$result && $result['status']!=1) {
            return return_json(2,'代理账号异常已被禁用');
        }
        return return_json(1,'更新成功',$result);
    }
    /**
     * 代理商列表信息修改
     */
    public function agentAcInfo($data)
    {
    	if(!array_key_exists('account',$data))
    	{
    		return  return_json(2,'代理账号不能为空');
    	}
    	if(!array_key_exists('id',$data))
    	{
    		return  return_json(2,'代理信息不能为空');
    	}
    	$result = $this->where(['account'=>$data['account']])->find();
    	if (!$result && $result['status']!=1) {
    		return return_json(2,'代理账号不存在');
    	}
    	if($result['pid'] != $data['id']) {
    		return return_json(2,'此代理不是您下线代理！');
    	}
    	return return_json(1,'查询成功',$result);
    }
    /**
     * 代理商列表信息修改
     */
    public function newsPassword($data)
    {
        if(!array_key_exists('id',$data))
        {
            return  return_json(2,'代理账号不能为空');
        }
        $updata['password'] = md5('123456');
        $result1 = $this->where(['id'=>$data['id']])->update($updata);
        if (!$result1 ) {
            return return_json(2,'代理账号密码已重置');
        }else{
            $result = $this->where(['id'=>$data['id']])->find();
        }
        return return_json(1,'更新成功',$result);
    }
}