<?php
namespace Home\Controller;
use Common\Controller\CommonController;
use Home\Model\DishesModel as Dishes;  
class DishesController extends CommonController {
    public function add(){
    	$cf=D('Classfication');
		$arr=$cf->select();
		$this->assign('list',$arr);
		$this->display();
    }
     public function modify(){
		$d=D('Dishes');
		$where['d_id']=$_GET['d_id'];
		$arr=$d->where($where)->select();

		$cf=D('Classfication');
		$carr=$cf->select();
		$this->assign('list',$carr);
		$this->assign('d',$arr[0]);
		$this->display();
    }
    public function checkId(){
		$d_id=$_GET['d_id'];
		if(!preg_match('/^\d{6}$/',$d_id)){
			echo "超界";
		}else{
			$d=D('Dishes');
			$where['d_id']=$d_id;
			$count=$d->where($where)->count();
			if($count){
				echo '已存在';
			}else{
				echo '允许';
			}
		}	
	}
	public function dlist(){
		//获取Dishes表中的所有数据
		$d=D('Dishes');
		$where['d_exist']='1';

		$count=$d->where($where)->count();//获取数据的总数
		$page  = new \Think\Page($count,4);
		$show=$page->show();//返回分页信息
		$arr=$d->where($where)->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('list',$arr);
		$this->assign('show',$show);
		$this->display();
	}
	public function do_add(){
		$d=D('Dishes');

		if(!$d->create()){//自动创建
			$this->error($d->getError());
		}

		$lastId=$d->add();

		if($lastId){
			$this->success('添加菜品信息成功！');
		}else{
			$this->error('添加菜品信息失败！');
		}

	}


	public function search(){
		$condi=$_GET['condi'];
		if($condi=='1'){
			$where['d_new']=1;
		}
		if($condi=='2'){
			$where['d_hot']=1;
		}
		$d=D('Dishes');
		$count=$d->where($where)->count();//获取数据的总数
		$page  = new \Think\Page($count,4);
		$show=$page->show();//返回分页信息
		$arr=$d->where($where)->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('list',$arr);
		$this->assign('show',$show);
		$this->assign('condi',$condi);
		$this->display('dlist');
	}
	public function do_delete(){
		$d=D('Dishes');
     	$data['d_exist']='0';
     	$where['d_id']=$_GET['d_id'];
     	if($d->where($where)->save($data)){//外码约束，删除时需注意！！！
       		$this->success('删除菜品信息成功',U('Dishes/dlist'));   
    	 }else{
       		$this->error('删除菜品信息失败!');
       }
		
	}
	public function do_modify(){
		$d=D('Dishes');
		if(!$d->create()){//自动创建
			$this->error($d->getError());
		}
		$lastId=$d->save();
		if($lastId){
			$this->success('修改菜品信息成功',U('Dishes/dlist'));
		}else{
			$this->error('修改菜品信息失败！');
		}


	}
}