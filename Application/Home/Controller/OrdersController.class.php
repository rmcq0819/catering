<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\OrdersModel as Orders;  
class OrdersController extends Controller {
	
	public function orderlist(){
		$o_id=$_GET['o_id'];
		$where['o_id']=$o_id;
		$where['r_exist']='1';
		$od=M('Orderdesk');
		
		$arr=$od->where($where)->select();
		$data['o_amount']='0';
		$data['o_disamount']='0';
		$data['o_tablenumber']='0';
		foreach ($arr as $key=>$value){
			$data['o_amount']+=$value['r_amount'];
			$data['o_discount']+=$value['r_disamount'];
			$data['o_tablenumber']+=1;

		}
		$data['o_etime']=date('Y-m-d H:i:s');
		$o=M('Orders');
		$ret=$o->where($where)->select();

		$data['o_receivable']=$data['o_discount']-$ret[0]['o_deposit'];
		$result=$o->where($where)->save($data);
		if($result){
			$this->assign('list',$arr);
			$this->assign('o_id',$o_id);
			$this->assign('o_deposit',$ret[0]['o_deposit']);
			$this->assign('o_receivable',$data['o_receivable']);
			$this->display();
		}else{
			$this->error('失败！');
		}
		
	}

		public function do_end(){
		$o=M('Orders');
		$o->startTrans();
		$o_id=$_GET['o_id'];

		$wh['o_state']='已结';//是否已结
		$wh['o_id']=$o_id;

		$acc=$o->where($wh)->count();
		
		if($acc>0){

			$this->error('该订单已结清！',U('Description/description'));
		}
		$o_received=$_GET['o_received'];
		$data['o_received']=$o_received;
		$data['o_etime']=date('Y-m-d H:i:s');

		$owh['o_id']=$o_id;
		$ord=$o->where($owh)->find();
		dump($ord);
		$data['o_integral']=$ord['o_amount'];

		$od=M('Orderdesk');
		$rwh['o_id']=$o_id;
		$rwh['r_exist']='1';
		$arr=$od->where($rwh)->select();
		foreach ($arr as $key=>$value){
			if($value['r_state']!='用餐毕')
			{
				$this->error('还有餐桌没有结束用餐！');
			}
		}
	
		$data['o_state']='已结';
		$ret=$o->where($owh)->save($data);
		$ret2=true;
		if($ord['m_id']!='9999999999999999'){
			$m=M('Member');
			$where['m_id']=$ord['m_id'];
			$mem=$m->where($where)->find();
			if($mem){
				$mdata['m_amount']=$mem['m_amount']+$ord['o_amount'];
				$mdata['m_account']=$mem['m_account']+1;
				$mdata['m_integral']=$mem['m_integral']+$ord['o_amount'];
				$mdata['m_grade']= floor($mdata['m_integral']/100);
				$ret2=$m->where($where)->save($mdata);
				$orders=$o->where($wh)->find();
				$access_token=$this->get_access_token();
				$url ="https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$access_token;
				
				$formUserName =$mem['m_openid'];
				$content ='欢迎下次光临!您本次消费：￥'.$orders['o_amount'].'；折后消费：￥'.$orders['o_discount'].'；本次积分：'.$orders['o_amount'];
				$content_code = urlencode($content);
				$post_text_arr = array(
						"touser"=>"{$formUserName}",
						"msgtype"=>"text",
						"text"=>array("content"=>"{$content_code}")
					);

				$post_text_json = json_encode($post_text_arr);
				$post_text_json = urldecode($post_text_json);//解码
				$this->https_request($url,$post_text_json);
			}
		}
		
		if($ret&&$ret2){
			$o->commit();
			$this->redirect('Description/description');
		}else{
			$o->rollback();
			$this->error('失败！');
		}
	}



	public function do_euse(){
		$where['r_id']=$_GET['r_id'];
		$o_id=$_GET['o_id'];
		$od=M('Orderdesk');
		$od->startTrans();
		$data['r_state']='用餐毕';
		$ret1=$od->where($where)->save($data);
		$ret=$od->where($where)->select();

		$where['b_id']=$ret[0]['b_id'];
		$b_time=$ret[0]['r_time'];
		$d=M('Desk');
		$ddata[$b_time]='0';
		$ret2=$d->where($where)->save($ddata);
		if($ret1&&$ret2){
			$od->commit();
			$this->redirect('orderlist?o_id='.$o_id);
		}else{
			$od->rollback();
			$this->error('操作失败！');
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
}