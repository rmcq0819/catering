<?php
namespace Home\Controller;
use Think\Controller;
class WaiterController extends Controller {
    public function do_waiter(){
    	$w=M('Waiter');
    	$where['w_state']='空闲';
		$waiter=$w->limit(1)->where($where)->select();
		
		if($waiter){
			$wh['r_id']=$_GET['r_id'];
			$od=M('Orderdesk');
			$ret=$od->where($wh)->find();

			$data['w_state']='忙碌';
			$data['w_desk']=$ret['b_id'];

			$whe['w_id']=$waiter[0]['w_id'];
			$w->where($whe)->save($data);
			echo '服务员'.$waiter[0]['w_name'].'即将为您服务';
		}else{
			echo '由于人流量大，当前没有服务员处于空闲状态，请稍后再呼叫。感谢您对配合！';
		}
		
		
    }
}