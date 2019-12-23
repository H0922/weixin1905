<?php

namespace App\Http\Controllers\WeiXin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\WxUserModel as Mu;
use Illuminate\Support\Facades\Redis;
use GuzzleHttp\Client;
use App\Model\WxText as Text;
use App\Model\WxImg as Img;
use App\Model\WxVoice ;

use function GuzzleHttp\json_decode;
use function GuzzleHttp\json_encode;

class wxcontroller extends Controller
{
    //储存access_token
    protected $access_token;

        //魔术方法
    public function __construct(){
        //给$access_token属性赋值
        $this->access_token=$this->getAccessToken();
    }
    //获取access_token方法
    public function getAccessToken(){
        $key="wx_access_token";
        $access_token=Redis::get($key);
        if($access_token){
            return $access_token;
        }
        $url ='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.env('WX_APPID').'&secret='.env('WX_APPSECRET').'';
        $data_json=file_get_contents($url);
        $arr=json_decode($data_json,true);
        Redis::set($key,$arr['access_token']);
        Redis::expire($key,3600);
        return $arr['access_token'];
    }

 
    //接收微信的推送事件
    public function wxer(){
        //将接收的数据记录存到日志文件
        $log_file="wx.log";
        $xml_str=file_get_contents("php://input");
        $data=date('Y-m-d H:i:s',time()).$xml_str;
        file_put_contents($log_file,$data,FILE_APPEND);
        //用户关注信息回复
        $this->subuser($xml_str);
        $this->UserSub($xml_str);
    }
    //获取素材
    public function getMedia($media_id,$smg_type){
                $url ='https://api.weixin.qq.com/cgi-bin/media/get?access_token='.$this->access_token.'&media_id='.$media_id;

                $client=new Client();
                $response = $client->request('GET',$url);
                // dd($response);
                //获取文件类型
                $content_type=$response->getHeader('Content-Type')[0];
                $pos=strpos($content_type,'/');
                $extension='.'.substr($content_type,$pos+1);
                //获取文件内容
                $file_con=$response->getBody();
               
                //保存文件
                $save_path = 'wx_media/';
                if($smg_type=='image'){
                    $file_name = date('YmdHis').mt_rand(1111,9999).$extension;
                    $save_path = $save_path.'imgs/'.$file_name;
                }elseif($smg_type=='voice'){
                    $file_name = date('YmdHis').mt_rand(1111,9999).$extension;
                    $save_path = $save_path.'voice/'.$file_name;
                }
                // dd($save_path);
                file_put_contents($save_path,$file_con);
                return $save_path;

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
            // dd();
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
                $EventKey=$xml_obj->EventKey;
                if($EventKey){
                Mu::where('openid','=',$open_id)->update(['scene_id'=>$sub['user_id']]);
                }
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
                $user_id=Mu::insertGetId($data);
                // $EventKey=$xml_obj->EventKey;
                // if($EventKey){
                    Mu::where('user_id','=',$user_id)->update(['scene_id'=>$user_id]);
                // }
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

    }
         //用户信息回复并保存
    public function UserSub($xml_str){
        $xml_obj=simplexml_load_string($xml_str);
        $msg=$xml_obj->MsgType;
        $MediaId=$xml_obj->MediaId;
        $from=$xml_obj->FromUserName;
        $touser=$xml_obj->ToUserName;
        $time=time();
        $user_id=Mu::where('openid','=',$from)->value('user_id');
         //纯文本信息回复
         if($msg=='text'){
            $con=$xml_obj->Content;
            $c='感谢您的留言♥';
            $data=[
                'user_id'=>$user_id,
                'text_desc'=>$con,
                'time'=>$time,
            ];
            $res=Text::insert($data);
            if($res){
                $jie='<xml>
                <ToUserName><![CDATA['.$from.']]></ToUserName>
                <FromUserName><![CDATA['.$touser.']]></FromUserName>
                <CreateTime>'.$time.'</CreateTime>
                <MsgType><![CDATA[text]]></MsgType>
                <Content><![CDATA['.$c.']]></Content>
                </xml>';
                echo $jie;
            } 
            }
        //图片信息回复
        if($msg=='image'){
            $img=$this->getMedia($MediaId,$msg);
            $data=[
                'user_id'=>$user_id,
                'img_url'=>$img,
                'time'=>$time,
            ];
            $res=Img::insert($data);
            if($res){
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
            
        }
        
               //语音
        if($msg=='voice'){
            $voice=$this->getMedia($MediaId,$msg);
            $data=[
                'user_id'=>$user_id,
                'voice_url'=>$voice,
                'time'=>$time,
            ];
            $res=WxVoice::insert($data);
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
            //获取天气
            if ($xml_obj->Event=='CLICK') {
                //判断并且触发
                if ($xml_obj->EventKey=='tianqi') {
                    $url='https://free-api.heweather.net/s6/weather/now?location=changping,beijing&key=2d7e254248224efea1890b807654531f';
                    $data=file_get_contents($url);
                    $arr=json_decode($data,true);
                    $loc='您所在的城市是'.$arr['HeWeather6'][0]['basic']['parent_city'].'-'.$arr['HeWeather6'][0]['basic']['location'];
                    $cond_text='天气情况->'.$arr['HeWeather6'][0]['now']['cond_txt'];
                    $tmp='实时温度->'.$arr['HeWeather6'][0]['now']['tmp'];
                    $fen='风向->'.$arr['HeWeather6'][0]['now']['wind_dir'];
                    $li='风力->'.$arr['HeWeather6'][0]['now']['wind_sc'].'级';
                    $time='实时时间'.date('Y-m-d H:i:s');
                    $b=$time."\n".$loc."\n".$cond_text."\n".$tmp."\n".$fen."\n".$li;
                    $a='<xml>
                        <ToUserName><![CDATA['.$from.']]></ToUserName>
                        <FromUserName><![CDATA['.$touser.']]></FromUserName>
                        <CreateTime>'.$time.'</CreateTime>
                        <MsgType><![CDATA[text]]></MsgType>
                        <Content><![CDATA['.$b.']]></Content>
                        </xml>';
                    echo $a;
                }
            }
         //  视频
         if($msg=='video'){
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
            echo $jie;
        }


}
    //获取用户的基本信息
    public function getUserInfo($open_id){
            $url='https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->getAccessToken().'&openid='.$open_id.'&lang=zh_CN';
            //发送网络请求   发送的get的请求
            $json_str=file_get_contents($url);
            $data= json_decode($json_str,true);
            return $data;
    
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

    //自定义菜单
    public  function menu(){
        $urll='http://www.bianaoao.top/vote';
        $ewd_url=urlencode($urll);
        $goods='http://www.bianaoao.top/goodsgoods';
        $goods_url=urlencode($goods);
        $qrscene='http://www.bianaoao.top/qrscene';
        $qrscene_url=urlencode($qrscene);
       // dd('https://open.weixin.qq.com/connect/oauth2/authorize?appid='.env('WX_APPID').'&redirect_uri='.$goods_url.'&response_type=code&scope=snsapi_userinfo&state=1905goods#wechat_redirect');
        $url='https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$this->access_token;
        $menu=[
            'button'=>[
                [
                    'type'=>'view',
                    'name'=>'商城',
                    'url'=>'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.env('WX_APPID').'&redirect_uri='.$goods_url.'&response_type=code&scope=snsapi_userinfo&state=1905goods#wechat_redirect'
                ],
                [
                    'name'=>'这个可以点',
                    'sub_button'=>[
                    [
                        'type'=>'view',
                        'name'=>'投票业务',
                        'url'=>'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.env('WX_APPID').'&redirect_uri='.$ewd_url.'&response_type=code&scope=snsapi_userinfo&state=1905wx#wechat_redirect'
                    ],
                    [
                        'type'=>'click',
                        'name'=>'获取天气',
                        'key'=>'tianqi'
                    ],
                    [
                        'type'=>'view',
                        'name'=>'获取推荐二维码',
                        'url'=>'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.env('WX_APPID').'&redirect_uri='.$qrscene_url.'&response_type=code&scope=snsapi_userinfo&state=1905qrscene#wechat_redirect'
                    ]
                    ]
                ]
            ]
        ];
        $json_menu=json_encode($menu,JSON_UNESCAPED_UNICODE);
        dump($json_menu);
        $client = new Client();
        $res= $client->request('POST',$url,[
            'body'=>$json_menu
        ]);
       echo $res->getBody();
    }
    //微信群发接口
    public function qunfa(){
        $url='https://free-api.heweather.net/s6/weather/now?location=changping,beijing&key=2d7e254248224efea1890b807654531f';
        $data=file_get_contents($url);
        $arr=json_decode($data,true);
        $loc='您所在的城市是'.$arr['HeWeather6'][0]['basic']['parent_city'].'-'.$arr['HeWeather6'][0]['basic']['location'];
        $cond_text='天气情况->'.$arr['HeWeather6'][0]['now']['cond_txt'];
        $tmp='实时温度->'.$arr['HeWeather6'][0]['now']['tmp'];
        $fen='风向->'.$arr['HeWeather6'][0]['now']['wind_dir'];
        $li='风力->'.$arr['HeWeather6'][0]['now']['wind_sc'].'级';
        $time='实时时间'.date('Y-m-d H:i:s');
        $b=$time."\n".$loc."\n".$cond_text."\n".$tmp."\n".$fen."\n".$li;
        $opid=Mu::get()->toArray();
        $openid=array_column($opid,'openid');
        $url='https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token='.$this->access_token;
        // $con=date('Y-m-d H:i:s').'群发消息测试';
        $qun=[
            "touser"=>$openid,
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
            echo $res->getBody();
    }
    public function imgsend(){
        //文档的调用路径
        // $url='https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token='.$this->access_token;
        //预览方法的调用路径
        $url='https://api.weixin.qq.com/cgi-bin/message/mass/preview?access_token='.$this->access_token;
        $opid=Mu::get()->toArray();
        $openid=array_column($opid,'openid');
        $qun=[
            "touser"=>'oQj6Rv3FhT85S9oSgg7V5uImOGRQ',
            "image"=>[
                "media_id"=>"5wI96sanmTFF_UnXICrDzS8HQVbqjkcckXc_tXhuafFt6VsKUwIse0UQcOOCzDnV"
            ],
            "msgtype"=>"image",
        ];
        $json_qun=json_encode($qun,JSON_UNESCAPED_UNICODE);
        $client= new Client();
        $res=$client->request('POST',$url,[
            'body'=>$json_qun
        ]);
            echo $res->getBody();
    }

    //生成二维码
    public function erweima(){
        $url='https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$this->access_token;
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
            echo $ticket=$res->getBody();
            //获取二维码图片并存入
            $ticket_arr=json_decode($ticket,true);
            dump($ticket_arr);
            $ticket_url=urlencode($ticket_arr['ticket']);
            $add_ticket_url='https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$ticket_url;
            // $http=file_get_contents($add_ticket_url);
            // $img_url='qrscene/'.date('YmdHis').'.jpg';
            return redirect($add_ticket_url);
        //    dump(file_put_contents($img_url,$http));
    }


}


