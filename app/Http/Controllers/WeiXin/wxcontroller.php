<?php

namespace App\Http\Controllers\WeiXin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class wxcontroller extends Controller
{

    //接收微信的推送事件
    public function wxer(){
        //将接收的数据记录存到日志文件
        $log_file="wx.log";
        $xml_str=file_get_contents("php://input");
        $data=date('Y-m-d H:i:s',time()).$xml_str;
        file_put_contents($log_file,$data,FILE_APPEND);
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

// <?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Model\UserModel as Mu;
// use Illuminate\Support\Facades\Redis;
// use GuzzleHttp\Client;

// use function GuzzleHttp\json_decode;

// class UserLogin extends Controller
// {

//     //access_tokrn数据
//         protected $access_token;

//         public function __construct()
//         {
//             //调用access_token
//             $this->access_token=$this->getAccessToken();
//         }
//         //获取封装access_token数据
//         public function getAccessToken(){
//           $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.env('WX_APPID').'&secret='.env('WX_APPSECRET').'';
//             $data_json=file_get_contents($url);
//             $arr=json_decode($data_json,true);
//             return $arr['access_token'];

//         }


//       //接收微信推送事件
//       //获取用户关注
//       public function wxer(){

//         //将接收的数据记录到日志文件
//         $log_file ="wx.log";
//         $xml_str=file_get_contents("php://input");
//         $da=date('Y-m-d H:i:s',time()).$xml_str;
//         file_put_contents($log_file,$da,FILE_APPEND);

//         //处理xml数据
//         $xml_obj =simplexml_load_string($xml_str);
//         $event =$xml_obj->Event;

//          //获取用户的openid
//          $open_id=$xml_obj->FromUserName;
//         if($event=='subscribe'){
//             //获取用户信息
//             $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->access_token.'&openid='.$open_id.'&lang=zh_CN';
//             $user_info=file_get_contents($url);
//             file_put_contents('wx_user.log',$user_info,FILE_APPEND);
//         }

//         //用户消息回复纯文本回复
//             $msy=$xml_obj->MsgType;
//             $to=$xml_obj->ToUserName;
//             $name=$xml_obj->FromUserName;
//             $time=time();
//             if($msy=='text'){
//                 $con=date('Y-m-d H:i:s',time()).$xml_obj->Content;
//             $nei= '<xml>
//                     <ToUserName><![CDATA['.$to.']]></ToUserName>
//                     <FromUserName><![CDATA['.$name.']></FromUserName>
//                     <CreateTime>'.$time.'</CreateTime>
//                     <MsgType><![CDATA[text]]></MsgType>
//                     <Content><![CDATA['.$con.']]></Content>
//                     </xml>';
//             echo $nei;  

//             }

//     }

//       //获取用户的基本信息
//       public function getUserInfo($access_token,$open_id){

//         $url='https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->access_token.'&openid='.$open_id.'&lang=zh_CN';
//         //发送网络请求   发送的get的请求
//         $json_str=file_get_contents($url);
//         $log_file='wx_user.log';
//         file_put_contents($log_file,$json_str,FILE_APPEND);

//     }
//     public function wx(){
//         $token = '737051678ysd72bs7d2';
//         $signature = $_GET["signature"];
//         $timestamp = $_GET["timestamp"];
//         $nonce = $_GET["nonce"];
//         $ec=$_GET['echostr'];
//         $tmpArr = array($token, $timestamp, $nonce);
//         sort($tmpArr, SORT_STRING);
//         $tmpStr = implode( $tmpArr );
//         $tmpStr = sha1( $tmpStr );
        
//         if( $tmpStr == $signature ){
//             echo $ec;
//         }else{
//            die('not ok');
//         }
//     }
  
  

// }

