<?php
namespace app\api\controller;

use app;
use think\Request;
use think\Config;
use think\Db;

class Wxpay
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

    public function wxpay(Request $request = null){
        $data = $request->param();
        //获取订单信息
        $where['fee_num'] = $data['fee_num'];
        $where['order_code'] = $data['order_code'];
        $res = db('plat_card')->where($where)->find();

        $userInfo = db('agent')->where(['id'=>$res['agent_id']])->find();
        $res['openid'] = $userInfo['openid'];
        require APP_PATH.'../vendor/wx/weixin.class.php';
        $weixin  = new \weixin();
        $code_str =$weixin->getJSAPI($res);
    }
    public function returnpay(){
// 获取微信回调的数据
        $notifiedData = file_get_contents('php://input');

        //XML格式转换
        $xmlObj = simplexml_load_string($notifiedData, 'SimpleXMLElement', LIBXML_NOCDATA);
        $xmlObj = json_decode(json_encode($xmlObj),true);

        // 当支付通知返回支付成功时
        if ($xmlObj['return_code'] == "SUCCESS" && $xmlObj['result_code'] == "SUCCESS") {

            //获取返回的所以参数
            //这里是要把微信返给我们的所有值，先删除sign的值，其他值 按ASCII从小到大排序，md5加密+‘key’；

            foreach( $xmlObj as $k=>$v) {
                if($k == 'sign') {
                    $xmlSign = $xmlObj[$k];
                    unset($xmlObj[$k]);
                };
            }

            $sign = http_build_query($xmlObj);
            //md5处理
            $sign = md5($sign.'&key=fwFKUSBIDAAEEYv9dK3IZ4qWGqX9zRK1');
            //转大写
            $sign = strtoupper($sign);

            //验签名。默认支持MD5

            if ( $sign === $xmlSign) {
                // 总订单号
                $trade_no = $xmlObj['out_trade_no'];
                $where['order_code'] = $trade_no;
                $result = db('plat_card')->where($where)->find();
                $res = db('plat_card')->where($where)->update(['status'=>1]);
                //获取房卡参数

                $feeInfo = db('buy_card_set')->where(['id' => $result['card_id']])->find();
                $card_num = $feeInfo['card_num'];//房卡数目
                $fee_num = $feeInfo['fee_num'];
                $agentInfo = db('agent')->where(['id' => $result['agent_id']])->find();
                           //代理房卡消耗 用户房卡
            $upagent['card_num'] = $agentInfo['card_num'] + $card_num;
            $upagent['all_card'] = $agentInfo['all_card'] + $card_num;
            $upagent['update_at'] = time();
            $response = db('agent')->where(['id' => $result['agent_id']])->update($upagent);

            if (!$response) {
                return return_json(2, '房卡数未能发放');
            }
            //获取获利配置
            $return_fee = db('refeeset')->select();
            //给第一级分利


            if (isset($agentInfo['pid']) && $agentInfo['pid'] > 0) {

                $oneinfo = db('agent')->where(['id' => $agentInfo['pid']])->find();
                //更新返利
                $oneupdate['return_fee'] = $oneinfo['return_fee'] + ($return_fee[0]['one_fee'] * $fee_num) / 100;

                $response = db('agent')->where(['id' => $agentInfo['pid']])->update($oneupdate);

                //添加日志
                $one_insert['totel_fee'] = $fee_num;
                $one_insert['fee_num'] = ($return_fee[0]['one_fee'] * $fee_num) / 100;
                $one_insert['agent_id'] = $agentInfo['id'];
                $one_insert['account'] = $agentInfo['account'];
                $one_insert['pid'] = $oneinfo['id'];
                $one_insert['pname'] = $oneinfo['wx_name'];
                $one_insert['wx_name'] = $agentInfo['wx_name'];
                $one_insert['save_fee'] = $oneupdate['return_fee'];
                $one_insert['level'] = 1;
                $one_insert['created_at'] = time();

                $one_res = db('return_fee_log')->insert($one_insert);


                //给第二级分利
                if (isset($oneinfo['pid']) && $oneinfo['pid'] > 0) {

                    $towinfo = db('agent')->where(['id' => $oneinfo['pid']])->find();
                    //更新返利
                    //更新返利
                    $towupdate['return_fee'] = $towinfo['return_fee'] + ($return_fee[0]['tow_fee'] * $fee_num) / 100;
                    $response = db('agent')->where(['id' => $oneinfo['pid']])->update($towupdate);
                    //添加日志
                    $tow_insert['totel_fee'] = $fee_num;
                    $tow_insert['fee_num'] = ($return_fee[0]['tow_fee'] * $fee_num) / 100;
                    $tow_insert['save_fee'] = $towupdate['return_fee'];
                    $tow_insert['agent_id'] = $agentInfo['id'];
                    $one_insert['wx_name'] = $agentInfo['wx_name'];
                    $tow_insert['account'] = $agentInfo['account'];
                    $tow_insert['pid'] = $towinfo['id'];
                    $tow_insert['level'] = 2;
                    $tow_insert['pname'] = $towinfo['wx_name'];
                    $tow_insert['created_at'] = time();
                    $one_res = db('return_fee_log')->insert($tow_insert);


                    //添加日志


                }
                //给第三级分利
                if (isset($towinfo['pid']) && $towinfo['pid'] > 0) {
                    $threeinfo = db('agent')->where(['id' => $towinfo['pid']])->find();
                    //更新返利
                    $threeupdate['return_fee'] = $threeinfo['return_fee'] + ($return_fee[0]['three_fee'] * $fee_num) / 100;
                    $response = db('agent')->where(['id' => $towinfo['pid']])->update($threeupdate);
                    //添加日志
                    $three_insert['totel_fee'] = $fee_num;
                    $three_insert['fee_num'] = ($return_fee[0]['three_fee'] * $fee_num) / 100;
                    $three_insert['agent_id'] = $agentInfo['id'];
                    $one_insert['wx_name'] = $agentInfo['wx_name'];
                    $three_insert['save_fee'] = $threeupdate['return_fee'];
                    $three_insert['account'] = $agentInfo['account'];
                    $three_insert['pid'] = $threeinfo['id'];
                    $three_insert['level'] = 3;
                    $three_insert['pname'] = $threeinfo['wx_name'];
                    $three_insert['created_at'] = time();
                    $one_res = db('return_fee_log')->insert($three_insert);
                }

            }
                $monthlog = db('month_log')->where(['agent_id' => $result['agent_id']])->find();


                if ($monthlog) {
                    $monthL['agent_id'] = $result['agent_id'];
                    $monthL['month'] = date('m');
                    $monthL['card_buy_num'] = $card_num + $monthlog['card_buy_num'];
                    $monthL['created_at'] = time();
                    $monthlog = db('month_log')->where(['agent_id' => $result['agent_id']])->update($monthL);
                } else {
                    $monthL['agent_id'] = $result['agent_id'];
                    $monthL['month'] = date('m');
                    $monthL['card_buy_num'] = $card_num;
                    $monthL['created_at'] = time();
                    $monthlog = db('month_log')->insert($monthL);

                }
                if($res){
                    $this->return_success();
                }
                //处理你商城购物的操作信息
                $this->return_error();

            }

        }

    }

    /*
     * 给微信发送确认订单金额和签名正确，SUCCESS信息 -xzz0521
     */
    private function return_success(){
        $return['return_code'] = 'SUCCESS';
        $return['return_msg'] = 'OK';
        $xml_post = '<xml>
                    <return_code>'.$return['return_code'].'</return_code>
                    <return_msg>'.$return['return_msg'].'</return_msg>
                    </xml>';
        echo $xml_post;exit;
    }
    private function return_error(){
        $return['return_code'] = 'ERROR';
        $return['return_msg'] = 'FALSE';
        $xml_post = '<xml>
                    <return_code>'.$return['return_code'].'</return_code>
                    <return_msg>'.$return['return_msg'].'</return_msg>
                    </xml>';
        echo $xml_post;exit;
    }


    /**
     * 将xml转为array
     * @param string $xml
     * return array
     */
    public function xml_to_array($xml){
        if(!$xml){
            return false;
        }
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $data;
    }

}