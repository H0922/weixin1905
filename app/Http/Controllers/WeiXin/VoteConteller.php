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
    public function delKey()
    {
        $key = $_GET['k'];
        echo 'Delete Key: '.$key;echo '</br>';
        Redis::del($key);
    }
    
   public function index(){
       $data=$_GET;
       if(empty($data)){
           return '请您在微信内打开此链接';
       }
        $code=$data['code'];
       //获取access_token
       $token=$this->AccessToken($code);
       if(empty($token['access_token'])){
            return "公众号有点小毛病请重新进去一下~";
        }
       //获取用户信息
       $access_tokrn=$token['access_token'];
       $openid=$token['openid'];
       $user=$this->Userxi($access_tokrn,$openid);
       //展示
       $this->list($user);
   }
         //展示
        public function list($user){
           $openid=$user['openid'];
            //保存用户信息
            $userinfo_key = 'h:u:'.$user['openid'];
            Redis::hMset($userinfo_key,$user);
           $key='ss:vote:lisi';
           if(Redis::zrank($key,$openid)){
               echo '您已经投过票了'; 
           }else{
            Redis::Zadd($key,time(),$openid);
           }
           $number=Redis::zRange($key,0,-1,true);
           $total=Redis::zCard($key);
           echo "投票成功，投票总人数".$total.'</br>';
           //return view('weixin.vote.index',['number'=>$number]);
           foreach($number as $k=>$v){
              $u_k = 'h:u:'.$k;
              $u = Redis::hgetAll($u_k);
              echo ' <img src="'.$u['headimgurl'].'"> ';
           }
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
