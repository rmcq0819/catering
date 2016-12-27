<?php
namespace Home\Controller;
use Common\Controller\CommonController;
use Home\Model\OrderdeskModel as Orderdesk;  
class OrderdeskController extends CommonController {
     public function modify(){
		$od=D('Orderdesk');
		$where['r_id']=$_GET['r_id'];
		$arr=$od->where($where)->select();
		$this->assign('od',$arr[0]);
		$this->display();
    }

	public function odlist(){
		//获取Orderdesk表中的所有数据
		$od=D('Orderdesk');
		$where['r_exist']='1';
		$count=$od->where($where)->count();//获取数据的总数
		$page  = new \Think\Page($count,4);
		$show=$page->show();//返回分页信息
		$arr=$od->where($where)->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('list',$arr);
		$this->assign('show',$show);
		$this->display();
	}
	public function search(){
		$condi=$_GET['condi'];
		if($condi=='1'){
			$where['r_state']='已入座';
		}
		if($condi=='2'){
			$where['r_state']='开始点餐';
		}
		if($condi=='3'){
			$where['r_state']='用餐毕';
		}
		$od=D('Orderdesk');
		$count=$od->where($where)->count();//获取数据的总数
		$page  = new \Think\Page($count,4);
		$show=$page->show();//返回分页信息
		$arr=$od->where($where)->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('list',$arr);
		$this->assign('show',$show);
		$this->assign('condi',$condi);
		$this->display('odlist');
	}
	public function do_delete(){
		$od=D('Orderdesk');
     	$data['r_exist']='0';
     	$where['r_id']=$_GET['r_id'];
		$ret=$od->where($where)->find();		
		$b_time=$ret['r_time'];	
     	$ddata[$b_time]='0';
		$wh['b_id']=$ret['b_id'];
		$d=M('Desk');
		
		$ret3=$d->where($wh)->save($ddata);//餐桌状态置为空闲
     	if($od->where($where)->save($data)){//外码约束，删除时需注意！！！
       		$this->success('删除订单餐桌记录成功',U('Orderdesk/odlist'));   
    	 }else{
       $this->error('删除订单餐桌记录失败!');
       }
		
	}
	public function do_modify(){
		$od=D('Orderdesk');
		if(!$od->create()){//自动创建
			$this->error($od->getError());
		}
		$lastId=$od->save();

		if($lastId){
			$this->success('修改订单餐桌记录成功',U('Orderdesk/odlist'));
		}else{
			$this->error('修改订单餐桌记录失败！');
		}


	}
}