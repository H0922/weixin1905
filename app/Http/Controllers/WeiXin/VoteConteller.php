<?php

namespace App\Http\Controllers\WeiXin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use function GuzzleHttp\json_decode;
use function GuzzleHttp\json_encode;

class VoteConteller extends Controller
{
    
   public function index(){
       $data=$_GET;
        $code=$data['code'];
       //获取access_token
       $this->AccessToken($code);
   }


   //获取Token
   public function AccessToke($code){
        $url='https://api.weixin.qq.com/sns/oauth2/access_token?appid='.env('WX_APPID').'&secret='.env('WX_APPSECRET').'&code='.$code.'&grant_type=authorization_code';
        $data=file_get_contents($url);
        $json=json_decode($data,true);
        dump($json);
    }
}
