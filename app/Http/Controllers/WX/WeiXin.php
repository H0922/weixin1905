<?php

namespace App\Http\Controllers\WX;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\WxUserModel;
use App\Model\KeModel as Ke;
use GuzzleHttp\Client;

class WeiXin extends Controller
{

    //测试token是否可用
    public function token(){
        echo WxUserModel::getAccessToken();
    }
   
     //链接微信接口
    public function wei(){
        // dd(45641564541);
        $token = '737051678ysd72bs7d2';
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $ec=$_GET['echostr'];
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        
        if( $tmpStr == $signature ){
            echo $ec;
        }else{
           die('not ok');
        }
    }
      //接收微信的推送事件
      public function wxer(){
        //将接收的数据记录存到日志文件
        $log_file="wx.log";
        $xml_str=file_get_contents("php://input");
        $data=date('Y-m-d H:i:s',time()).$xml_str;
        file_put_contents($log_file,$data,FILE_APPEND);
        $this->Usertext($xml_str);
    }

    //用户关注消息回复
    public function Usertext($xml_str){
        $xml_obj=simplexml_load_string($xml_str);
            $openid= $xml_obj->FromUserName;
            $touser=$xml_obj->ToUserName;
            $time=time();
            $getuser=WxUserModel::getUserInfo($openid);
            // dd($getuser);
        if($xml_obj->Event=="subscribe"){
            $data=[
                'openid'=>$openid,
                'sex'=>$getuser['sex'],
                'sub_time'=>$time,
                'nickname'=>$getuser['nickname'],
                'headimgurl'=>$getuser['headimgurl']
            ];
            WxUserModel::insert($data);
            $con='欢迎'.$getuser['nickname'].'同学进入选课系统';
            $link='<xml>
            <ToUserName><![CDATA['.$openid.']]></ToUserName>
            <FromUserName><![CDATA['.$touser.']]></FromUserName>
            <CreateTime>'.$time.'</CreateTime>
            <MsgType><![CDATA[text]]></MsgType>
            <Content><![CDATA['.$con.']]></Content>
          </xml>';
          echo $link;
        }
        //查看课程
        if ($xml_obj->Event=='CLICK') {
            //判断并且触发
            if ($xml_obj->EventKey=='1905ke') {
                $ke=Ke::where('openid','=',$openid)->first();
                if($ke){
                    $b='第一节课'.$ke['ka']."\n".'第二节课'.$ke['kb']."\n".'第三节课'.$ke['kc']."\n".'第四节课'.$ke['kd'];
                    $a='<xml>
                            <ToUserName><![CDATA['.$openid.']]></ToUserName>
                            <FromUserName><![CDATA['.$touser.']]></FromUserName>
                            <CreateTime>'.$time.'</CreateTime>
                            <MsgType><![CDATA[text]]></MsgType>
                            <Content><![CDATA['.$b.']]></Content>
                            </xml>';
                 echo $a;
                }else{
                    $b='您还没添加课程，请赶快去课程管理添加把';
                    $a='<xml>
                            <ToUserName><![CDATA['.$openid.']]></ToUserName>
                            <FromUserName><![CDATA['.$touser.']]></FromUserName>
                            <CreateTime>'.$time.'</CreateTime>
                            <MsgType><![CDATA[text]]></MsgType>
                            <Content><![CDATA['.$b.']]></Content>
                            </xml>';
                 echo $a;
                }
               
            }
        }
    }
    public function ke(){
        $data=$_GET;
        $token=$this->AccessToken($data['code']);
        dump($token);
        $access_tokrn=$token['access_token'];
        $openid=$token['openid'];
        $user=WxUserModel::where('openid',$openid)->first();
        $ke=Ke::where('openid','=',$openid)->first();
        $kee=Ke::where('openid','=',$openid)->value('openid');
        if($kee){
        return view('weixin.wx.list',['link'=>$ke]);
        }else{
        return view('weixin.wx.index',['openid'=>$openid]);
        }
    }

    public function AccessToken($code){
        $url='https://api.weixin.qq.com/sns/oauth2/access_token?appid='.env('WX_APPID').'&secret='.env('WX_APPSECRET').'&code='.$code.'&grant_type=authorization_code';
        $data=file_get_contents($url);
        $json=json_decode($data,true);
        return $json;
    }
    //添加功能
    public function insert(){
        $data=request()->input();
        unset($data['_token']);
        Ke::insert($data);
        $con='您的课程提交成功,时间为'.date('Y-m-d H:i:s');
        echo $con;
    }
    public function sss(){
        return view('weixin.wx.list');
    }
    //修改功能
    public function upd($k_id){
        $link=Ke::where('k_id','=',$k_id)->first();
        return view('weixin.wx.upd',['link'=>$link]);
    }
    public function update(){
        $data=request()->input();
        $id=$data['k_id'];
        unset($data['k_id']);
        unset($data['_token']);
        Ke::where('k_id','=',$id)->update($data);
        $access_token= WxUserModel::getAccessToken();
        $ke=Ke::where('openid','=','oQj6Rv3FhT85S9oSgg7V5uImOGRQ')->first();
        $b='您的课程修改为'."\n".'第一节课'.$ke['ka']."\n".'第二节课'.$ke['kb']."\n".'第三节课'.$ke['kc']."\n".'第四节课'.$ke['kd'];
        $url='https://api.weixin.qq.com/cgi-bin/message/mass/preview?access_token='.$access_token;
        $qun=[
            "touser"=>'oQj6Rv3FhT85S9oSgg7V5uImOGRQ',
            "msgtype"=>"text",
            "text"=>[
                "content"=>$b
            ]
        ];
        $json_qun=json_encode($qun,JSON_UNESCAPED_UNICODE);
        $client= new Client();
        $res=$client->request('POST',$url,[
            'body'=>$json_qun
        ]);
        // /echo $res->getBody();
        echo '您的课程修改成功';
    }
}
