<?php
namespace app\api\model;

use think\Model;
use think\Log;
use think\Db;
use think\db\Query;
use think\Config;

class Platlog extends Model
{
    /***************************数据*******************************************/

    /***************************日志*******************************************/
    /**
     * 平台代理购卡日志
     * @param $data
     * @return string
     */
    public function buycardlogs($data)
    {
        //获取查询sql
        $where = 'where  a.plat_id = b.id';
        if(array_key_exists('account', $data)&& $data['account'] !=  '')
        {
            $agentInfo = db('agent')->where(['account'=>$data['account']])->find();
            if(!$agentInfo)
            {
                return return_json(2,'暂无代理信息 ');
            }
            $where .= ' and a.agent_account = '.$data['account'] ;
        }

        if(array_key_exists('start_time', $data) && !array_key_exists('end_time', $data) && $data['start_time'] !='' && $data['end_time'] !='')
        {
            $where .= ' and a.created_at >= '.$data['start_time'];
        }
        if(!array_key_exists('start_time', $data) && array_key_exists('end_time', $data) && $data['start_time'] !='')
        {
            $where .= ' and a.created_at <= '.$data['end_time'];
        }
        if(array_key_exists('start_time', $data) && array_key_exists('end_time', $data)&& $data['end_time'] !='')
        {
            $where .= ' and a.created_at >= '.$data['start_time'].' and a.created_at <= '.$data['end_time'];
        }

        //分页
        //计算总页数

        $sqlc =  "select  count(a.plat_id)  from hand_plat_card as a,hand_agent as b   ".$where;

        $count = db()->Query($sqlc);
        $totle = $count[0]["count(a.plat_id)"];//总数
        $limit = 30;//每页条数
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

        $sql =  "select * from (select a.fee_num,a.plat_id,a.card_num,b.wx_name,a.created_at,a.agent_account,b.account  as  agent_name from hand_plat_card as a,hand_agent as b ".$where." order by a.created_at desc) agentinfo limit ".$start.",".$limit;


        $res = db()->Query($sql);

        //判断是否为空
        if(!$res)
        {
            return return_json(1,'暂无信息 ');
        }
        //返回结果
        return return_json(1,'平台发卡记录',$res,$page);
    }

    /**
     * 发卡日志
     * @param $data
     * @return string
     */
    public function sendcardlogs($data)
    {

        $where = ' where a.agent_id  = b.id ';
        if(array_key_exists('account', $data)&& $data['account'] !=  '' )
        {
            $agentInfo = db('agent')->where(['account'=>$data['account']])->find();
            if(!$agentInfo)
            {
                return return_json(2,'暂无代理信息 ');
            }
            $where .= ' and a.agent_id = '.$agentInfo['id'] ;
        }
        if(array_key_exists('start_time', $data) && !array_key_exists('end_time', $data) && $data['start_time'] !='' && $data['end_time'] !='')
        {
            $where .= ' and a.created_at >= '.$data['start_time'];
        }
        if(!array_key_exists('start_time', $data) && array_key_exists('end_time', $data) && $data['start_time'] !='')
        {
            $where .= ' and a.created_at <= '.$data['end_time'];
        }
        if(array_key_exists('start_time', $data) && array_key_exists('end_time', $data)&& $data['end_time'] !='')
        {
            $where .= ' and a.created_at >= '.$data['start_time'].' and a.created_at <= '.$data['end_time'];
        }
        //分页
        //计算总页数

        $sqlc =  "select count(a.agent_id)  from hand_agent_card as a,hand_agent as b  ".$where;
        $count = db()->Query($sqlc);

        $totle = $count[0]["count(a.agent_id)"];//总数
        $limit = 30;//每页条数
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

        $sql =  "select * from (select a.agent_id,a.card_num,a.created_at,a.user_account,a.wx_name,b.account  as  agent_name from hand_agent_card as a,hand_agent as b ".$where." order by a.created_at desc) agentinfo limit ".$start.",".$limit;

        $res = db()->Query($sql);
        //判断是否为空
        if(!$res)
        {
            return return_json(1,'暂无信息 ');
        }
        //返回结果
        return return_json(1,'平台发卡记录',$res,$page);
    }

    /**
     * 返利日志
     * @param $data
     * @return string
     */
    public function returnfeelogs($data)
    {
        $where = 'where id > 0';
        if(array_key_exists('account', $data) && $data['account'] !=  '')
        {
            $agentInfo = db('agent')->where(['account'=>$data['account']])->find();
            if(!$agentInfo)
            {
                return return_json(2,'暂无代理信息 ');
            }
            $where .= ' and agent_id = '.$agentInfo['id'] ;
        }
        if(array_key_exists('start_time', $data) && !array_key_exists('end_time', $data) && $data['start_time'] !='' && $data['end_time'] !='')
        {
            $where .= ' and created_at >= '.$data['start_time'];
        }
        if(!array_key_exists('start_time', $data) && array_key_exists('end_time', $data) && $data['start_time'] !='')
        {
            $where .= ' and created_at <= '.$data['end_time'];
        }
        if(array_key_exists('start_time', $data) && array_key_exists('end_time', $data)&& $data['end_time'] !='')
        {
            $where .= ' and created_at >= '.$data['start_time'].' and created_at <= '.$data['end_time'];
        }
        //分页
        //计算总页数

        $sqlc =  "select count(agent_id)  from hand_return_fee_log   ".$where;
        $count = db()->Query($sqlc);

        $totle = $count[0]["count(agent_id)"];//总数
        $limit = 30;//每页条数
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

        $sql =  "select * from (select agent_id,totel_fee,fee_num,created_at,pname,pid from hand_return_fee_log ".$where." order by created_at desc) agentinfo limit ".$start.",".$limit;

        $res = db()->Query($sql);
        //判断是否为空
        if(!$res)
        {
            return return_json(1,'暂无信息 ');
        }
        //返回结果
        return return_json(1,'平台发卡记录',$res,$page);
    }

