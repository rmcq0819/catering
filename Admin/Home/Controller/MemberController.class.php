<?php
namespace Home\Controller;
use Common\Controller\CommonController; 
class MemberController extends CommonController {


	public function mlist(){
		//获取Member表中的所有数据
		$m=M('Member');
		$where['m_exist']='1';
		$count=$m->where($where)->count();//获取数据的总数
		$page  = new \Think\Page($count,4);
		$show=$page->show();//返回分页信息
		$arr=$m->where($where)->limit($page->firstRow.','.$page->listRows)->select();

		$this->assign('list',$arr);
		$this->assign('show',$show);
		$this->display();
	}

	public function do_delete(){
		$m=M('Member');
     	$data['m_exist']='0';
     	$where['m_id']=$_GET['m_id'];
     	if($m->where($where)->save($data)){//外码约束，删除时需注意！！！
       		$this->success('删除会员信息成功',U('Member/mlist'));   
    	 }else{
       		$this->error('删除会员信息失败!');
       	}
		
	}

}