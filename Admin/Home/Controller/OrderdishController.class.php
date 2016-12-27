<?php
namespace Home\Controller;
use Common\Controller\CommonController;
use Home\Model\OrderdishModel as Orderdish;  
class OrderdishController extends CommonController {
     public function modify(){
		$od=D('Orderdish');
		$odhere['u_id']=$_GET['u_id'];
		$arr=$od->where($odhere)->select();
		$this->assign('od',$arr[0]);
		$this->display();
    }
	public function odlist(){
		//获取Orderdish表中的所有数据
		$od=D('Orderdish');

		$count=$od->count();//获取数据的总数
		$page  = new \Think\Page($count,4);
		$show=$page->show();//返回分页信息
		$arr=$od->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('list',$arr);
		$this->assign('show',$show);
		$this->display();
	}
	public function search(){
		$condi=$_GET['condi'];
		if($condi=='1'){
			$where['u_state']='已点';
		}
		if($condi=='2'){
			$where['u_state']='已开始做';
		}
		if($condi=='3'){
			$where['u_state']='已上桌';
		}
		$od=D('Orderdish');
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
		$od=D('Orderdish');
     	if($od->delete($_GET['u_id'])){
       		$this->success('删除餐桌菜品记录成功',U('Orderdish/odlist'));   
    	 }else{
       $this->error('删除餐桌菜品记录失败!');
       }
		
	}
	public function do_modify(){
		$od=D('Orderdish');
		if(!$od->create()){//自动创建
			$this->error($od->getError());
		}
		$lastId=$od->save();
		if($lastId){
			$this->success('修改餐桌菜品记录成功',U('Orderdish/odlist'));
		}else{
			$this->error('修改餐桌菜品记录失败！');
		}
	}
}