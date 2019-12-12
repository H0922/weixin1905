<?php

namespace App\Http\Controllers\WeiXin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\WxUserModel as Mu;
class wxcontroller extends Controller
{
    //储存access_token
    protected $access_token;

    //魔术方法
    public function __construct()
    {
        //给$access_token属性赋值
        $this->access_token=$this->getAccessToken();
    }
    //获取access_token方法
    public function getAccessToken(){
        $url ='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.env('WX_APPID').'&secret='.env('WX_APPSECRET').'';
        $data_json=file_get_contents($url);
        $arr=json_decode($data_json,true);
        return $arr['access_token'];
    }

    //用户关注
    public function subuser($xml_str){
        //获取用户关注信息提示zss
        $xml_obj=simplexml_load_string($xml_str);
        $Event=$xml_obj->Event;
        // echo $Event;
        //信息回复
        $touser=$xml_obj->ToUserName;
        $from=$xml_obj->FromUserName;
        $time=time();
        //公众号关注
        if($Event=='subscribe'){
            //获取用户的open_id
            $open_id=$xml_obj->FromUserName;
            //获取用户信息
            $user='https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->getAccessToken().'&openid='.$open_id.'&lang=zh_CN';
            $user_json=file_get_contents($user);
            $user_arr=json_decode($user_json,true);
            // dd($user_arr);
            $sub=Mu::where('openid','=',$open_id)->first();
            //判断是否以前关注过
            if($sub){
                $name='欢迎您再次回家'.$user_arr['nickname'];
                $data=[
                    'sub_time'=>$xml_obj->CreateTime,
                    'nickname'=>$user_arr['nickname'],
                    'sex'=>$user_arr['sex'],
                    'headimgurl'=>$user_arr['headimgurl'],
                ];
                Mu::where('openid','=',$open_id)->update($data);
                $jie='<xml>
                <ToUserName><![CDATA['.$from.']]></ToUserName>
                <FromUserName><![CDATA['.$touser.']]></FromUserName>
                <CreateTime>'.$time.'</CreateTime>
                <MsgType><![CDATA[text]]></MsgType>
                <Content><![CDATA['.$name.']]></Content>
                </xml>';
                echo $jie;
            }else{
                $name='感谢您的关注'.$user_arr['nickname'];
                    //第一次关注添加入库
            $data=[
                'openid'=>$open_id,
                'sub_time'=>$xml_obj->CreateTime,
                'nickname'=>$user_arr['nickname'],
                'sex'=>$user_arr['sex'],
                'headimgurl'=>$user_arr['headimgurl'],
            ];
                Mu::insertGetId($data);
                $jie='<xml>
                <ToUserName><![CDATA['.$from.']]></ToUserName>
                <FromUserName><![CDATA['.$touser.']]></FromUserName>
                <CreateTime>'.$time.'</CreateTime>
                <MsgType><![CDATA[text]]></MsgType>
                <Content><![CDATA['.$name.']]></Content>
                </xml>';
                echo $jie;
            }
            
            $url='https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->getAccessToken().'&openid='.$open_id.'&lang=zh_CN';
            $data=file_get_contents($url);
            file_put_contents('wx_user.log',$data,FILE_APPEND);
        }

        
        //信息类型
        $msg=$xml_obj->MsgType;
        //纯文本信息回复
        if($msg=='text'){
        $con=date('Y-m-d H:i:s',time()).$xml_obj->Content;
            $jie='<xml>
            <ToUserName><![CDATA['.$from.']]></ToUserName>
            <FromUserName><![CDATA['.$touser.']]></FromUserName>
            <CreateTime>'.$time.'</CreateTime>
            <MsgType><![CDATA[text]]></MsgType>
            <Content><![CDATA['.$con.']]></Content>
            </xml>';
            echo $jie;
        }
        //图片信息回复
        if($msg=='image'){
            // $PicUrl=$xml_obj->PicUrl;
            $MediaId=$xml_obj->MediaId;
            $jie='<xml>
            <ToUserName><![CDATA['.$from.']]></ToUserName>
            <FromUserName><![CDATA['.$touser.']]></FromUserName>
            <CreateTime>'.$time.'</CreateTime>
            <MsgType><![CDATA[image]]></MsgType>
            <Image>
                <MediaId><![CDATA['.$MediaId.']]></MediaId>
            </Image>
            </xml>';
            echo $jie;
        }
        //语音
        if($msg=='voice'){
            $MediaId=$xml_obj->MediaId;
            $jie='<xml>
            <ToUserName><![CDATA['.$from.']]></ToUserName>
            <FromUserName><![CDATA['.$touser.']]></FromUserName>
            <CreateTime>'.$time.'</CreateTime>
            <MsgType><![CDATA[voice]]></MsgType>
            <Voice>
                <MediaId><![CDATA['.$MediaId.']]></MediaId>
            </Voice>
            </xml>';
            echo $jie;
        }
        //  视频
        if($msg=='video'){
            $MediaId=$xml_obj->MediaId;
            $title='公众号内测....haung';
            $desc='视频发布于'.date('Y-m-d H:i:s',time()).'huang';
            $jie='<xml>
            <ToUserName><![CDATA['.$from.']]></ToUserName>
            <FromUserName><![CDATA['.$touser.']]></FromUserName>
            <CreateTime>'.$time.'</CreateTime>
            <MsgType><![CDATA[video]]></MsgType>
            <Video>
            <MediaId><![CDATA['.$MediaId.']]></MediaId>
                <Title><![CDATA['.$title.']]></Title>
                <Description><![CDATA['.$desc.']]></Description>
            </Video>
            </xml>';
            return $jie;
        }
    }
    //接收微信的推送事件
    public function wxer(){
        //将接收的数据记录存到日志文件
        $log_file="wx.log";
        $xml_str=file_get_contents("php://input");
        $data=date('Y-m-d H:i:s',time()).$xml_str;
        file_put_contents($log_file,$data,FILE_APPEND);
        //用户关注和信息回复
        $this->subuser($xml_str);
        

    }

         //获取用户的基本信息
         public function getUserInfo($access_token,$open_id){

            $url='https://api.weixin.qq.com/cgi-bin/user/info?access_token=28_x2UxX7g34nGNqsOy_D1GPtBFWFYbocxpZjdTnu7RZ-hSutzSn6SWe-vvqAjeaGF3SbUQKU5arur2bA0E0zrwMosa8LBocEmFjSt6wKkzzTihtkVNZkoUikLwSg2hBKc4XkOo4uL4FCpbzT6oGSCjADARDN&openid=oQj6Rv3FhT85S9oSgg7V5uImOGRQ&lang=zh_CN';
            // //发送网络请求   发送的get的请求
            // $json_str=file_get_contents($url);
            // $log_file='wx_user.log';
            // file_put_contents($log_file,$json_str,FILE_APPEND);
    
        }


    //链接微信接口
    public function wx(){
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
}


