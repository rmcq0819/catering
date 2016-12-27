<?php
namespace Home\Controller;
use Common\Controller\CommonController; 
class RemsgController extends CommonController {
   	public function rlist(){
		//获取Reserve表中的所有数据
		$r=M('Remsg');
		$where['y_state']='准备就餐';
      
		$count=$r->where($where)->count();//获取数据的总数
        $page  = new \Think\Page($count,4);
    
		$show=$page->show();//返回分页信息
		$arr=$r->where($where)->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('list',$arr);
		$this->assign('show',$show);
		$this->display();
	}


}