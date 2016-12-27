<?php
namespace Home\Controller;
use Common\Controller\CommonController;
use Home\Model\DeskModel as Desk;  
class DeskController extends CommonController {
    public function add(){
		$this->display();
    }
     public function modify(){
		$d=D('Desk');
		$where['b_id']=$_GET['b_id'];
		$arr=$d->where($where)->select();
		$this->assign('d',$arr[0]);
		$this->display();
    }
    public function dlist(){
		//获取Desk表中的所有数据
		$d=D('Desk');
		$where['b_exist']='1';
		$count=$d->where($where)->count();//获取数据的总数
		$page  = new \Think\Page($count,4);
		$show=$page->show();//返回分页信息
		$arr=$d->where($where)->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('list',$arr);
		$this->assign('show',$show);
		$this->display();
	}
    public function checkId(){
		$b_id=$_GET['b_id'];
		if(!preg_match('/^\d{2}$/',$b_id)){
			echo "超界";
		}else{
			$d=M('Desk');
			$where['b_id']=$b_id;
			$count=$d->where($where)->count();
			if($count){
				echo '已存在';
			}else{
				echo '允许';
			}
		}	
	}

	public function do_add(){
		$d=D('Desk');

		if(!$d->create()){//自动创建
			$this->error($d->getError());
		}
		$lastId=$d->add();
		if($lastId){
			$this->success('添加餐桌信息成功！');
		}else{
			$this->error('添加餐桌信息失败！');
		}

	}



	public function do_delete(){
		$d=D('Desk');
     	$data['b_exist']='0';
     	$where['b_id']=$_GET['b_id'];
     	if($d->where($where)->save($data)){//外码约束，删除时需注意！！！
       		$this->success('删除餐桌信息成功',U('Desk/dlist'));   
    	 }else{
       $this->error('删除餐桌信息失败!');
       }
		
	}
	public function do_modify(){
		$d=D('Desk');
		if(!$d->create()){//自动创建
			$this->error($d->getError());
		}
		$lastId=$d->save();
		if($lastId){
			$this->success('修改餐桌信息成功',U('Desk/dlist'));
		}else{
			$this->error('修改餐桌信息失败！');
		}


	}
}