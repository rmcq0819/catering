<?php
namespace Home\Controller;
use Think\Controller; 
class DescriptionController extends Controller {
	public function description(){
		$this->display();
	}
   public function wel(){
		$this->display();
    }
	public function dishesIndex(){
		$cf=M('Classfication');
		$where['c_exist']='1';
		$arr=$cf->where($where)->select();
		$this->assign('list',$arr);
		$this->display();
	}
	public function deskInfo(){
		$d=M('Desk');
		$where['b_exist']='1';
		$count=$d->where($where)->count();//获取数据的总数
		$page = new \Think\Page($count,2);
		$show=$page->show();//返回分页信息
		$arr=$d->where($where)->limit($page->firstRow.','.$page->listRows)->select();;
		$this->assign('list',$arr);
		$this->assign('show',$show);
		$this->display();
	}
	public function dishesInfo(){
		$d=M('Dishes');
		$c_id=$_GET['c_id'];
		$where['c_id']=$c_id;
		$where['d_exist']='1';
		$count=$d->where($where)->count();//获取数据的总数
		$page  = new \Think\Page($count,4);
		$show=$page->show();//返回分页信息
		$arr=$d->where($where)->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('list',$arr);
		$this->assign('show',$show);
		$this->assign('c_id',$c_id);
		$this->display();
	}

		public function recent(){
		$d=M('Dishes');
		$where['d_new']='1';
		$where['d_exist']='1';
		$count=$d->where($where)->count();//获取数据的总数
		$page  = new \Think\Page($count,4);
		$show=$page->show();//返回分页信息
		$arr=$d->where($where)->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('list',$arr);
		$this->assign('show',$show);
		$this->display();
	}
	public function hot(){
		$d=M('Dishes');
		$where['d_hot']='1';
		$where['d_exist']='1';
		$count=$d->where($where)->count();//获取数据的总数
		$page  = new \Think\Page($count,4);
		$show=$page->show();//返回分页信息
		$arr=$d->where($where)->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('list',$arr);
		$this->assign('show',$show);
		$this->display();
	}
	public function search(){
		$condi=$_GET['condi'];
		$c_id=$_GET['c_id'];
		$where['c_id']=$c_id;
		$where['d_exist']='1';
		$where['d_name']=array('like','%'.$condi.'%');
		$d=M('Dishes');
		$count=$d->where($where)->count();//获取数据的总数
		$page  = new \Think\Page($count,4);
		$show=$page->show();//返回分页信息
		$arr=$d->where($where)->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('list',$arr);
		$this->assign('show',$show);
		$this->assign('condi',$condi);
		$this->assign('c_id',$c_id);
		$this->display('dishesInfo');
	}
	public function search_new(){
		$condi=$_GET['condi'];
		$where['d_new']='1';
		$where['d_exist']='1';
		$where['d_name']=array('like','%'.$condi.'%');
		$d=M('Dishes');
		$count=$d->where($where)->count();//获取数据的总数
		$page  = new \Think\Page($count,4);
		$show=$page->show();//返回分页信息
		$arr=$d->where($where)->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('list',$arr);
		$this->assign('show',$show);
		$this->assign('condi',$condi);
		$this->display('recent');
	}
		public function search_hot(){
		$condi=$_GET['condi'];
		$where['d_exist']='1';
		$where['d_hot']='1';
		$where['d_name']=array('like','%'.$condi.'%');
		$d=M('Dishes');
		$count=$d->where($where)->count();//获取数据的总数
		$page  = new \Think\Page($count,4);
		$show=$page->show();//返回分页信息
		$arr=$d->where($where)->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('list',$arr);
		$this->assign('show',$show);
		$this->assign('condi',$condi);
		$this->display('hot');
	}

}