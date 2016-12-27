<?php
namespace Home\Controller;
use Think\Controller;  
class DeskController extends Controller {
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
}