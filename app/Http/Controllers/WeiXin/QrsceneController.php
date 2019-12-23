<?php

namespace App\Http\Controllers\WeiXin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\WxUserModel;
use GuzzleHttp\Client;
class QrsceneController extends Controller
{
    public function index()
    {
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
        $qrscene=$this->erweima();
        return redirect($qrscene);
    
    }
        //生成二维码
        public function erweima(){
            $accesstoken=WxUserModel::getAccessToken();
            $url='https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$accesstoken;
            $erwei=[
                    "expire_seconds"=>604800,
                    "action_name"=>"QR_SCENE",
                    "action_info"=>[
                        "scene"=>[
                            "scene_id"=>"0922"
                        ]
                    ]
            ];
            //post方式请求此链接
            $json_rewei=json_encode($erwei,JSON_UNESCAPED_UNICODE);
            $client= new Client();
            $res=$client->request('POST',$url,[
                'body'=>$json_rewei
            ]);
                $ticket=$res->getBody();
                //获取二维码图片并存入
                $ticket_arr=json_decode($ticket,true);
               // dump($ticket_arr);
                $ticket_url=urlencode($ticket_arr['ticket']);
                $add_ticket_url='https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$ticket_url;
                // $http=file_get_contents($add_ticket_url);
                return $add_ticket_url;
               // file_put_contents('erwei.jpg',$http);
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