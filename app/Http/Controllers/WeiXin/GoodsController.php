<?php

namespace App\Http\Controllers\WeiXin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\WxUserModel as User;
use App\Model\WxGoodsModel as Goods;
use Illuminate\Support\Str;
class GoodsController extends Controller
{
    public function login(){
        $data=$_GET;
        if(empty($data)){
            return '请您在微信内打开此链接';
        }
        $code=$data['code'];
        //获取access_token
        $token=$this->AccessToken($code);
        // dump($token);
        if(empty($token['access_token'])){
            return "公众号有点小毛病请重新进去一下~";
        }
       //获取用户信息
       $access_tokrn=$token['access_token'];
       $openid=$token['openid'];
       $user=$this->Userxi($access_tokrn,$openid);
       $link=User::where('openid','=',$user['openid'])->first();
       session(['headimgurl'=>$link['headimgurl']]);  
       session(['nickname'=>$link['nickname']]);    
       return redirect('goodsgoods');
    }
    
    //商城首页
    public function goods(){
       $data=Goods::get();
        //微信配置
        $nonceStr = Str::random(8);
        $wx_config = [
            'appId'     => env('WX_APPID'),
            'timestamp' => time(),
            'nonceStr'  => $nonceStr,
        ];
        $ticket = User::getJsapiTicket();
        $goods=$_SERVER['REQUEST_URI'];
        $g=substr($goods,1);
        $url = 'http://www.bianaoao.top/'.$g;     
        $jsapi_signature = User::jsapiSign($ticket,$url,$wx_config);
        $wx_config['signature'] = $jsapi_signature;
       return view('weixin.goods.index',['data'=>$data,'wx_config'=>$wx_config]);
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
        $data=Goods::get();
        // $nonceStr = Str::random(8);
        // $wx_config = [
        //     'appId'     => env('WX_APPID'),
        //     'timestamp' => time(),
        //     'nonceStr'  => $nonceStr,
        // ];
        // $ticket = User::getJsapiTicket();
        // $goods=$_SERVER['REQUEST_URI'];
        // $g=substr($goods,1);
        // $url = $_SERVER['APP_URL'] . $g;   //  当前url
        // $jsapi_signature = User::jsapiSign($ticket,$url,$wx_config);
        // $wx_config['signature'] = $jsapi_signature;
        return view('weixin.goods.index',['data'=>$data]);
    }

    public function indexlogin(){
        echo "请您先关注此公众号";
        echo '<br>';
        echo "扫描下方二维码关注后点击商城自动登录";
        return redirect('wx/erweima');
    }

    //商品详情页
    public function goodslist($goods_id){
        $link=Goods::where('goods_id','=',$goods_id)->first();
        return view('weixin.goods.goodslist',['link'=>$link]);


    }
}
