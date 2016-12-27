<?php
namespace Home\Controller;
use Think\Controller; 
class MemberController extends Controller{
    public function modify(){
		
		$this->display();
    }

	
	public function do_modify(){
		$m=M('Member');
		$where['m_id']=$_POST['m_id'];
		$data['m_email']=$_POST['m_email'];
		
		$lastId=$m->where($where)->save($data);
		if($lastId){
			$this->success('修改会员信息成功！');
		}else{
			$this->error('修改会员信息失败！');
		}
	}
}