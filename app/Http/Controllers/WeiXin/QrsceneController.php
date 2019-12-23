<?php

namespace App\Http\Controllers\WeiXin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\WxUserModel;
use GuzzleHttp\Client;
use App\Model\WxQsceneModel as Qs;
class QrsceneController extends Controller
{
    // public function index(){
    //         echo 123893145454564;
    // }
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
        $scene_id=WxUserModel::where('openid','=',$user['openid'])->value('scene_id');
        $qrscene=$this->erweima($scene_id);
        $httpss=$qrscene['imghttp'];
        $imgurl=$qrscene['imgurl'];
        $scene_arr=[
            'imghttp'=>$httpss,
            'imgurl'=>$imgurl,
            'scene_id'=>$scene_id
        ];
        // $qrscene[]=['scene_id'=>$scene_id];
        Qs::insert($scene_arr);
        return redirect($httpss);
    
    }
        //生成二维码
        public function erweima($scene_id){
            $accesstoken=WxUserModel::getAccessToken();
            $url='https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$accesstoken;
            $erwei=[
                    "expire_seconds"=>604800,
                    "action_name"=>"QR_SCENE",
                    "action_info"=>[
                        "scene"=>[
                            "scene_id"=>$scene_id
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
                $img_url='qrscene/'.date('YmdHis').'.jpg';
                $http=file_get_contents($add_ticket_url);
                file_put_contents($img_url,$http);
                $add_ticket_url_arr=[
                    'imgurl'=>$img_url,
                    'imghttp'=>$add_ticket_url
                ];
                return $add_ticket_url_arr;
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