    /**
     * 提现日志
     * @param $data
     * @return string
     */
    public function putfeelogs($data)
    {
        $where = 'where id > 0';
        if(array_key_exists('account', $data)&& $data['account'] !=  '' )
        {
            $agentInfo = db('agent')->where(['account'=>$data['account']])->find();
            if(!$agentInfo)
            {
                return return_json(2,'暂无代理信息 ');
            }
            $where .= ' and agent_id = '.$agentInfo['id'] ;
        }
        if(array_key_exists('start_time', $data) && !array_key_exists('end_time', $data) && $data['start_time'] !='' && $data['end_time'] !='')
        {
            $where .= ' and created_at >= '.$data['start_time'];
        }
        if(!array_key_exists('start_time', $data) && array_key_exists('end_time', $data) && $data['start_time'] !='')
        {
            $where .= ' and created_at <= '.$data['end_time'];
        }
        if(array_key_exists('start_time', $data) && array_key_exists('end_time', $data)&& $data['end_time'] !='')
        {
            $where .= ' and created_at >= '.$data['start_time'].' and created_at <= '.$data['end_time'];
        }
        //分页
        //计算总页数

        $sqlc =  "select count(agent_id)  from hand_return_fee   ".$where;
        $count = db()->Query($sqlc);

        $totle = $count[0]["count(agent_id)"];//总数
        $limit = 30;//每页条数
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

        $sql =  "select * from (select fee_num,plat_id,status,cause,created_at,get_account,pay_type from  hand_return_fee ".$where." order by created_at desc) agentinfo limit ".$start.",".$limit;

        $res = db()->Query($sql);
        //判断是否为空
        if(!$res)
        {
            return return_json(1,'暂无信息 ');
        }
        //返回结果
        return return_json(1,'平台发卡记录',$res,$page);
    }

