<?php
namespace Home\Controller;
use Common\Controller\CommonController;
use Home\Model\OrdersModel as Orders;  
class OrdersController extends CommonController {
	public function odrecord(){
		$w=M('Waiter');
		$arr=$w->select();
		$this->assign('list',$arr);
		$where['y_content']=$_GET['y_content'];
		$rm=D('Remsg');
		$ret=$rm->where($where)->find();
		$this->assign('rm',$ret);
		$this->display();
	}

public function search(){
		$condi=$_GET['condi'];
		if($condi=='1'){
			$where['o_state']='已结';
		}
		if($condi=='2'){
			$where['o_state']='未结';
		}
		$o=D('Orders');
		$count=$o->where($where)->count();//获取数据的总数
        $page  = new \Think\Page($count,4);
		$show=$page->show();//返回分页信息
		$arr=$o->where($where)->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('list',$arr);
		$this->assign('show',$show);
		$this->assign('condi',$condi);
		$this->display('olist');
	}
	public function get_odlist(){

		$y_openid=$_POST['y_openid'];
		$n_id=$_POST['n_id'];
		$r=D('Reserve');
		
		$where['n_id']=$n_id;
		$arr1=$r->where($where)->select();
		if(empty($arr1)){
			$remsg=M('Remsg');
			$rwhere['y_content']=$n_id;
			$remsg->where($rwhere)->delete();
			$access_token=$this->get_access_token();
			$url ="https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$access_token;
			
			$formUserName =$y_openid;
			$content ='该预定单号不存在!';
			$content_code = urlencode($content);
			$post_text_arr = array(
					"touser"=>"{$formUserName}",
					"msgtype"=>"text",
					"text"=>array("content"=>"{$content_code}")
				);

			$post_text_json = json_encode($post_text_arr);
			$post_text_json = urldecode($post_text_json);//解码
			$this->https_request($url,$post_text_json);
			$this->error('该预定单号不存在！',U('Remsg/rlist'));
		}
		$where['n_state']='预定成功';
		
		$arr2=$r->where($where)->select();
		if(empty($arr2)){
			$remsg=M('Remsg');
			$rwhere['y_content']=$n_id;
			$remsg->where($rwhere)->delete();
			$access_token=$this->get_access_token();
			$url ="https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$access_token;
			
			$formUserName =$y_openid;
			$content ='该预定单号已经生成订单！';
			$content_code = urlencode($content);
			$post_text_arr = array(
					"touser"=>"{$formUserName}",
					"msgtype"=>"text",
					"text"=>array("content"=>"{$content_code}")
				);

			$post_text_json = json_encode($post_text_arr);
			$post_text_json = urldecode($post_text_json);//解码
			$this->https_request($url,$post_text_json);
			$this->error('该预定单号已经生成订单！',U('Remsg/rlist'));
		}
		$rd=M('Reservedesk');
		$rdwhere['n_id']=$n_id;
		$arr3=$rd->where($rdwhere)->select();

		$o_id=$this->getId();
		$_SESSION['o_id']=$o_id;

		$mwhere['m_openid']=$y_openid;
		$member=M('Member');
		$mem=$member->where($mwhere)->find();
		if(!$mem){
			$mem['m_id']='9999999999999999';
		}
		$od=M('Orderdesk');
		$o=D('Orders');
		$odata['o_id']=$o_id;
		dump($arr1);
		$odata['o_deposit']=$arr1[0]['n_money'];
		$odata['m_id']=$mem['m_id'];
		$odata['w_id']=$_POST['w_id'];
		$odata['o_time']=$this->getReservetime();
		$odata['o_number']=$arr1[0]['n_usernumber'];
		$odata['o_amount']='0';
		$odata['o_discount']='0';
		$odata['o_exist']='1';
		$odata['o_receivable']='0';
		$odata['o_received']='0';
		$odata['o_integral']='0';
		$odata['o_etime']=$this->getReservetime();
		$odata['o_state']='未结';
		$o->startTrans();//启用事物

		$ret3=$o->add($odata);

		
		$redata['n_state']='订单生成';
		$ret1=$r->where($where)->save($redata);
		
		$oddata['o_id']=$o_id;
		$oddata['r_amount']='0';
		$oddata['r_disamount']='0';
		$oddata['r_state']='已入座';
		$ret2=true;


		foreach($arr3 as $key=>$value){
			//dump($value);
			$oddata['b_id']=$value['b_id'];
			$oddata['r_time']=$_POST['y_usetime'];
			$oddata['r_id']=$this->getId();
			$oddata['r_exist']='1';
			$ret=$od->add($oddata);
			if(!$ret){
				$ret2=false;
			}
		}

		$remsg=M('Remsg');
		$remsgdata['y_state']='订单生成';
		$remsgwhere['y_content']=$n_id;
        $ret4=$remsg->where($remsgwhere)->save($remsgdata);

		if($ret1&&$ret2&&$ret3&&$ret4){
			
			$o->commit();
			$this->success('餐桌条目生成成功！',U('odlist?y_openid='.$y_openid));
		}else{
		
			$o->rollback();
			$this-error('失败！');
		}
	}

