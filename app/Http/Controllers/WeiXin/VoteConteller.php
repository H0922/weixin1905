<?php

namespace App\Http\Controllers\WeiXin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use function GuzzleHttp\json_decode;
use function GuzzleHttp\json_encode;
use Illuminate\Support\Facades\Redis;
class VoteConteller extends Controller
{
    
   public function index(){
       $data=$_GET;
       if(empty($data)){
           return '请您在微信内打开此链接';
       }
        $code=$data['code'];
       //获取access_token
       $token=$this->AccessToken($code);
       dump($token);
       //获取用户信息
       $access_tokrn=$token['access_token'];
       $openid=$token['openid'];
       $user=$this->Userxi($access_tokrn,$openid);
       dump($user);
       //展示
       $this->list($user);
   }
         //展示
        public function list($user){
           $openid=$user['openid'];
           $key='s:vote:lisi';
           Redis::Sadd($key,$openid);
           $number=Redis::Smembers($key);
           echo "投票成功，投票总人数".$number;
           $total=Redis::Scard($key);
           dump($total);
        }
        
   //获取Token
   public function AccessToken($code){
        $url='https://api.weixin.qq.com/sns/oauth2/access_token?appid='.env('WX_APPID').'&secret='.env('WX_APPSECRET').'&code='.$code.'&grant_type=authorization_code';
        $data=file_get_contents($url);
        $json=json_decode($data,true);
        return $json;
    }

    //获取用户信息
    public function Userxi($access_tokrn,$openid){
        $url='https://api.weixin.qq.com/sns/userinfo?access_token='.$access_tokrn.'&openid='.$openid.'&lang=zh_CN';
        $data=file_get_contents($url);
        $json=json_decode($data,true);
        return $json;
    }
}
