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
                $res = db('plat_card')->where($where)->update(['status'=>1]);
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