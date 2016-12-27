<?php
namespace Home\Controller;
use Common\Controller\CommonController; 
class ReservedeskController extends CommonController {


	public function rdlist(){
		//获取Reservedesk表中的所有数据
		$rd=M('Reservedesk');
		$count=$rd->count();//获取数据的总数
        $page  = new \Think\Page($count,4);
		$show=$page->show();//返回分页信息
		$arr=$rd->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('list',$arr);
		$this->assign('show',$show);
		$this->display();
	}

	public function do_delete(){
		$rd=M('Reservedesk');
		$rd->startTrans();
		$rwhere['n_id']=$_GET['n_id'];
		$rdwhere['v_id']=$_GET['v_id'];

		$r=M('Reserve');
		$reserve=$r->where($rwhere)->find();
		if($reserve['n_state']=='订单生成'){
			$this->error('订单已生成，不允许删除');
		}
		$b_time=$reserve['n_usetime'];
		$reservedesk=$rd->where($rdwhere)->find();

		$ddata[$b_time]='0';
		$wh['b_id']=$reservedesk['b_id'];
		$d=M('Desk');
		
		$ret3=$d->where($wh)->save($ddata);//餐桌状态置为空闲
		$ret1=$rd->where($rdwhere)->delete();
	
		$arr=$rd->where($rwhere)->select();
		$ret2=true;
		if(!$arr){
			$r=M('Reserve');
			$ret2=$r->where($rwhere)->delete();
		}

     	if($ret1&&$ret2&&$ret3){
     		$rd->commit();
       		$this->success('删除预定餐桌记录成功',U('Reservedesk/rdlist'));   
    	}else{
    	 	$rd->rollback();
       		$this->error('删除预定餐桌记录失败!');
        }
		
	}

}