    /**
     * 补卡记录
     * @param $data
     * @return string
     */
    public function havecardlog($data)
    {
        //获取查询sql
        $where = 'where  a.plat_id = b.id and a.status = 2 ';
        if(array_key_exists('account', $data)&& $data['account'] !=  '' )
        {
            $agentInfo = db('agent')->where(['account'=>$data['account']])->find();
            if(!$agentInfo)
            {
                return return_json(2,'暂无代理信息 ');
            }
            $where .= ' and a.agent_account = '.$data['account'] ;
        }

        if(array_key_exists('start_time', $data) && !array_key_exists('end_time', $data) && $data['start_time'] !='' && $data['end_time'] !='')
        {
            $where .= ' and a.created_at >= '.$data['start_time'];
        }
        if(!array_key_exists('start_time', $data) && array_key_exists('end_time', $data) && $data['start_time'] !='')
        {
            $where .= ' and a.created_at <= '.$data['end_time'];
        }
        if(array_key_exists('start_time', $data) && array_key_exists('end_time', $data)&& $data['end_time'] !='')
        {
            $where .= ' and a.created_at >= '.$data['start_time'].' and a.created_at <= '.$data['end_time'];
        }

        //分页
        //计算总页数

        $sqlc =  "select  count(a.plat_id)  from hand_plat_card as a,hand_agent as b   ".$where;

        $count = db()->Query($sqlc);
        $totle = $count[0]["count(a.plat_id)"];//总数
        $limit = 30;//每页条数
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

        $sql =  "select * from (select a.fee_num,a.plat_id,a.card_num,b.wx_name,a.created_at,a.agent_account,b.account  as  agent_name from hand_plat_card as a,hand_agent as b ".$where." order by a.created_at desc) agentinfo limit ".$start.",".$limit;


        $res = db()->Query($sql);

        //判断是否为空
        if(!$res)
        {
            return return_json(1,'暂无信息 ');
        }
        //返回结果
        return return_json(1,'平台发卡记录',$res,$page);
    }
    public function agentinfo($data)
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
        foreach($res as $key => $vel) {
            $ress = db('agent_card')->where(['agent_id'=>$vel['id']])->order('created_at desc')->limit(1)->select();
            if(!$ress) {
                $res[$key]['last_send_card'] = '';
            }else{
                $res[$key]['last_send_card'] = $ress[0]['created_at'];
            }
        }
        if(!$res)
        {
            return return_json(1,'暂无信息 ');
        }
        //返回结果
        return return_json(1,'平台发卡记录',$res,$page);
    }


    /*******************待删除**********************************************/
    /*******************购卡设置********************************/
    /**
     * 购卡设置列表
     * @param $data
     * @return string
     */
    public function buycardlist($data)
    {
        //分页

        //计算总页数
        $sqlc =  "select count(id)  from hand_buy_card_set  ";
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
        $response =  db('buy_card_set')->select();
        if(!$response)
        {
            return return_json(2,'操作失败',[],[]);
        }
        return return_json(1,'操作成功',$response,$page);
    }
    //曾
    public function buycardset($data)
    {
        //编辑
        if(array_key_exists('id',$data))
        {
           if(array_key_exists('card_num',$data))
           {
               $insert['card_num'] = $data['card_num'];
           }
           if(array_key_exists('fee_num',$data))
           {
               $insert['fee_num'] = $data['fee_num'];
           }
           $response =  db('buy_card_set')->where(['id'=>$data['id']])->update($insert);
           
           if(!$response)
           {
               return return_json(2,'操作失败',[],[]);
           }
           return return_json(1,'操作成功',$response);
        }   
       //新增
        //字段验证
        if(!array_key_exists('card_num',$data))
        {
            return  return_json(2,'房卡数不能为空');
        } else {
            $insert['card_num'] = $data['card_num'];
        }
        if(!array_key_exists('fee_num',$data))
        {
            return  return_json(2,'金额不能为空');
        } else {
            $insert['fee_num'] = $data['fee_num'];
        }

        $insert['created_at'] = time();
        $response =  db('buy_card_set')->insert($insert);

        if(!$response)
        {
            return return_json(2,'操作失败',[],[]);
        }
        return return_json(1,'操作成功',$response);
    }
    //改
    public function buycardedit($data)
    {
        //字段验证edit
        if(!array_key_exists('id',$data))
        {
            return  return_json(2,'参数异常');
        }
        if(array_key_exists('card_num',$data))
        {
            $insert['card_num'] = $data['card_num'];
        }
        if(array_key_exists('fee_num',$data))
        {
            $insert['fee_num'] = $data['fee_num'];
        }
        $response =  db('buy_card_set')->where(['id'=>$data['id']])->update($insert);

        if(!$response)
        {
            return return_json(2,'操作失败',[],[]);
        }
        return return_json(1,'操作成功',$response);
    }

    //删
    public function buycarddel($data)
    {
        //字段验证edit
        if(!array_key_exists('id',$data))
        {
            return  return_json(2,'参数异常');
        }
        $response =  db('buy_card_set')->where(['id'=>$data['id']])->delete();

        if(!$response)
        {
            return return_json(2,'操作失败',[],[]);
        }
        return return_json(1,'操作成功',$response);
    }
    /*******************发卡设置********************************/
    /**
     * 购卡设置列表
     * @param $data
     * @return string
     */
    public function sendcardlist($data)
    {
        //分页

        //计算总页数
        $sqlc =  "select count(id)  from hand_send_card_set  ";
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
        $response =  db('send_card_set')->select();
        if(!$response)
        {
            return return_json(2,'操作失败',[],[]);
        }
        return return_json(1,'操作成功',$response,$page);
    }
    //曾
    public function sendcardset($data)
    {
        //编辑
        if(array_key_exists('id',$data))
        {
            if(array_key_exists('card_num',$data))
            {
                $insert['card_num'] = $data['card_num'];
            }
            if(array_key_exists('fee_num',$data))
            {
                $insert['fee_num'] = $data['fee_num'];
            }
            $response =  db('send_card_set')->where(['id'=>$data['id']])->update($insert);
             
            if(!$response)
            {
                return return_json(2,'操作失败',[],[]);
            }
            return return_json(1,'操作成功',$response);
        }
        //新增
        //字段验证
        if(!array_key_exists('card_num',$data))
        {
            return  return_json(2,'房卡数不能为空');
        } else {
            $insert['card_num'] = $data['card_num'];
        }
        if(!array_key_exists('fee_num',$data))
        {
            return  return_json(2,'金额不能为空');
        } else {
            $insert['fee_num'] = $data['fee_num'];
        }
        $insert['created_at'] = time();
        $response =  db('send_card_set')->insert($insert);

        if(!$response)
        {
            return return_json(2,'操作失败',[],[]);
        }
        return return_json(1,'操作成功',$response);
    }
    //改
    public function sendcardedit($data)
    {
        //字段验证edit
        if(!array_key_exists('id',$data))
        {
            return  return_json(2,'参数异常');
        }
        if(array_key_exists('card_num',$data))
        {
            $insert['card_num'] = $data['card_num'];
        }
        if(array_key_exists('fee_num',$data))
        {
            $insert['fee_num'] = $data['fee_num'];
        }
        $response =  db('send_card_set')->where(['id'=>$data['id']])->update($insert);

        if(!$response)
        {
            return return_json(2,'操作失败',[],[]);
        }
        return return_json(1,'操作成功',$response);
    }

    //删
    public function sendcarddel($data)
    {
        //字段验证edit
        if(!array_key_exists('id',$data))
        {
            return  return_json(2,'参数异常');
        }
        $response =  db('send_card_set')->where(['id'=>$data['id']])->delete();

        if(!$response)
        {
            return return_json(2,'操作失败',[],[]);
        }
        return return_json(1,'操作成功',$response);
    }

    /**
     * 平台相关
     * @param $data
     * @return string
     */
    public function platsendcard($data)
    {
        Log::info("调用发送房卡接口");
        //字段验证
        if(!array_key_exists('card_num',$data))
        {
            return  return_json(2,'房卡数不能为空');
        }
        if(!array_key_exists('id',$data))
        {
            return  return_json(2,'登录权限超时');
        }
        if(!array_key_exists('agent_account',$data))
        {
            return  return_json(2,'代理不存在');
        }

        //开启事务
        db::startTrans();
        try{
            //$type = 1 平台发卡  $type = 2 代理发卡
            if(!array_key_exists('agent_account',$data))
            {
                return  return_json(2,'代理账号不能为空');
            }
            //参数验证
            $update['card_num']  = $data['card_num'];
            $update['plat_id'] = $data['id'];
            $update['agent_account']  = $data['agent_account'];
            $update['created_at'] = time();

            //获取买卡 代理账号
            $userInfo = db('agent')->where(['account'=>$data['agent_account']])->find();
            if(!$userInfo)
            {
                return  return_json(2,'代理不存在');
            }

            $update['agent_account'] = $userInfo['account'];
            //给代理添加房卡 平台不消耗
            $upplat['card_num']  = $userInfo['card_num'] + $update['card_num'];
            $upplat['update_at'] =   time();

            $response =  db('agent')->where(['account'=>$data['agent_account']])->update($upplat);

            if(!$response)
            {
                return  return_json(2,'房卡数未能发放1');
            }
            //平台补卡使用日志
            $result =  db('plat_card')->insert($update);
            if(!$result)
            {
                return return_json(2,'房卡数未能发放2');
            }

            // 提交事务
            Db::commit();
            return return_json(1,'房卡数已发放');
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return return_json(2,'房卡数未能发放3');
        }
    }

    /*************************************代理相关*******************************************/
    /**
     * 代理购卡（要完成支付）
     * @param $data
     * @return string
     */
    public function agent_get_card($data)
    {
        Log::info("调用发送房卡接口");
        //字段验证
        if(!array_key_exists('card_id',$data))
        {
            return  return_json(2,'房卡参数缺失');
        }
        if(!array_key_exists('id',$data))
        {
            return  return_json(2,'登录权限超时');
        }


        //开启事务
        db::startTrans();
        try{
            //获取购买数额（fee_num）（card_num）
            $feeInfo = db('buy_card_set')->where(['id'=>$data['card_id']])->find();
            $card_num = $feeInfo['card_num'];//房卡数目
            $fee_num = $feeInfo['fee_num'];

            //支付部分

            //日志记录

/*             if(!array_key_exists('user_account',$data))
            {
                return  return_json(2,'用户账号不能为空');
            }
            if(!array_key_exists('wx_name',$data))
            {
                return  return_json(2,'微信不存在');
            } */
            //参数验证
            $update['card_num']  = $card_num;
            $update['agent_id'] = $data['id']; //代理id
/*             $update['user_account']  = $data['user_account'];//购买房卡用户账号
            $update['wx_name'] = $data['wx_name']; */
            $update['status'] = 2;//添加纪录
            $update['created_at'] = time();
            //获取代理信息
            $agentInfo = db('agent')->where(['id'=>$data['id']])->find();
            if(!$agentInfo)
            {
                return  return_json(2,'没有代理信息');
            }
            //代理房卡消耗 用户房卡
            $upagent['card_num']  = $agentInfo['card_num'] + $update['card_num'];
            $upagent['update_at'] =   time();
            $response =  db('agent')->where(['id'=>$data['id']])->update($upagent);
			
            if(!$response)
            {
                return return_json(2,'房卡数未能发放');
            }
			//获取获利配置
			$return_fee = db('refeeset')->select();
			//给第一级分利
									
				
			if(isset($agentInfo['pid']) && $agentInfo['pid'] > 0){
				
					$oneinfo = db('agent')->where(['id'=>$agentInfo['pid']])->find();
					//更新返利
					$oneupdate['return_fee'] = ($oneinfo['return_num'] + ($return_fee[0]['one_fee'] * $fee_num ))/100;

					$response =  db('agent')->where(['id'=>$agentInfo['pid']])->update($oneupdate);
					
					//添加日志
					$one_insert['totel_fee'] = $fee_num;
					$one_insert['fee_num'] = $oneupdate['return_fee'];
				    $one_insert['agent_id'] = $agentInfo['id'];
					$one_insert['account'] = $agentInfo['account'];
				    $one_insert['pid'] = $oneinfo['id'];
					$one_insert['pname'] = $oneinfo['wx_name'];
					
			        $one_insert['created_at'] = time();
										
					$one_res = db('return_fee_log')->insert($one_insert);	
					

								//给第二级分利
				if(isset($oneinfo['pid']) && $oneinfo['pid'] > 0){
					
						$towinfo = db('agent')->where(['id'=>$oneinfo['pid']])->find();
						//更新返利
													//更新返利 
							$towupdate['return_fee'] = ($towinfo['return_num'] + ($return_fee[0]['tow_fee'] * $fee_num ))/100;
							$response =  db('agent')->where(['id'=>$oneinfo['pid']])->update($towupdate);
							//添加日志
							$tow_insert['totel_fee'] = $fee_num;
							$tow_insert['fee_num'] = $towupdate['return_fee'];
							$tow_insert['agent_id'] = $agentInfo['id'];
							$tow_insert['account'] = $agentInfo['account'];
											    $tow_insert['pid'] = $towinfo['id'];
					$tow_insert['pname'] = $towinfo['wx_name'];
							$tow_insert['created_at'] = time();
							$one_res = db('return_fee_log')->insert($tow_insert);	
						
						
						//添加日志					
						
				
				} 
									//给第三级分利
					if(isset($towinfo['pid']) && $towinfo['pid'] > 0){
							$threeinfo = db('agent')->where(['id'=>$towinfo['pid']])->find();
											//更新返利
					$threeupdate['return_fee'] = ($threeinfo['return_num'] + ($return_fee[0]['three_fee'] * $fee_num ))/100;
					$response =  db('agent')->where(['id'=>$towinfo['pid']])->update($threeupdate);
					//添加日志
					$three_insert['totel_fee'] = $fee_num;
					$three_insert['fee_num'] = $threeupdate['return_fee'];
					$three_insert['agent_id'] = $agentInfo['id'];
					$three_insert['account'] = $agentInfo['account'];
																    $three_insert['pid'] = $threeinfo['id'];
					$three_insert['pname'] = $threeinfo['wx_name'];
			        $three_insert['created_at'] = time();
					$one_res = db('return_fee_log')->insert($three_insert);			
					}			
					
			}


            //添加房卡使用日志
			$update['fee_num'] = $fee_num;
            $result = $this->insert($update);
            if(!$result)
            {
                return return_json(2,'房卡数未能发放');
            }
            //执行给用户加房卡（暂时不用）
            // 提交事务
            Db::commit();
            return return_json(1,'房卡数已发放');
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return return_json(2,'房卡数未能发放');
        }
    }
    /**
     * 代理发卡
     * @param $data
     * @return string
     */
    public function agent_send_card($data)
    {
        Log::info("调用发送房卡接口");
        //字段验证
        if(!array_key_exists('card_id',$data))
        {
            return  return_json(2,'房卡数不能为空');
        }
        if(!array_key_exists('id',$data))
        {
            return  return_json(2,'登录权限超时');
        }
        $feeInfo = db('send_card_set')->where(['id'=>$data['card_id']])->find();
        $card_num = $feeInfo['card_num'];//房卡数目
        $fee_num = $feeInfo['fee_num'];


        //开启事务
        db::startTrans();
        try{
            //$type = 1 平台发卡  $type = 2 代理发卡
            if(!array_key_exists('user_account',$data))
            {
                return  return_json(2,'代理账号不能为空');
            }
            if(!array_key_exists('wx_name',$data))
            {
                return  return_json(2,'微信不存在');
            }
            //参数验证
            $update['card_num']  = $card_num;
            $update['agent_id'] = $data['id']; //代理id
            $update['user_account']  = $data['user_account'];//购买房卡用户账号
            $update['wx_name'] = $data['wx_name'];
            $update['created_at'] = time();
            //获取代理信息
            $agentInfo = db('agent')->where(['id'=>$data['id']])->find();
            if(!$agentInfo)
            {
                return  return_json(2,'没有代理信息');
            }
            //代理房卡数量检查
            if($agentInfo['card_num']<$update['card_num'])
            {
                return return_json(2,'房卡数目不足，请充值.当前房卡为'.$agentInfo['card_num']);
            }
            //代理房卡消耗 用户房卡
            $upagent['card_num']  = $agentInfo['card_num'] - $update['card_num'];
            $upagent['update_at'] =   time();
            $response =  db('agent')->where(['id'=>$data['id']])->update($upagent);
            if(!$response)
            {
                return return_json(2,'房卡数未能发放');
            }
            //调取远程游戏端接口
            //$dataGame['userId'] =$data['user_account'];
            //$dataGame['card'] =$data['card_num'];
            $dataGame['reqIp'] =get_client_ip();
            //$dataGame['master'] =$agentInfo['account'];
            $dataGame['time'] = time();
            //$dataGame['auth'] =get_auth($dataGame);
/*            $url ="http://".Config::get('web_url')."/msh/AddArenaCard?userId=".$dataGame['userId']."&card=".$dataGame['card']."&master=".$dataGame['master']."&reqIp=".$dataGame['reqIp']."&time=".$dataGame['time']."&auth=".$dataGame['auth'];
            $gameBace = game_curl($url);
            $gameBace = json_decode($gameBace,'json');*/
            $gameBace['result'] ='OK';
            if($gameBace['result'] !='OK')
            {
                return return_json(2,'游戏房卡发放失败');
            }

            //添加房卡使用日志
            $result = $this->insert($update);
            if(!$result)
            {
                return return_json(2,'房卡数未能发放');
            }
            //执行给用户加房卡（暂时不用）
            // 提交事务
            Db::commit();
            return return_json(1,'房卡数已发放');
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return return_json(2,'房卡数未能发放3');
        }
    }
	/*******************************日志**********************************/
	//代理发卡日志
	public function send_card_logs($data)
	{

            if(!array_key_exists('id',$data))
            {
                return  return_json(2,'代理不存在');
            }  
            $where = ' where a.agent_id  = b.id and a.agent_id = '.$data["id"];
              if(array_key_exists('start_time', $data) && !array_key_exists('end_time', $data) && $data['start_time'] !='' && $data['end_time'] !='')
            {
                $where .= ' and a.created_at >= '.$data['start_time'];
            }
            if(!array_key_exists('start_time', $data) && array_key_exists('end_time', $data) && $data['start_time'] !='')
            {
                $where .= ' and a.created_at <= '.$data['end_time'];
            }
            if(array_key_exists('start_time', $data) && array_key_exists('end_time', $data)&& $data['end_time'] !='')
            {
                $where .= ' and a.created_at >= '.$data['start_time'].' and a.created_at <= '.$data['end_time'];
            } 
            //分页
            //计算总页数
            
            $sqlc =  "select count(a.agent_id)  from hand_agent_card as a,hand_agent as b  ".$where;
            $count = db()->Query($sqlc);

            $totle = $count[0]["count(a.agent_id)"];//总数
            $limit = 30;//每页条数
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
            
            $sql =  "select * from (select a.agent_id,a.card_num,a.created_at,a.user_account,a.wx_name,b.account  as  agent_name from hand_agent_card as a,hand_agent as b ".$where." order by a.created_at desc) agentinfo limit ".$start.",".$limit;
            
            $res = db()->Query($sql);
        //判断是否为空
        if(!$res)
        {
            return return_json(1,'暂无信息 ');
        }
        //返回结果
        return return_json(1,'平台发卡记录',$res,$page);
    
	}
	//代理购卡日志 
		public function buy_card_logs($data)
	{
		        //获取查询sql
            if(!array_key_exists('id', $data) )
            {
                return return_json(2,'暂无代理信息 ');
            }else{
                $agentInfo = db('agent')->where(['id'=>$data['id']])->find();
                if(!$agentInfo)
                {
                    return return_json(2,'暂无代理信息 ');
                }
            }   
            $where = 'where a.agent_id  = b.id and a.agent_account = '.$agentInfo['account'];

            if(array_key_exists('start_time', $data) && !array_key_exists('end_time', $data) && $data['start_time'] !='' && $data['end_time'] !='')
            {
                $where .= ' and a.created_at >= '.$data['start_time'];
            }
            if(!array_key_exists('start_time', $data) && array_key_exists('end_time', $data) && $data['start_time'] !='')
            {
                $where .= ' and a.created_at <= '.$data['end_time'];
            }
            if(array_key_exists('start_time', $data) && array_key_exists('end_time', $data)&& $data['end_time'] !='')
            {
                $where .= ' and a.created_at >= '.$data['start_time'].' and a.created_at <= '.$data['end_time'];
            } 

            //分页
            //计算总页数
            $sqlc =  "select count(a.plat_id)  from hand_plat_card as a,hand_agent as b  ".$where;
			   
            $count = db()->Query($sqlc);
            $totle = $count[0]["count(a.plat_id)"];//总数
            $limit = 30;//每页条数
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

            $sql =  "select * from (select a.fee_num,a.plat_id,a.card_num,a.created_at,a.agent_account,b.account  as  agent_name from hand_plat_card as a,hand_agent as b ".$where." order by a.created_at desc) agentinfo limit ".$start.",".$limit;
        
        
        $res = db()->Query($sql);
        
        //判断是否为空
        if(!$res)
        {
            return return_json(1,'暂无信息 ');
        }
        //返回结果
        return return_json(1,'平台发卡记录',$res,$page);         
    
	}
	//代理获利日志
		public function return_fee_logs($data)
	{
		            if(!array_key_exists('id',$data))
            {
                return  return_json(2,'代理不存在');
            }  
            $where = ' where agent_id  ='.$data["id"];
              if(array_key_exists('start_time', $data) && !array_key_exists('end_time', $data) && $data['start_time'] !='' && $data['end_time'] !='')
            {
                $where .= ' and created_at >= '.$data['start_time'];
            }
            if(!array_key_exists('start_time', $data) && array_key_exists('end_time', $data) && $data['start_time'] !='')
            {
                $where .= ' and created_at <= '.$data['end_time'];
            }
            if(array_key_exists('start_time', $data) && array_key_exists('end_time', $data)&& $data['end_time'] !='')
            {
                $where .= ' and created_at >= '.$data['start_time'].' and created_at <= '.$data['end_time'];
            } 
            //分页
            //计算总页数
            
            $sqlc =  "select count(agent_id)  from hand_return_fee_log   ".$where;
            $count = db()->Query($sqlc);

            $totle = $count[0]["count(agent_id)"];//总数
            $limit = 30;//每页条数
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
            
            $sql =  "select * from (select agent_id,totel_fee,fee_num,created_at,pname,pid from hand_return_fee_log ".$where." order by created_at desc) agentinfo limit ".$start.",".$limit;
            
            $res = db()->Query($sql);
        //判断是否为空
        if(!$res)
        {
            return return_json(1,'暂无信息 ');
        }
        //返回结果
        return return_json(1,'平台发卡记录',$res,$page);
    
	}
	//体现日志
	public function put_fee_logs($data)
	{
		            if(!array_key_exists('id',$data))
            {
                return  return_json(2,'代理不存在');
            }  
            $where = ' where agent_id  ='.$data["id"];
              if(array_key_exists('start_time', $data) && !array_key_exists('end_time', $data) && $data['start_time'] !='' && $data['end_time'] !='')
            {
                $where .= ' and created_at >= '.$data['start_time'];
            }
            if(!array_key_exists('start_time', $data) && array_key_exists('end_time', $data) && $data['start_time'] !='')
            {
                $where .= ' and created_at <= '.$data['end_time'];
            }
            if(array_key_exists('start_time', $data) && array_key_exists('end_time', $data)&& $data['end_time'] !='')
            {
                $where .= ' and created_at >= '.$data['start_time'].' and created_at <= '.$data['end_time'];
            } 
            //分页
            //计算总页数
            
            $sqlc =  "select count(agent_id)  from hand_return_fee   ".$where;
            $count = db()->Query($sqlc);

            $totle = $count[0]["count(agent_id)"];//总数
            $limit = 30;//每页条数
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
            
            $sql =  "select * from (select fee_num,status,cause,created_at,get_account,pay_type from  hand_return_fee".$where." order by created_at desc) agentinfo limit ".$start.",".$limit;
            
            $res = db()->Query($sql);
        //判断是否为空
        if(!$res)
        {
            return return_json(1,'暂无信息 ');
        }
        //返回结果
        return return_json(1,'平台发卡记录',$res,$page);
    
	}
	//代理购卡日志 

    /*******之前的************/
    /**
     * 执行发房卡 
     * @param unknown $data
     * @param number $type
     */
    public function send_card($data,$type = 2)
    {
        Log::info("调用发送房卡接口");
        //字段验证
        if(!array_key_exists('card_num',$data))
        {
            return  return_json(2,'房卡数不能为空');
        }
        if(!array_key_exists('id',$data))
        {
            return  return_json(2,'登录权限超时');
        }


        //开启事务
        db::startTrans();        
        try{
            //$type = 1 平台发卡  $type = 2 代理发卡
            if($type == 1)
            {
                if(!array_key_exists('agent_account',$data))
                {
                    return  return_json(2,'代理账号不能为空');
                }
                //参数验证
                $update['card_num']  = $data['card_num'];
                $update['plat_id'] = $data['id'];
                $update['agent_account']  = $data['agent_account'];
                $update['created_at'] = time();
                
                //获取买卡 代理账号
                $userInfo = db('agent')->where(['account'=>$data['agent_account']])->find();
                if(!$userInfo)
                {
                    return  return_json(2,'代理不存在');
                }
                
                $update['agent_account'] = $userInfo['account'];
                //给代理添加房卡 平台不消耗            
                $upplat['card_num']  = $userInfo['card_num'] + $update['card_num'];
                $upplat['update_at'] =   time();
                
                $response =  db('agent')->where(['account'=>$data['agent_account']])->update($upplat);                          
                if(!$response)
                {
                    return  return_json(2,'房卡数未能发放1');
                }   
                //添加房卡使用日志
                $result =  db('plat_card')->insert($update);
                if(!$result)
                {
                    return return_json(2,'房卡数未能发放2');
                }
            }else{
                if(!array_key_exists('user_account',$data))
                {
                    return  return_json(2,'代理账号不能为空');
                }
                if(!array_key_exists('wx_name',$data))
                {
                    return  return_json(2,'微信不存在');
                }
                //参数验证
                $update['card_num']  = $data['card_num'];
                $update['agent_id'] = $data['id']; //代理id 
                $update['user_account']  = $data['user_account'];//购买房卡用户账号
                $update['wx_name'] = $data['wx_name'];
                $update['created_at'] = time();
                //获取代理信息 
                $agentInfo = db('agent')->where(['id'=>$data['id']])->find();     
                if(!$agentInfo)
                {
                    return  return_json(2,'没有代理信息');
                }
                //代理房卡数量检查
                if($agentInfo['card_num']<$update['card_num'])
                {
                    return return_json(2,'房卡数目不足，请充值.当前房卡为'.$agentInfo['card_num']);
                }                     
                //代理房卡消耗 用户房卡
                $upagent['card_num']  = $agentInfo['card_num'] - $update['card_num'];
                $upagent['update_at'] =   time();
                $response =  db('agent')->where(['id'=>$data['id']])->update($upagent);  
                if(!$response)
                {
                    return return_json(2,'房卡数未能发放');
                }
                //调取远程游戏端接口
                $dataGame['userId'] =$data['user_account'];
                $dataGame['card'] =$data['card_num'];
                $dataGame['reqIp'] =get_client_ip();
                $dataGame['master'] =$agentInfo['account'];
                $dataGame['time'] = time();
                $dataGame['auth'] =get_auth($dataGame);               
                $url ="http://".Config::get('web_url')."/msh/AddArenaCard?userId=".$dataGame['userId']."&card=".$dataGame['card']."&master=".$dataGame['master']."&reqIp=".$dataGame['reqIp']."&time=".$dataGame['time']."&auth=".$dataGame['auth'];
                $gameBace = game_curl($url);   
                $gameBace = json_decode($gameBace,'json'); 
                if($gameBace['result'] !='OK')
                {
                    return return_json(2,'游戏房卡发放失败');
                }
                
                //添加房卡使用日志
                $result = $this->insert($update);
                if(!$result)
                {
                    return return_json(2,'房卡数未能发放');
                }
                //执行给用户加房卡（暂时不用）
            }                     
            // 提交事务
            Db::commit();
            return return_json(1,'房卡数已发放');
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return return_json(2,'房卡数未能发放3');
        }  
    }
    /**
     *平台代理完成发卡查询
     * @param array $data
     * @param number $type 1 平台逻辑  2代理逻辑
     * @return string
     */
    public function  plat_send_log($data=[],$type  = 2)
    {  

        //获取查询sql
        if($type==1)
        {//平台记录查询
            $where = 'where a.plat_id  = b.id ';
            if(array_key_exists('account',$data) && $data['account'] !='')
            {
                $where .= ' and account like  "%'.$data["account"].'%"';
            }
            if(array_key_exists('start_time', $data) && !array_key_exists('end_time', $data) && $data['start_time'] !='' && $data['end_time'] !='')
            {
                $where .= ' and a.created_at >= '.$data['start_time'];
            }
            if(!array_key_exists('start_time', $data) && array_key_exists('end_time', $data) && $data['start_time'] !='')
            {
                $where .= ' and a.created_at <= '.$data['end_time'];
            }
            if(array_key_exists('start_time', $data) && array_key_exists('end_time', $data)&& $data['end_time'] !='')
            {
                $where .= ' and a.created_at >= '.$data['start_time'].' and a.created_at <= '.$data['end_time'];
            } 
            //分页
            //计算总页数
            $sqlc =  "select count(a.plat_id)  from hand_plat_card as a,hand_agent as b  ".$where;            
            $count = db()->Query($sqlc);
            $totle = $count[0]["count(a.plat_id)"];//总数
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
            $sql =  "select * from  ( select a.plat_id,a.agent_account,a.card_num,a.created_at,b.account  as  agent_name from hand_plat_card as a,hand_agent as b  ".$where." order by a.created_at desc) agentinfo limit ".$start.",".$limit;     
        }else{
            if(!array_key_exists('id', $data) )
            {
                return return_json(2,'暂无代理信息 ');
            }else{
                $agentInfo = db('agent')->where(['id'=>$data['id']])->find();
                if(!$agentInfo)
                {
                    return return_json(2,'暂无代理信息 ');
                }
            }   
            $where = 'where a.plat_id  = b.id and a.agent_account = '.$agentInfo['account'];

            if(array_key_exists('start_time', $data) && !array_key_exists('end_time', $data) && $data['start_time'] !='' && $data['end_time'] !='')
            {
                $where .= ' and a.created_at >= '.$data['start_time'];
            }
            if(!array_key_exists('start_time', $data) && array_key_exists('end_time', $data) && $data['start_time'] !='')
            {
                $where .= ' and a.created_at <= '.$data['end_time'];
            }
            if(array_key_exists('start_time', $data) && array_key_exists('end_time', $data)&& $data['end_time'] !='')
            {
                $where .= ' and a.created_at >= '.$data['start_time'].' and a.created_at <= '.$data['end_time'];
            } 
            //分页
            //计算总页数
            $sqlc =  "select count(a.plat_id)  from hand_plat_card as a,hand_agent as b  ".$where;
            $count = db()->Query($sqlc);
            $totle = $count[0]["count(a.plat_id)"];//总数
            $limit = 30;//每页条数
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

            $sql =  "select * from (select a.plat_id,a.card_num,a.created_at,a.agent_account,b.account  as  agent_name from hand_plat_card as a,hand_agent as b ".$where." order by a.created_at desc) agentinfo limit ".$start.",".$limit;
        }
        
        $res = db()->Query($sql);
        
        //判断是否为空
        if(!$res)
        {
            return return_json(1,'暂无信息 ');
        }
        //返回结果
        return return_json(1,'平台发卡记录',$res,$page);         
    }
    /**
     * 代理发卡记录
     * @param array $data
     * @param number $type 1 平台  2 代理
     */
    public function  agent_send_log($data=[],$type  = 2)
    {
 
        //获取查询sql
        if($type==1)
        {
            $where = 'where a.agent_id  = b.id ';
            if(array_key_exists('account',$data) && $data['account'] !='')
            {
                $where .= ' and account like  "%'.$data["account"].'%"';
            }
            if(array_key_exists('start_time', $data) && !array_key_exists('end_time', $data) && $data['start_time'] !='' && $data['end_time'] !='')
            {
                $where .= ' and a.created_at >= '.$data['start_time'];
            }
            if(!array_key_exists('start_time', $data) && array_key_exists('end_time', $data) && $data['start_time'] !='')
            {
                $where .= ' and a.created_at <= '.$data['end_time'];
            }
            if(array_key_exists('start_time', $data) && array_key_exists('end_time', $data)&& $data['end_time'] !='')
            {
                $where .= ' and a.created_at >= '.$data['start_time'].' and a.created_at <= '.$data['end_time'];
            }   
            //判断是否为空
            $emptya = db('agent_card')->select();
            if(empty($emptya))
            {
                return  return_json(1,'数据为空');
            }
            //分页
            //计算总页数
            $sqlc =  "select count(a.agent_id)  from hand_agent_card as a,hand_agent as b   ".$where;
            $count = db()->Query($sqlc);
            
            $totle = $count[0]["count(a.agent_id)"];//总数
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
            
             $sql =  "select *from (select a.agent_id,a.card_num,a.created_at,a.user_account,b.account  as  agent_name from hand_agent_card as a,hand_agent as b  ".$where." order by a.created_at desc) agentinfo limit ".$start.",".$limit;
        
        }else{
            if(!array_key_exists('id',$data))
            {
                return  return_json(2,'代理不存在');
            }  
            $where = ' where a.agent_id  = b.id and a.agent_id = '.$data["id"];
              if(array_key_exists('start_time', $data) && !array_key_exists('end_time', $data) && $data['start_time'] !='' && $data['end_time'] !='')
            {
                $where .= ' and a.created_at >= '.$data['start_time'];
            }
            if(!array_key_exists('start_time', $data) && array_key_exists('end_time', $data) && $data['start_time'] !='')
            {
                $where .= ' and a.created_at <= '.$data['end_time'];
            }
            if(array_key_exists('start_time', $data) && array_key_exists('end_time', $data)&& $data['end_time'] !='')
            {
                $where .= ' and a.created_at >= '.$data['start_time'].' and a.created_at <= '.$data['end_time'];
            } 
            //分页
            //计算总页数
            
            $sqlc =  "select count(a.agent_id)  from hand_agent_card as a,hand_agent as b  ".$where;
            $count = db()->Query($sqlc);
    
            $totle = $count[0]["count(a.agent_id)"];//总数
            $limit = 30;//每页条数
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
            
            $sql =  "select * from (select a.agent_id,a.card_num,a.created_at,a.user_account,a.wx_name,b.account  as  agent_name from hand_agent_card as a,hand_agent as b ".$where." order by a.created_at desc) agentinfo limit ".$start.",".$limit;
            }
            $res = db()->Query($sql);
        //判断是否为空
        if(!$res)
        {
            return return_json(1,'暂无信息 ');
        }
        //返回结果
        return return_json(1,'平台发卡记录',$res,$page);
    }
    /**
     * 代理一对一发卡
     * @param unknown $data
     */    
    public  function  agentOneSend($data)
    {
    	//字段验证
    	if(!array_key_exists('card_num',$data))
    	{
    		return  return_json(2,'房卡数不能为空');
    	}
    	if(!array_key_exists('id',$data))
    	{
    		return  return_json(2,'登录权限超时');
    	}
    	
    	
    	//开启事务
    	db::startTrans();
    	try {               
    	if(!array_key_exists('user_account' ,$data))
    	{
    		return  return_json(2, '代理账号不能为空');
    	}
    	//参数验证
    	$update['card_num'] = $data['card_num'];
    	$update['agent_id'] = $data['id']; //代理id
    	$update['user_account'] = $data['user_account'];//购买房卡用户账号
    	$update['wx_name'] = $data['wx_name'];
    	$update['created_at'] = time();
    	//获取代理信息
    	$agentInfo = db('agent')->where(['id' => $data['id']])->find();
    	if(!$agentInfo)
    	{
    		return  return_json(2, '没有代理信息');
    	}
    	//代理房卡数量检查
    	if($agentInfo['card_num'] < $update['card_num'])
    	{
    		return return_json(2, '房卡数目不足，请充值.当前房卡为'.$agentInfo['card_num']);
    	}
    	//代理房卡消耗 用户房卡
    	$upagent['card_num'] = $agentInfo['card_num'] - $update['card_num'];
    	$upagent['update_at'] = time();
    	$response =  db('agent')->where(['id' => $data['id']])->update($upagent);
    	if(!$response)
    	{
    		return return_json(2, '房卡数未能发放');
    	}
    	//调取远程游戏端接口
    	$dataGame['userId'] =$data['user_account'];
    	$dataGame['card'] =$data['card_num'];
    	$dataGame['reqIp'] =get_client_ip();
    	$dataGame['master'] =$agentInfo['account'];
    	$dataGame['time'] = time();
    	$dataGame['auth'] =get_auth($dataGame);
    	$url ="http://".Config::get('web_url')."/msh/AddArenaCard?userId=".$dataGame['userId']."&card=".$dataGame['card']."&master=".$dataGame['master']."&reqIp=".$dataGame['reqIp']."&time=".$dataGame['time']."&auth=".$dataGame['auth'];
    	$gameBace = game_curl($url);
    	$gameBace = json_decode($gameBace,'json');
    	if($gameBace['result'] !='OK')
    	{
    		return return_json(2,'游戏房卡发放失败');
    	}
    	
    	//添加房卡使用日志
    	$result = $this->insert($update);
    	if(!$result)
    	{
    		return return_json(2,'房卡数未能发放');
    	}
    	
    	// 提交事务
    	Db::commit();
    	return return_json(1,'房卡数已发放');
	    } catch (\Exception $e) {
	    	// 回滚事务
	    	Db::rollback();
	    	return return_json(2,'房卡数未能发放3');
	    }
    }
    /**
     * 代理给代理批量转发
     * @param unknown $data
     */
    public function agentToAgent($data)
    {
    	//字段验证
    	if(!array_key_exists('card_num',$data))
    	{
    		return  return_json(2,'房卡数不能为空');
    	}
    	if(!array_key_exists('id',$data))
    	{
    		return  return_json(2,'登录权限超时');
    	}
    	
    	
    	//开启事务
    	db::startTrans();
    	try {
    		if(!array_key_exists('user_account' ,$data))
    		{
    			return  return_json(2, '代理账号不能为空');
    		}
    		if(!array_key_exists('wx_name' ,$data))
    		{
    		    return  return_json(2, '微信不能为空');
    		}
    		if(!array_key_exists('phone' ,$data))
    		{
    		    return  return_json(2, '微信不能为空');
    		}
    		if(!array_key_exists('rname' ,$data))
    		{
    		    return  return_json(2, '微信不能为空');
    		}
    		//参数验证
    		$update['card_num'] = $data['card_num'];
    		$update['agent_id'] = $data['id']; //代理id
    		$update['user_account'] = $data['user_account'];//购买房卡用户账号
    		$update['wx_name'] = $data['wx_name'];
     		$update['rname'] = $data['rname'];
    		$update['phone'] = $data['phone']; 
    		$update['created_at'] = time();
    		
    		//获取买卡 代理账号
    		$userInfo = db('agent')->where(['account'=>$data['user_account']])->find();
    	
    		if(!$userInfo)
    		{
    			return  return_json(2,'代理不存在');
    		}

    		$update['user_account'] = $userInfo['account'];
    		//给代理添加房卡 平台不消耗
    		$upplat['card_num']  = $userInfo['card_num'] + $update['card_num'];
    		$upplat['update_at'] =   time();
    		
    		$response =  db('agent')->where(['account'=>$data['user_account']])->update($upplat);
    		
    		if(!$response)
    		{
    			return  return_json(2,'房卡数未能发放1');
    		}
    	
    		//获取代理信息
    		$agentInfo = db('agent')->where(['id' => $data['id']])->find();
    		if(!$agentInfo)
    		{
    			return  return_json(2, '没有代理信息');
    		}
    		//代理房卡数量检查
    		if($agentInfo['card_num'] < $update['card_num'])
    		{
    			return return_json(2, '房卡数目不足，请充值.当前房卡为'.$agentInfo['card_num']);
    		}
  
    		//代理房卡消耗 用户房卡
    		$upagent['card_num'] = $agentInfo['card_num'] - $update['card_num'];
    		$upagent['update_at'] = time();
    		$response =  db('agent')->where(['id' => $data['id']])->update($upagent);
    		if(!$response)
    		{
    			return return_json(2, '房卡数未能发放');
    		}    	
    		
    		//添加房卡使用日志
    		$update['status'] = 2;
    		$result = $this->insert($update);
    		if(!$result)
    		{
    			return return_json(2,'房卡数未能发放');
    		}
    		
    		// 提交事务
    		Db::commit();
    		return return_json(1,'房卡数已发放');
    	} catch (\Exception $e) {
    		// 回滚事务
    		Db::rollback();
    		return return_json(2,'房卡数未能发放3');
    	}

    }
    /**
     * 代理一对一发卡
     * @param unknown $data
     */
    public function agentOneLog($data)
    {
    	if(!array_key_exists('id',$data))
    	{
    		return  return_json(2,'代理不存在');
    	}
    	$where = ' where a.agent_id  = b.id and a.status = 1  and a.agent_id = '.$data["id"];
    	if(array_key_exists('start_time', $data) && !array_key_exists('end_time', $data) && $data['start_time'] !='' && $data['end_time'] !='')
    	{
    		$where .= ' and a.created_at >= '.$data['start_time'];
    	}
    	if(!array_key_exists('start_time', $data) && array_key_exists('end_time', $data) && $data['start_time'] !='')
    	{
    		$where .= ' and a.created_at <= '.$data['end_time'];
    	}
    	if(array_key_exists('start_time', $data) && array_key_exists('end_time', $data)&& $data['end_time'] !='')
    	{
    		$where .= ' and a.created_at >= '.$data['start_time'].' and a.created_at <= '.$data['end_time'];
    	}
    	//分页
    	//计算总页数
    	
    	$sqlc =  "select count(a.agent_id)  from hand_agent_card as a,hand_agent as b  ".$where;
    	$count = db()->Query($sqlc);
    	
    	$totle = $count[0]["count(a.agent_id)"];//总数
    	$limit = 30;//每页条数
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
    	
    	$sql =  "select * from (select a.agent_id,a.card_num,a.created_at,a.user_account,a.wx_name,b.account  as  agent_name from hand_agent_card as a,hand_agent as b ".$where." order by a.created_at desc) agentinfo limit ".$start.",".$limit;
	    
	    $res = db()->Query($sql);
	    //判断是否为空
	    if(!$res)
	    {
	    	return return_json(1,'暂无信息 ');
	    }
	    //返回结果
	    return return_json(1,'平台发卡记录',$res,$page);
    }
    /**
     * 代理给代理发卡记录
     * @param unknown $data
     */
    public function agentToLog($data)
    {
    	if(!array_key_exists('id',$data))
    	{
    		return  return_json(2,'代理不存在');
    	}
    	$where = ' where a.agent_id  = b.id and a.status = 2  and a.agent_id = '.$data["id"];
    	if(array_key_exists('start_time', $data) && !array_key_exists('end_time', $data) && $data['start_time'] !='' && $data['end_time'] !='')
    	{
    		$where .= ' and a.created_at >= '.$data['start_time'];
    	}
    	if(!array_key_exists('start_time', $data) && array_key_exists('end_time', $data) && $data['start_time'] !='')
    	{
    		$where .= ' and a.created_at <= '.$data['end_time'];
    	}
    	if(array_key_exists('start_time', $data) && array_key_exists('end_time', $data)&& $data['end_time'] !='')
    	{
    		$where .= ' and a.created_at >= '.$data['start_time'].' and a.created_at <= '.$data['end_time'];
    	}
    	//分页
    	//计算总页数
    	
    	$sqlc =  "select count(a.agent_id)  from hand_agent_card as a,hand_agent as b  ".$where;
    	
    	$count = db()->Query($sqlc);
    	
    	$totle = $count[0]["count(a.agent_id)"];//总数
    	$limit = 30;//每页条数
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
    	
    	$sql =  "select * from (select a.agent_id,a.card_num,a.created_at,a.user_account as agent_name,a.wx_name ,a.phone as phone,a.rname as rname  from hand_agent_card as a,hand_agent as b ".$where." order by a.created_at desc) agentinfo limit ".$start.",".$limit;
    	
    	$res = db()->Query($sql);
    	//判断是否为空
    	if(!$res)
    	{
    		return return_json(1,'暂无信息 ');
    	}
    	//返回结果
    	return return_json(1,'代理批发记录',$res,$page);
    }
}