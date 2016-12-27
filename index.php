<?php

define("TOKEN", "weixin");

define("APP_ID",         "20160323000016384"); //百度翻译api的APPID
define("SEC_KEY",        "KbKJzlcfIrhhvA_dd12Z");//百度翻译api的密钥



$wechatObj = new wechatCallbackapi();
if (!isset($_GET['echostr'])) {
    $wechatObj->responseMsg();
}else{
    $wechatObj->valid();
}

class wechatCallbackapi
{
    //验证签名
    public function valid()
    {
        $echoStr = $_GET["echostr"];     //随机字符串
        $signature = $_GET["signature"]; //微信加密签名，signature结合了开发者填写的token参数和请求中的timestamp参数、nonce参数。
        $timestamp = $_GET["timestamp"]; //时间戳
        $nonce = $_GET["nonce"];         //随机数
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if($tmpStr == $signature){
			header('content-type:text');
            echo $echoStr;
            exit;
        }
    }

    //响应消息
    public function responseMsg()
    {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        if (!empty($postStr)){
            $this->logger("R ".$postStr);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);//simplexml_load_string() 函数把 XML 字符串载入对象中。如果失败，则返回 false。
            $RX_TYPE = trim($postObj->MsgType);
             
            //消息类型分离
            switch ($RX_TYPE)
            {
                case "event":
                    $result = $this->receiveEvent($postObj);
                    break;
                case "text":
                    $result = $this->receiveText($postObj);
                    break;
                case "image":
                    $result = $this->receiveImage($postObj);
                    break;
                case "location":
                    $result = $this->receiveLocation($postObj);
                    break;
                case "voice":
                    $result = $this->receiveVoice($postObj);
                    break;
                case "video":
                    $result = $this->receiveVideo($postObj);
                    break;
                case "link":
                    $result = $this->receiveLink($postObj);
                    break;
                default:
                    $result = "unknown msg type: ".$RX_TYPE;
                    break;
            }
            $this->logger("T ".$result);
            echo $result;
        }else {
            echo "";
            exit;
        }
    }

    //获取access_token（支持自动更新凭证）
    public function get_access_token()
    {
        $this->last_time = 1408851194;
        $access_token = "-DOEP6rnlKYd4HLnZHxteJai1NI1XwS1Jo6EVKlCwgx0gTdK0mtVh7YhwJ5YVnGyIyAHY6UaxdUPuyxVJmk85BAdGdZMICOVx9Pnqb5aqOj0MlyS639r5NcLxn9Z8vz4YSEdAGARLX";

        if(time() > ($this->last_time+7200))
        {
            //GET请求的地址
       
            /*$appid = "wx85895df60df1d178";//订阅号
            $appsecret = "dac09a3261553b31973b82f9d3b8b846";*/
            
            $appid = "wxc30b873f7ad323ca";//测试号
            $appsecret = "f8b7fc8683913d042ce122c590164620";

            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";
            $access_token_Arr =  $this->https_request($url);
            $this->last_time = time();
            return $access_token_Arr['access_token'];           
        }

        return $access_token;
    }
    //https请求（支持GET和POST）
    protected function https_request($url,$data = null)
    {
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        if(!empty($data))
        {
            curl_setopt($ch,CURLOPT_POST,1);//模拟POST
            curl_setopt($ch,CURLOPT_POSTFIELDS,$data);//POST内容
        }
        $outopt = curl_exec($ch);
        curl_close($ch);
        $outoptArr = json_decode($outopt,true);
        if(is_array($outoptArr))
        {
            return $outoptArr;
        }
        else
        {
            return $outopt;
        }
    }
    //md5加密
    private function buildSign($query, $appID, $salt, $secKey)
    {
        $str = $appID . $query . $salt . $secKey;
        $ret = md5($str);
        return $ret;
    }
    //接收事件消息
    private function receiveEvent($object)
    {
        $content = "";
        switch ($object->Event)
        {
            case "subscribe"://关注
                $openid = $object->FromUserName;
                $access_token =$this->get_access_token();
                $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
                $userinfo = $this->https_request($url);
                $nickname = $userinfo['nickname'];
                $sex = $userinfo['sex'];
                $city = $userinfo['city'];
                $subtime = $userinfo['subscribe_time'];
                $headimgurl =  $userinfo['headimgurl'];
                $connection=mysql_connect('rwjxepghbvju.rds.sae.sina.com.cn:10242','app_31142372','12345678');//连接到数据库
                mysql_query("set names 'utf8'");//编码转化
                $db_selecct=mysql_select_db('catering');//选择数据库
                $query="insert into user(s_openid,s_nickname,s_sex,s_headimgurl,s_city,s_subtime) value('{$openid}','{$nickname}',$sex,'{$headimgurl}','{$city}',$subtime)";//构建查询语句
                mysql_query($query);//执行查询
                mysql_close($connection);//关闭连接
                $content = "欢迎关注点餐系统!第一次使用请发送“注册”,成为会员。";
                break;
            case "unsubscribe":
                $content = "取消关注";
                break;
            case "SCAN":
                $content = "扫描场景 ".$object->EventKey;
                break;
            case "CLICK":
                switch ($object->EventKey)
                {
                    case "D_JUDGEMENT":
						 $openid = $object->FromUserName;
                        $access_token =$this->get_access_token();
                        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
                        $userinfo = $this->https_request($url);
                        $nickname = $userinfo['nickname'];
                        $headimgurl =  $userinfo['headimgurl'];
                        $content="您好!感谢您的支持，请留下您宝贵的意见
                                  <a href='http://31142372.applinzi.com/application.php/Home/Judgement/judgement?j_openid=$openid&j_nickname=$nickname&j_headimgurl=$headimgurl'>去评价</a>!";
                        break;
                        case "M_SELECT":
                        $openid = $object->FromUserName;
                        $connection=mysql_connect('rwjxepghbvju.rds.sae.sina.com.cn:10242','app_31142372','12345678');//连接到数据库
                        mysql_query("set names 'utf8'");//编码转化
                        $db_selecct=mysql_select_db('catering');//选择数据库
                        $sql="select * from `member` where m_openid='{$openid}'";
                        $ret=mysql_query($sql);
                        $data=mysql_fetch_array($ret);
                        $m_id=$data['m_id'];
                        $m_email=$data['m_email'];
                        $m_integral=$data['m_integral'];
                        $m_account=$data['m_account'];
                        $m_amount=$data['m_amount'];
                        $m_grade=$data['m_grade'];
                        mysql_close($connection);//关闭连接
                        $content="您好!您的会员账号为：{$m_id}；
                                  当前等级为：{$m_grade}；
                                  当前积分为：{$m_integral}；
                                  当前消费次数为：{$m_account}；
                                  当前消费总额为：￥{$m_amount}。
                                  <a href='http://31142372.applinzi.com/application.php/Home/Member/modify?m_id=$m_id&m_email=$m_email'>修改资料</a>";
                        break;
                    default:
                        $content = "点击菜单：".$object->EventKey;
                        break;
                }
                break;
            case "LOCATION":
                $content = "上传位置：纬度 ".$object->Latitude.";经度 ".$object->Longitude;
                break;
            case "VIEW":
                $content = "跳转链接 ".$object->EventKey;
                break;
            case "MASSSENDJOBFINISH":
                $content = "消息ID：".$object->MsgID."，结果：".$object->Status."，粉丝数：".$object->TotalCount."，过滤：".$object->FilterCount."，发送成功：".$object->SentCount."，发送失败：".$object->ErrorCount;
                break;
            default:
                $content = "receive a new event: ".$object->Event;
                break;
        }
        if(is_array($content)){
            if (isset($content[0])){
                $result = $this->transmitNews($object, $content);
            }else if (isset($content['MusicUrl'])){
                $result = $this->transmitMusic($object, $content);
            }
        }else{
            $result = $this->transmitText($object, $content);
        }

        return $result;
    }

    //接收文本消息
     private function receiveText($object)
    {
        
         $keyword = $object->Content;
         //多客服人工回复模式
         if (preg_match('/^\d{16}$/',$keyword)){
            //$result = $this->transmitService($object);
            $cont = $object->Content;
            $openid = $object->FromUserName;
            $addtime = date('Y-m-d H:i:s');
            $connection=mysql_connect('rwjxepghbvju.rds.sae.sina.com.cn:10242','app_31142372','12345678');//连接到数据库
            mysql_query("set names 'utf8'");//编码转化
            $db_selecct=mysql_select_db('catering');//选择数据库
            $sql="select n_usetime from `reserve` where n_id='{$cont}'";
            $ret=mysql_query($sql);
            $data=mysql_fetch_array($ret);
            $usetime=$data['n_usetime'];
            $query="insert into `remsg`(y_openid,y_content,y_addtime,y_state,y_usetime) value('{$openid}','{$cont}','{$addtime}','准备就餐','{$usetime}')";//构建查询语句
            mysql_query($query);//执行查询
            mysql_close($connection);//关闭连接
            $content = "稍等片刻，我们的客服正在为您处理。若您始终没有收到回复，请检查您输入的预定单号是否有误。";
            $result = $this->transmitText($object, $content);
          }else if (strstr($keyword, "注册")){
            $openid = $object->FromUserName;
            $content="您好!欢迎<a href='http://31142372.applinzi.com/application.php/Home/Register/register?openid=$openid'>注册</a>!";
            $result = $this->transmitText($object, $content);
          }
        //自动回复模式
         else{
            if (strstr($keyword, "文本")){
                $content = "这是个文本消息";
            }else if (strstr($keyword, "单图文")){
                $content = array();
                $content[] = array("Title"=>"单图文标题",  "Description"=>"单图文内容", "PicUrl"=>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", "Url" =>"http://www.baidu.com");
            }else if (strstr($keyword, "图文") || strstr($keyword, "多图文")){
                $content = array();
                $content[] = array("Title"=>"多图文1标题", "Description"=>"", "PicUrl"=>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", "Url" =>"http://www.baidu.com");
                $content[] = array("Title"=>"多图文2标题", "Description"=>"", "PicUrl"=>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", "Url" =>"http://www.baidu.com");
                $content[] = array("Title"=>"多图文3标题", "Description"=>"", "PicUrl"=>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", "Url" =>"http://www.baidu.com");
            }else if (strstr($keyword, "音乐")){
                $content = array();
                $content = array("Title"=>"后来", "Description"=>"歌手：刘若英", "MusicUrl"=>"http://rainbow.xjxxedu.cn/sourcefile/0/0/3/3231.mp3", "HQMusicUrl"=>"http://rainbow.xjxxedu.cn/sourcefile/0/0/3/3231.mp3");
            }else{
                $content = date("Y-m-d H:i:s",time());
            }
            
            if(is_array($content)){
                if (isset($content[0]['PicUrl'])){
                    $result = $this->transmitNews($object, $content);
                }else if (isset($content['MusicUrl'])){
                    $result = $this->transmitMusic($object, $content); 
                }
            }else{
                $result = $this->transmitText($object, $content);
            }
          }
		
         
        return $result;
    }

    //接收图片消息
    private function receiveImage($object)
    {
        //$content = array("MediaId"=>$object->MediaId);
        //$result = $this->transmitImage($object, $content);
        
        $media_id = $object->MediaId;
        $access_token =$this->get_access_token();
        $url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=".$access_token."&media_id=".$media_id;
        $optout = $this->https_request($url); 
 
        //通过SAE中的storage来上传调用下载多媒体文件接口下载下来的文件资源，以图片的形式保存
        $storage = new SaeStorage();//初始化
        $domain = 'images';  //指定存储文件的目录名
        $fileName = time().'.jpg';//指定创建的文件名
        $content = $optout;  //写入的内容
        $result = $storage->write($domain,$fileName, $content);

        $cont='保存成功,请<a href="http://31142372.applinzi.com/photo.php">查看</a>!';//http://1139483949.applinzi.com/photo/photo/index.php
        $ret = $this->transmitText($object, $cont);
        return $ret;
    }

    //接收位置消息
    private function receiveLocation($object)
    {
		$url = "http://api.map.baidu.com/telematics/v3/weather?location=".$object->Location_Y.",".$object->Location_X."&output=json&ak=L9FSMpygj5QE2c0rO5EKh94i";
		//$url = "http://api.map.baidu.com/telematics/v3/weather?location=石家庄&output=json&ak=L9FSMpygj5QE2c0rO5EKh94i";
		$weather_arr = $this->https_request($url);
		$dataArr=array();
		$tmpArr=$weather_arr['results'][0]['weather_data'];
		foreach($tmpArr as $w){
			$content[]=array(
			 	"Title"=>$w['date'].' '.$w['weather'].' '.$w['wind'].' '.$w['temperature'],
			 	"Description"=>$w['weather'].' '.$w['wind'].' '.$w['temperature'],
			 	"PicUrl"=>$w['dayPictureUrl'],
				"Url"=>''
		 	);
		}
        $result = $this->transmitNews($object, $content);
        return $result;
    }




	
    //接收语音消息
    private function receiveVoice($object)
    {
        if (isset($object->Recognition) && !empty($object->Recognition)){
           // $content = "你刚才说的是：".$object->Recognition;
			
			$q =  $object->Recognition;
			$salt  =rand(10000,99999);
			$from = 'zh';
			$to = 'en';
			$sign = $this->buildSign($q, APP_ID,$salt, SEC_KEY);
	
			$url = "http://api.fanyi.baidu.com/api/trans/vip/translate?q=".$q."&from=".$from."&to=".$to."&appid=".APP_ID."&salt=".$salt."&sign=".$sign;
			$optoutArr = $this->https_request($url);
			$content = $optoutArr['trans_result'][0]['dst'];
			
            $result = $this->transmitText($object, $content);
        }else{
            $content = array("MediaId"=>$object->MediaId);
            $result = $this->transmitVoice($object, $content);
        }

        return $result;
    }

    //接收视频消息
    private function receiveVideo($object)
    {
        $content = array("MediaId"=>$object->MediaId, "ThumbMediaId"=>$object->ThumbMediaId, "Title"=>"", "Description"=>"");
        $result = $this->transmitVideo($object, $content);
        return $result;
    }

    //接收链接消息
    private function receiveLink($object)
    {
        $content = "你发送的是链接，标题为：".$object->Title."；内容为：".$object->Description."；链接地址为：".$object->Url;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    //回复文本消息
    private function transmitText($object, $content)
    {
        $xmlTpl = "<xml>
        <ToUserName><![CDATA[%s]]></ToUserName>
        <FromUserName><![CDATA[%s]]></FromUserName>
        <CreateTime>%s</CreateTime>
        <MsgType><![CDATA[text]]></MsgType>
        <Content><![CDATA[%s]]></Content>
        </xml>";
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), $content);
        return $result;
    }
 
    //回复图片消息
    private function transmitImage($object, $imageArray)
    {
        $itemTpl = "<Image>
        <MediaId><![CDATA[%s]]></MediaId>
        </Image>";

        $item_str = sprintf($itemTpl, $imageArray['MediaId']);

        $xmlTpl = "<xml>
        <ToUserName><![CDATA[%s]]></ToUserName>
        <FromUserName><![CDATA[%s]]></FromUserName>
        <CreateTime>%s</CreateTime>
        <MsgType><![CDATA[image]]></MsgType>
        $item_str
        </xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复语音消息
    private function transmitVoice($object, $voiceArray)
    {
        $itemTpl = "<Voice>
        <MediaId><![CDATA[%s]]></MediaId>
        </Voice>";

        $item_str = sprintf($itemTpl, $voiceArray['MediaId']);

        $xmlTpl = "<xml>
        <ToUserName><![CDATA[%s]]></ToUserName>
        <FromUserName><![CDATA[%s]]></FromUserName>
        <CreateTime>%s</CreateTime>
        <MsgType><![CDATA[voice]]></MsgType>
        $item_str
        </xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复视频消息
    private function transmitVideo($object, $videoArray)
    {
        $itemTpl = "<Video>
        <MediaId><![CDATA[%s]]></MediaId>
        <ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
        </Video>";

        $item_str = sprintf($itemTpl, $videoArray['MediaId'], $videoArray['ThumbMediaId'], $videoArray['Title'], $videoArray['Description']);

        $xmlTpl = "<xml>
        <ToUserName><![CDATA[%s]]></ToUserName>
        <FromUserName><![CDATA[%s]]></FromUserName>
        <CreateTime>%s</CreateTime>
        <MsgType><![CDATA[video]]></MsgType>
        $item_str
        </xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复图文消息
    private function transmitNews($object, $newsArray)
    {
        if(!is_array($newsArray)){
            return;
        }
        $itemTpl = "    <item>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
        <PicUrl><![CDATA[%s]]></PicUrl>
        <Url><![CDATA[%s]]></Url>
        </item>
        ";
        $item_str = "";
        foreach ($newsArray as $item){
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);
        }
        $xmlTpl = "<xml>
        <ToUserName><![CDATA[%s]]></ToUserName>
        <FromUserName><![CDATA[%s]]></FromUserName>
        <CreateTime>%s</CreateTime>
        <MsgType><![CDATA[news]]></MsgType>
        <ArticleCount>%s</ArticleCount>
        <Articles>
        $item_str</Articles>
        </xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), count($newsArray));
        return $result;
    }

    //回复音乐消息
    private function transmitMusic($object, $musicArray)
    {
        $itemTpl = "<Music>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
        <MusicUrl><![CDATA[%s]]></MusicUrl>
        <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
        </Music>";

        $item_str = sprintf($itemTpl, $musicArray['Title'], $musicArray['Description'], $musicArray['MusicUrl'], $musicArray['HQMusicUrl']);

        $xmlTpl = "<xml>
        <ToUserName><![CDATA[%s]]></ToUserName>
        <FromUserName><![CDATA[%s]]></FromUserName>
        <CreateTime>%s</CreateTime>
        <MsgType><![CDATA[music]]></MsgType>
        $item_str
        </xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复多客服消息
    private function transmitService($object)
    {
        $xmlTpl = "<xml>
        <ToUserName><![CDATA[%s]]></ToUserName>
        <FromUserName><![CDATA[%s]]></FromUserName>
        <CreateTime>%s</CreateTime>
        <MsgType><![CDATA[transfer_customer_service]]></MsgType>
        </xml>";
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //日志记录
    private function logger($log_content)
    {
        if(isset($_SERVER['HTTP_APPNAME'])){   //SAE
            sae_set_display_errors(false);
            sae_debug($log_content);
            sae_set_display_errors(true);
        }else if($_SERVER['REMOTE_ADDR'] != "127.0.0.1"){ //LOCAL
            $max_size = 10000;
            $log_filename = "log.xml";
            if(file_exists($log_filename) and (abs(filesize($log_filename)) > $max_size)){unlink($log_filename);}
            file_put_contents($log_filename, date('H:i:s')." ".$log_content."\r\n", FILE_APPEND);
        }
    }
}
