<?php
namespace Home\Controller;
use Common\Controller\CommonController;
use Home\Model\ReserveModel as Reserve;  
class ReserveController extends CommonController {
     public function modify(){
		$r=D('Reserve');
		$where['n_id']=$_GET['n_id'];
		$arr=$r->where($where)->select();
		$this->assign('r',$arr[0]);
		$this->display();
    }

   	public function rlist(){
		//获取Reserve表中的所有数据
		$r=D('Reserve');
		$count=$r->count();//获取数据的总数
        $page  = new \Think\Page($count,4);
		$show=$page->show();//返回分页信息
		$arr=$r->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('list',$arr);
		$this->assign('show',$show);
		$this->display();
	}
 

	public function search(){
		$condi=$_GET['condi'];
		if($condi=='1'){
			$where['n_state']='订单生成';
		}
		if($condi=='2'){
			$where['n_state']='预订成功';
		}
		$r=D('Reserve');
		$count=$r->where($where)->count();//获取数据的总数
        $page  = new \Think\Page($count,4);
		$show=$page->show();//返回分页信息
		$arr=$r->where($where)->where($where)->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('list',$arr);
		$this->assign('show',$show);
		$this->assign('condi',$condi);
		$this->display('rlist');
	}

	public function do_delete(){
		$r=D('Reserve');
		$r->startTrans();
		$where['n_id']=$_GET['n_id'];

		$reserve=$r->where($where)->find();
		if($reserve['n_state']=='订单生成'){
			$this->error('订单已生成，不允许删除');
		}
		$b_time=$reserve['n_usetime'];
		$ddata[$b_time]='0';
		$rd=M('Reservedesk');
		$arr=$rd->where($where)->select();


		$d=M('Desk');
		$ret1=true;
		foreach ($arr as $key => $value) {
			$wh['b_id']=$arr[$key]['b_id'];
			$r1=$d->where($wh)->save($ddata);//餐桌状态置为空闲
			if(!$r1){
				$ret1=false;
			}
		}
		$ret3=true;
		$arrs=$rd->where($where)->select();
		if($arrs){
			$ret3=$rd->where($where)->delete();//删除预定餐桌记录
		}
		
		$ret2=$r->where($where)->delete();//删除预订信息
	
     	if($ret1&&$ret2&&$ret3){
     		
			$r->commit();
       		$this->success('删除预定信息成功',U('Reserve/rlist'));   
    	 }else{
    	 	$r->rollback();
       		$this->error('删除预定信息失败!');
       }
		
	}
	public function do_modify(){
		$r=D('Reserve');
		if(!$r->create()){//自动创建
			$this->error($r->getError());
		}
		$lastId=$r->save();
		if($lastId){
			$this->success('修改预定信息成功',U('Reserve/rlist'));
		}else{
			$this->error('修改预定信息失败！');
		}


	}
}