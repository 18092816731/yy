<?php 
namespace app\test\controller;
use think\Cache;
use think\Config;

class Agent extends  \think\Controller
{
    protected $webUrl;
    protected $testUrl;
    public function __construct()
    {
        $this->webUrl = 'http://www.handgame.com/';
        $this->testUrl = 'baiyao.91yelang.top/';
    }
    /*2018-6-12  */
    public function cardInfo()
    {
        $url = $this->webUrl.'api/agent/cardInfo';
        //$url = $this->testUrl.'api/agent/cardInfo';
        $data = [];
        $data['id'] = '11';
        $res = $this->curl_($url, $data);
        dump($res);
    }
    public function agentOneLog()
    {
        $url = $this->webUrl.'api/agent/agentOneLog';
        $data['id'] = 11;
        $res = $this->curl_($url, $data);
    }
    public function agentOneSend()
    {
        $url = $this->webUrl.'api/agent/agentOneSend';
        $data['id'] = 21;
        $data['user_account']  = '10002124';
        $data['card_num'] = 10;
        $data['wx_name'] = 'xiaoxiao';
        $res = $this->curl_($url, $data);
    }
    public function agentAcInfo()
    {
        //$url = $this->webUrl.'api/agent/agentAcInfo';
        $url = $this->testUrl.'api/agent/agentAcInfo';
        $data = [];
        $data['id'] = '11';
        $data['account'] = '666888';
        $res = $this->curl_($url, $data);
        dump($res);
    }
    public function agentToLog()
    {
        //$url = $this->webUrl.'api/agent/agentToLog';
        $url = $this->testUrl.'api/agent/agentToLog';
        $data = [];
        $data['id'] = '11';
        $data['card_num'] = '2269';
        $data['user_account'] = '666888';
        $data['wx_name'] ='笑话';
        $res = $this->curl_($url, $data);
        dump($res);
    }
    public function agentToAgent()
    {
        //$url = $this->webUrl.'api/agent/agentToAgent';
        $url = $this->testUrl.'api/agent/agentToAgent';
        $data = [];
        $data['id'] = '11';
        $data['card_num'] = '2269';
        $data['user_account'] = '666888';
        //$data['start_time'] = '1526351618';
        //$data['end_time'] = '1526352244';
        $data['wx_name'] ='笑话';
        $res = $this->curl_($url, $data);
        dump($res);
    }
    
