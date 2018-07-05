<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function  return_json($status =1 ,$msg = '',$data = [],$page=[])
{
    if($status ==1)
    {
        if($msg =='')
        {
            $msg = '操作成功';
        }        
        return json_encode(['status'=>'SUCCESS','code'=>200,'msg'=>$msg,'data'=>$data,'page'=>$page]);
    }else{
        if($msg =='')
        {
            $msg = '操作失败';
        }
        return json_encode(['status'=>'FAIL','code'=>201,'msg'=>$msg,'data'=>$data,'page'=>$page]);
    }
}

//post请求
function curl_($url,$data)
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
//获取ip 
function get_client_ip(){
    $ip = $_SERVER['REMOTE_ADDR'];
    $ip = explode('.',$ip);
    $r = ($ip[0] << 24) | ($ip[1] << 16) | ($ip[2] << 8) | $ip[3];
    if($r < 0) $r += 4294967296;       
    return $r;
}
function game_curl($url)
{    

    $ch = curl_init();
    //设置选项，包括URL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);

    //执行并获取HTML文档内容
    $output = curl_exec($ch);
    //释放curl句柄
    curl_close($ch);
    return $output;
}
function  get_auth($data)
{
    $time = $data['time'];
    $key = config('game_key');
    unset($data['time']);
    $str = '';
    ksort($data);
    foreach($data as $k=>$v)
    {
        $str .=$k.'='.$v.'&'; 
    }
    $rstr = $str.'time='.$time.'&key='.$key;
    
    return md5($rstr);
}

/**
 * 验证手机号是否正确
 * @author honfei
 * @param number $mobile
 */
function is_mobile($mobile) {
    if (!is_numeric($mobile)) {
        return false;
    }
    return preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,1,3,6,7,8]{1}\d{8}$|^18[\d]{9}$#', $mobile) ? true : false;
}
