<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;
class WxUserModel extends Model
{
    protected $table = "wx_user";
    protected $primaryKey = "user_id";
    
   
    public function WxText()
    {
        return $this->hasOne(WxText::class);
    }
    public static function getAccessToken(){
        $key="wx_access_token";
        $access_token=Redis::get($key);
        if($access_token){
            return $access_token;
        }
        $url ='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.env('WX_APPID').'&secret='.env('WX_APPSECRET').'';
        $data_json=file_get_contents($url);
        $arr=json_decode($data_json,true);
        Redis::set($key,$arr['access_token']);
        Redis::expire($key,3600);
        return $arr['access_token'];
    }
    //获取用户的基本信息
    public static function getUserInfo($open_id){
        $token=WxUserModel::getAccessToken();
        $url='https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$token.'&openid='.$open_id.'&lang=zh_CN';
        //发送网络请求   发送的get的请求
        $json_str=file_get_contents($url);
        $data= json_decode($json_str,true);
        return $data;

    }
     /**
     * 获取jsapi_ticket
     */
    public static function getJsapiTicket()
    {
        $key = 'wx_jsapi_ticket';
        $ticket  = Redis::get($key);
        if($ticket){
            return $ticket;
        }
        $access_token = self::getAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$access_token.'&type=jsapi';
        $josn= file_get_contents($url);
        $data = json_decode($josn,true);
        Redis::set($key,$data['ticket']);
        Redis::expire($key,3600);
        return $data['ticket'];
    }
    /**
     * 计算 jspai签名
     * @param $ticket
     * @param $url
     * @param $param
     * @return string
     */
    public static function jsapiSign($ticket,$url,$param)
    {
        $string1 = "jsapi_ticket={$ticket}&noncestr={$param['nonceStr']}&timestamp={$param['timestamp']}&url=".$url;
        return sha1($string1);
    }
}
