<?php 
class Wechat{
    
    // 公共属性
    public $appid;
    public $appsecret;
    
    // 构造函数
    public function __construct($appid, $appsecret){
        $this->appid = $appid;
        $this->appsecret = $appsecret;
        // 连接数据库
        mysql_connect('localhost:3306','root','root');

        mysql_set_charset("utf8");
        
        //选择数据库 
        mysql_select_db("wechat");
    }

	// 验证消息来自服务器

	public function valid(){
		if($this->checkSignature()){
			echo $_GET["echostr"];
		} else {
			echo "error";
			exit;
		}
	}

	// 检验签名

	public function checkSignature(){
		$signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
                
        $tmpArr = array(TOKEN, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = join($tmpArr);
        $tmpStr = sha1( $tmpStr );
        
        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
	}

	// 处理用户请求消息

	public function responseMsg(){
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        if (!empty($postStr)){
        	// 将原生字符串转化为对象
        	// 
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			// 消息类型
			$MsgType = $postObj->MsgType;
			// 处理消息
			$this->checkMsgType($postObj,$MsgType);
    	}
	}

	// 处理消息类型
	
	public function checkMsgType($postObj,$MsgType){
		switch($MsgType){
			case 'text':
				// 处理文本消息
				$this->receiveText($postObj);
				break;
            // 处理图片消息
            case 'image':
            	// 处理图片消息
            	$this->receiveImage($postObj);
                break;
            case 'event':
            	// 处理事件类型消息
            	// 关注公众号或者取消关注
            	$Event = $postObj->Event;
            	// 处理事件
            	$this->checkEvent($postObj, $Event);
            	break;
			default:
				break;	
		}
	}
	
    // 处理click
    
    public function checkClick($postObj, $EventKey){
        switch($EventKey){
            case 'NEWS':
                $this->replyText($postObj,"新闻");
                break;
            case 'ZAN':
                $this->replyText($postObj,"谢谢");
                break;
        }
    }
	
    // 获取access_token
    
    public function get_access_token(){
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->appid."&secret=".$this->appsecret;
        $request = $this->https_request($url);
        return $request["access_token"];
    }
	
    // 	模拟get请求和post请求
    
    public function https_request($url, $data=""){
        // 开启curl 初始化
        $ch = curl_init();
        // 设置传输地址
        curl_setopt($ch, CURLOPT_URL, $url);
        // 以文件流的形式返回
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if($data){
            // 以post的方式
            //  设置以POST方式发送
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        // 发送curl
        // 返回json对象
        $request = curl_exec($ch);
        // 转换为数组
        $tmpArr = json_decode($request, TRUE);
        
        // 如果能转换成数组
        if(is_array($tmpArr)){
            return $tmpArr;
        } else {
            return $request;
        }
    }

	// 处理事件的方法
	public function checkEvent($postObj, $Event){
		switch($Event){
			// 关注事件
			case 'subscribe':
			    // 获取用户信息
				$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$this->get_access_token()."&openid=".$postObj->FromUserName;
				$userInfo = $this->https_request($url);
				$sql = "insert into userinfo values(null,'$userInfo[openid]','$userInfo[nickname]',
				'$userInfo[sex]','$userInfo[city]','$userInfo[province]','$userInfo[country]','$userInfo[headimgurl]','$userInfo[subscribe_time]')";
				mysql_query($sql);
				$this->replyText($postObj, "欢迎你~");
				break;
			case 'unsubscribe':
				// 取消关注事件
				break;
    		case 'CLICK':
                // key 对应菜单的key
                $this->checkClick($postObj, $postObj->EventKey);
                break;
            case 'LOCATION':
                // 地理位置信息
                // $sql = "插入地理位置信息表";
                break;
		}
	}

	//  处理文本消息

	public function receiveText($postObj){
		$Content = $postObj->Content;
		switch ($Content) {
			case '点歌':
				$this->replyText($postObj, "123123");
				break;
			case '笑话':
				$this->replyText($postObj, "xiaohua");
				break;
			default:
			 //   上墙消息可以在这做 通过正则匹配
				$this->replyText($postObj, "默认回答");
				break;
		}
	}

	// 处理图片消息

	public function receiveImage($postObj){
		$MediaId = $postObj->MediaId;
		$this->replyImage($postObj, $MediaId);
	}

	// 回复文本消息

	public function replyText($postObj, $content){
		$xml = '<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%d</CreateTime>
					<MsgType><![CDATA[text]]></MsgType>
					<Content><![CDATA[%s]]></Content>
				</xml>';
		echo sprintf($xml, $postObj->FromUserName, $postObj->ToUserName, time(), $content);
	}

	// 回复音乐

	public function replyMusic($postObj, $data){
		$xml = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%d</CreateTime>
					<MsgType><![CDATA[music]]></MsgType>
					<Music>
					<Title><![CDATA[%s]]></Title>
					<Description><![CDATA[%s]]></Description>
					<MusicUrl><![CDATA[%s]]></MusicUrl>
					<HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
					<ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
					</Music>
				</xml>";
		echo sprintf($xml, $postObj->FromUserName, $postObj->ToUserName, time(),$data['Title'],$data['Description'], $data['MusicUrl'], $data['HQMusicUrl'],$data['ThumbMediaId']);
	}

	// 回复图片

	public function replyImage($postObj, $mediaId){
		 $xml = '<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%d</CreateTime>
                    <MsgType><![CDATA[image]]></MsgType>
                    <Image>
                    <MediaId><![CDATA[%s]]></MediaId>
                    </Image>
            	</xml>';
        echo sprintf($xml, $postObj->FromUserName, $postObj->ToUserName, time(), $mediaId);
	}
	
    // 创建菜单
    public function menu_create($data){
        //  创建菜单的地址
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$this->get_access_token();
        return $this->https_request($url,$data);
        
    }
    // 查询菜单
    public function menu_select(){
        $url = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token=".$this->get_access_token();
        return $this->https_request($url);
    }
    // 删除菜单
    public function menu_delete(){
        $url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=".$this->get_access_token();
        return $this->https_request($url);
    }
    // 获取ticket
    public function getTicket(){
        $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$this->get_access_token()."&type=jsapi";
        $arr = $this->https_request($url);
        return $arr["ticket"];
    }
    // 获取随机数
    public function getNonceStr($length = 10){
        $str = "1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
        $newStr = "";
        for($i = 0; $i < $length; $i++){
            $newStr .= $str[rand(0, strlen($str) - 1)];
        }
        return $newStr;
    }
    // 生成jssdk的签名
    public function getSignature(){
        $ticket = $this->getTicket();
        $noncestr = $this->getNonceStr();
        $time = time();
        // 获取当前路径
        $url = "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
        $str = "jsapi_ticket=".$ticket."&noncestr=".$noncestr."&timestamp=".$time."&url=".$url;
        $signature = sha1($str);
        
        return array(
            'appid'=> $this->appid,
            'timestamp'=> $time, 
            'nonceStr'=>$noncestr,
            'signature'=>$signature,
            );
    }
}
?>
