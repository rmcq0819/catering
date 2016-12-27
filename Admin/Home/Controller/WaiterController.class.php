<?php
namespace Home\Controller;
use Common\Controller\CommonController;
use Home\Model\WaiterModel as Waiter;  
class WaiterController extends CommonController {
    public function add(){
		$this->display();
    }
     public function modify(){
		$w=D('Waiter');
		$where['w_id']=$_GET['w_id'];
		$arr=$w->where($where)->select();
		$this->assign('w',$arr[0]);
		$this->display();
    }
   	public function wlist(){
		//获取Waiter表中的所有数据
		$w=D('Waiter');
		$where['w_exist']='1';
		$count=$w->where($where)->count();//获取数据的总数
		$page  = new \Think\Page($count,4);
		$show=$page->show();//返回分页信息
		$arr=$w->where($where)->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('list',$arr);
		$this->assign('show',$show);
		$this->display();
	}
    public function checkId(){
		$w_id=$_GET['w_id'];
		if(!preg_match('/^\d{6}$/',$w_id)){
			echo "超界";
		}else{
			$w=M('Waiter');
			$where['w_id']=$w_id;
			$count=$w->where($where)->count();
			if($count){
				echo '已存在';
			}else{
				echo '允许';
			}
		}	
	}

	public function do_add(){
		$w=D('Waiter');

		if(!$w->create()){//自动创建
			$this->error($w->getError());
		}
		$lastId=$w->add();
		if($lastId){
			$this->success('添加服务员信息成功！');
		}else{
			$this->error('添加服务员信息失败！');
		}

	}
	public function release(){
		$w=D('Waiter');
		$where['w_id']=$_GET['w_id'];
		$data['w_state']='空闲';
     	$data['w_desk']=NULL;
     	if($w->where($where)->save($data)){//外码约束，删除时需注意！！！
       		$this->success('成功',U('Waiter/wlist'));   
    	}else{
       		$this->error('失败!');
       }
	}

	public function search(){
		$condi=$_GET['condi'];
		if($condi=='1'){
			$where['w_state']='忙碌';
		}
		if($condi=='2'){
			$where['w_state']='空闲';
		}
		$w=D('Waiter');
		$count=$w->where($where)->count();//获取数据的总数
		$page  = new \Think\Page($count,4);
		$show=$page->show();//返回分页信息
		$arr=$w->where($where)->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('list',$arr);
		$this->assign('show',$show);
		$this->assign('condi',$condi);
		$this->display('wlist');
	}

	public function do_delete(){
		$w=D('Waiter');
     	$data['w_exist']='0';
     	$where['w_id']=$_GET['w_id'];
     	if($w->where($where)->save($data)){//外码约束，删除时需注意！！！
       		$this->success('删除服务员信息成功',U('Waiter/wlist'));   
    	 }else{
       $this->error('删除服务员信息失败!');
       }
		
	}
	public function do_modify(){
		$w=D('Waiter');
		if(!$w->create()){//自动创建
			$this->error($w->getError());
		}
		$lastId=$w->save();
		if($lastId){
			$this->success('修改服务员信息成功',U('Waiter/wlist'));
		}else{
			$this->error('修改服务员信息失败！');
		}
	}
}