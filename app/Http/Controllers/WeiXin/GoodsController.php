<?php

namespace App\Http\Controllers\WeiXin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GoodsController extends Controller
{
    //接收信息
    public function goods(){
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
       return view('weixin.goods.index');
    //    $this->index();
    //    return view('weixin.goods.ce');
    }
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
    //后台展示页面页面
    public function index(){
        // echo '1243';
        return view('weixin.goods.index');
    }

    //商品详情页
    public function goodslist(){
        // echo '1243';
        return view('weixin.goods.goodslist');

    }
}