    public function login()
    {
        $url = $this->webUrl.'api/platform/platLogin';
        //$url = $this->testUrl.'api/platform/plat_login';
        $data['account'] = '666666';
        $data['password']  = '123456';
        $res = $this->curl_($url, $data);
        dump($res);
    } 
    public function platSendCard()
    {
        //$url = $this->webUrl.'api/platform/platSendCard';
        $url = $this->testUrl.'api/platform/platSendCard';
        $data['id'] = '10';
        $data['agent_account']  = '18092816731';
        $data['card_num'] = 20;
        $res = $this->curl_($url, $data);
        dump($res);
    }
    public function platSendLog()
    {
        //$url = $this->webUrl.'api/platform/platSendLog';
        $url = $this->testUrl.'api/platform/platSendLog';
        $data = [];
        //$data['agent_account'] = '8';
        //$data['npage'] =1;
        //$data['start_time'] = '1526351618';
        //$data['end_time'] = '1526352244';
        $res = $this->curl_($url, $data);
        dump($res);
    }
    public function agentSendLog()
    {
       $url = $this->webUrl.'api/agent/agentSendLog';
        //$url = $this->testUrl.'api/agent/agentSendLog';
        $data = [];
        $data['id'] = '11';
        //$data['start_time'] = '1526351618';
        //$data['end_time'] = '1526352244';
        $data['npage'] =1;
        $res = $this->curl_($url, $data);
        dump($res);
    }
    public function plat_created()
    {
        //$url = $this->webUrl.'api/platform/platCreated';
       $url =  $this->testUrl.'api/platform/platCreated';
        $data['account'] = '6668377';
        $data['password']  = '123456';
        $data['phone'] = '13211235468';
        $data['wx_name'] = '13211235468';
        $data['rname'] = '王五1';
        $data['pid'] =4;
        $res = $this->curl_($url, $data);
        dump($res);
    }
    public function agentList()
    {
        $url = $this->webUrl.'api/agent/agentList';
        $data = [];
        $res = $this->curl_($url, $data);
        dump($res);
    }
    public function plat_loginout()
    {
        $url = $this->webUrl.'api/platform/plat_loginout';
        $data['account'] = '666888';
        $res = $this->curl_($url, $data);
        dump($res);
    }
    /*-----------------------代理-------------------------------  */
    public function agentCdCreated()
    {
        //$url = $this->webUrl.'api/platform/platCreated';
        $url =  $this->testUrl.'api/agent/agentCdCreated';
        $data['account'] = '6668374';
        $data['password']  = '123456';
        $data['phone'] = '18091623463';
        $data['wx_name'] = '13211235462';
        $data['rname'] = '李四';
        $data['pid'] =11;
        $res = $this->curl_($url, $data);
        dump($res);
    }
    public function agentCdList()
    {
        $url = $this->testUrl.'api/agent/agentCdList';
        $data['pid'] = 11;
        $data['account']= '37';
        $res = $this->curl_($url, $data);
        dump($res);
    }
    public function agent_login()
    {
        $url = $this->testUrl.'api/agent/agentLogin';
        $data['account'] = '888888';
        $data['password']  = '123456';
        $res = $this->curl_($url, $data);
        dump($res);
    }
    public function agentSendCard()
    {
         $url = $this->webUrl.'api/agent/agentSendCard';
        $data['id'] = 11;
        $data['user_account']  = '10002124';
        $data['account']='18092816732';
        $dataGame['master'] ='18092816731';
        $data['card_num'] = 10;
        $data['wx_name'] = 'xiaoxiao';
        $res = $this->curl_($url, $data);

        dump($res);  
 /*         $dataGame['card'] = 10;
        $dataGame['userId'] = '10002124';
        $dataGame['reqIp'] = get_client_ip();
        $dataGame['master'] ='888888';
        $dataGame['time'] = time();
        $dataGame['auth'] = get_auth($dataGame);
        dump($dataGame);
        //正式
        //$url ="http://101.201.234.189:8081/msh/AddArenaCard?userId=".$dataGame['userId']."&card=".$dataGame['card']."&reqIp=".$dataGame['reqIp']."&master=".$dataGame['master']."&time=".$dataGame['time']."&auth=".$dataGame['auth'];;
        //测试服
        $url ="http://112.74.161.230:8081/msh/AddArenaCard?userId=".$dataGame['userId']."&card=".$dataGame['card']."&reqIp=".$dataGame['reqIp']."&master=".$dataGame['master']."&time=".$dataGame['time']."&auth=".$dataGame['auth'];;
        
        $gameBace = game_curl($url);
        $gameBace = json_decode($gameBace,'json');
        dump($gameBace); */  
    }
    public function agent_change()
    {
       // $url = $this->webUrl.'api/agent/agent_change';
        $url = $this->testUrl.'api/platform/agentChange';
        $data['account'] = '888888';

        $data['password']  = '1234567';
        $data['opassword'] = '123456';
        $data['id'] = 5;
        $res = $this->curl_($url, $data);
        dump($res);
    }
    public function agentGetCard()
    {
        $url = $this->webUrl.'api/agent/agentGetCard';
        $data['id'] =5;
        //$data['start_time'] = '1526351618';
        //$data['start_time'] =   '1526352244';
        $data['npage'] =1;
        $res = $this->curl_($url, $data);
        dump($res);
    }
    public function agentSendLog1()
    {
        $url = $this->webUrl.'api/agent/agentSendLog';
        $data['id'] = 5;
       // $data['start_time'] = '1526351618';
       // $data['end_time'] = '1526352244';
        $data['npage'] =2;
        $res = $this->curl_($url, $data);
        dump($res);
    }
    public function nickname()
    {
        $url = $this->webUrl.'api/agent/nickname';
        $url ="http://".Config::get('web_url')."/msh/QueryNickName";
        dump($url);
        //$url = $this->testUrl.'api/agent/nickname';
        // $data['start_time'] = '1526351618';
        // $data['end_time'] = '1526352244';
        $data['user_account'] =10000007;
        $data['account'] ='18092816732';
        $res = $this->curl_($url, $data);
        dump($res);
    }
    public function change_info()
    {
        $url = $this->webUrl.'api/agent/agentInfoChange';

        $data['id'] =11;
        $data['phone'] ='18092816732';
        $data['rname'] ='田鹏';
        $data['wx_name'] ='田鹏';
        $res = $this->curl_($url, $data);
        dump($res);
    }
    public function agentStatus()
    {
        $url = $this->webUrl.'api/agent/agentStatus';
    
        $data['id'] =11;
        $data['status'] ='2';
        $res = $this->curl_($url, $data);
        dump($res);
    }
    public function agentInfo()
    {
        $url = $this->webUrl.'api/agent/agentInfo';
    
        $data['id'] =11;
        $res = $this->curl_($url, $data);
        dump($res);
    }
    public function newsPassword()
    {
        $url = $this->webUrl.'api/agent/newsPassword';
    
        $data['id'] =11;
        $res = $this->curl_($url, $data);
        dump($res);
    }
    public function aaa()
    {
        $dataGame['orderSn'] ='H528159378980009';
        $dataGame['amount'] =3; 
        $dataGame['cpParam'] ='dXNlcmlkPTEwMDAyMTUwJmdvb2RzaWQ9NDEwMjEwMDEmYXBwaWQ9NDEwMiZjYXRlZ29yeT0xMCZ0aGVuY29pbj0xMTAwMDAmY2x0dmVyPTE4MDUyODEw';
        $dataGame['time'] = time();
       
        //sign = f568e7600edd703e6691f0c3d28337a2
       //$url = " http://112.74.161.230:8081/msh/AddArenaCard?card=500&master=666666s&reqIp=2130706433&userId=18298562563&time=1526103003&auth=b17795bc06f0efec235e91333220c829";
        $dataGame['auth'] = get_auth($dataGame);
        //$url = "http://101.201.234.189:8081/msh/AddArenaCard?card=500&master=6666&reqIp=2130706433&userId=18298562563&time=".$dataGame['time']."&auth=".$dataGame['auth'];
        $url = "112.74.161.230:8081/pay/msh/PaymentCompleteNotify?orderSn=H528159378980009&amount=3&cpParam=dXNlcmlkPTEwMDAyMTUwJmdvb2RzaWQ9NDEwMjEwMDEmYXBwaWQ9NDEwMiZjYXRlZ29yeT0xMCZ0aGVuY29pbj0xMTAwMDAmY2x0dmVyPTE4MDUyODEw"."&time=".$dataGame['time']."&auth=".$dataGame['auth'];
       // $url ="http://101.201.234.189:8081/msh/QueryNickName?userId=10000007&master=18092816732&reqIp=".$dataGame['reqIp']."&time=".$dataGame['time']."&auth=".$dataGame['auth'];
        echo $url;
        $game_curl = game_curl($url);
       dump($game_curl);
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
    public function pp(){
        header("Location: http://www.baidu.com");
    }
}