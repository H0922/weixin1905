<?php

namespace App\Http\Controllers\WX;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\WxUserModel;
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
    }
    public function ke(){
        $data=$_GET;
        echo $data;
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
}