		public function odlist(){
			$od=M('Orderdesk');
			$where['o_id']=$_SESSION['o_id'];
			$where['r_state']='已入座';
			$arr=$od->where($where)->select();
			//dump($arr);
			$this->assign('list',$arr);
			$this->display();
	}
   	public function getId(){
			$dt=date('YmdHis');
			$rd=rand(10,99);
			$n_id=$dt."".$rd;
			$_SESSION['n_id']=$n_id;
			return $n_id;
	}
	public function getReservetime(){
		$dt=date('Y-m-d H:i:s');
		return $dt;
	}
     public function modify(){
		$o=D('Orders');
		$where['o_id']=$_GET['o_id'];
		$arr=$o->where($where)->select();
		$this->assign('o',$arr[0]);
		$this->display();
    }
	public function olist(){
		//获取Orders表中的所有数据
		$o=D('Orders');
		$where['o_exist']='1';
		$count=$o->where($where)->count();//获取数据的总数
		$page  = new \Think\Page($count,4);
 
		$show=$page->show();//返回分页信息
		$arr=$o->where($where)->relation(true)->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('list',$arr);
		$this->assign('show',$show);
		$this->display();
	}

	public function do_delete(){
		$o=D('Orders');
     	$data['o_exist']='0';
     	$where['o_id']=$_GET['o_id'];
     	if($o->where($where)->save($data)){//外码约束，删除时需注意！！！
       		$this->success('删除订单信息成功',U('olist'));   
    	 }else{
       $this->error('删除订单信息失败!');
       }
		
	}
	public function do_modify(){
		$o=D('Orders');
		if(!$o->create()){//自动创建
			$this->error($o->getError());
		}
		$lastId=$o->save();
		if($lastId){
			$this->success('修改订单信息成功',U('Orders/olist'));
		}else{
			$this->error('修改订单信息失败！');
		}


	}
	public function do_send(){

		$od=M('Orderdesk');
		$where['o_id']=$_SESSION['o_id'];
		$where['r_state']='已入座';
		$arr=$od->where($where)->select();
		$str='您的订单号为：'.$_SESSION['o_id'].'  点餐码分别为：';
		foreach($arr as $key=>$value){
			$str=$str.'  '.$value['r_id'];
		}
		$str=$str.'每桌输入一条可以开始点餐，祝您用餐愉快！';
		
		$access_token=$this->get_access_token();
		$url ="https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$access_token;
		
		$formUserName =$_GET['y_openid'];
		$content =$str;
		$content_code = urlencode($content);
		$post_text_arr = array(
				"touser"=>"{$formUserName}",
				"msgtype"=>"text",
				"text"=>array("content"=>"{$content_code}")
			);

		$post_text_json = json_encode($post_text_arr);
		$post_text_json = urldecode($post_text_json);//解码
		$this->https_request($url,$post_text_json);
		dump($access_token);
		dump($url);
		dump($content);
		dump($formUserName);
		$this->redirect('Reserve/rlist');
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