<?php
namespace Home\Controller;
use Think\Controller; 
class DishesController extends Controller {
	public function dishesIndex(){

    	$r_id=$_GET['r_id'];
    	//获取classfication表中的有数据	
		$od=M('Orderdesk');

		$where['r_id']=$r_id;
		$data['r_state']='点餐中';
		$od->where($where)->save($data);



		$cf=M('Classfication');
		$cfwh['c_exist']='1';
		$arr=$cf->where($cfwh)->select();
		$this->assign('list',$arr);
		$this->assign('r_id',$r_id);
		$this->display();
    }
    public function wel(){
		$this->display();
    }
	public function dishesInfo(){
		$d=M('Dishes');
		$c_id=$_GET['c_id'];
		$where['c_id']=$c_id;
		$where['d_exist']='1';
		$r_id=$_GET['r_id'];
		
		$count=$d->where($where)->count();//获取数据的总数
		$page  = new \Think\Page($count,4);
		$show=$page->show();//返回分页信息
		$arr=$d->where($where)->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('list',$arr);
		$this->assign('show',$show);
		$this->assign('r_id',$r_id);
		$this->assign('c_id',$c_id);
		$this->display();
	}

	public function recent(){
		$d=M('Dishes');
		$where['d_new']='1';
		$where['d_exist']='1';
		$r_id=$_GET['r_id'];
		
		$count=$d->where($where)->count();//获取数据的总数
		$page  = new \Think\Page($count,4);
		$show=$page->show();//返回分页信息
		$arr=$d->where($where)->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('list',$arr);
		$this->assign('show',$show);
		$this->assign('r_id',$r_id);
		$this->display();
	}
	public function hot(){
		$d=M('Dishes');
		$where['d_hot']='1';
		$where['d_exist']='1';
		$r_id=$_GET['r_id'];
		
		$count=$d->where($where)->count();//获取数据的总数
		$page  = new \Think\Page($count,4);
		$show=$page->show();//返回分页信息
		$arr=$d->where($where)->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('list',$arr);
		$this->assign('show',$show);
		$this->assign('r_id',$r_id);
		$this->display();
	}

	public function do_modify(){
		$where['u_id']=$_GET['u_id'];
		$od=M('Orderdish');
		$od->startTrans();//启用事物
		$orderdish=$od->where($where)->find();
		$data['u_account']=$_GET['u_account'];;
		$data['u_amount']=$data['u_account']*$orderdish['u_price'];
		$data['u_disamount']=$data['u_account']*$orderdish['u_disprice'];
		$ret1=$od->where($where)->save($data);

		$rid['r_id']=$_GET['r_id'];
		$arr=$od->where($rid)->select();
		$vdata['r_amount']='0';
		$vdata['r_disamount']='0';

		foreach ($arr as $key=>$value){
			$vdata['r_amount']+=$value['u_amount'];
			$vdata['r_disamount']+=$value['u_disamount'];
		}
		$orderdesk=M('Orderdesk');
		$ret2=$orderdesk->where($rid)->save($vdata);
	
		if($ret1&&$ret2){
			$od->commit();
			echo '成功';
		}else{
			$od->rollback();
			echo '失败';
		}
	}

	public function dishesOrder(){//点餐入口
		$this->display();
	}
	public function add_dishes(){//点菜
		$d_id=$_GET['d_id'];
		$r_id=$_GET['r_id'];
		$u_flavor=$_GET['u_flavor'];
		$where['d_id']=$d_id;
		$where['r_id']=$r_id;
		$od=M('Orderdish');

		$d=M('Dishes');//获得菜品信息

		$od->startTrans();
		$orderdish=$od->where($where)->find();
		if($orderdish){//已存在，则数量加1
			$data['u_account']=$orderdish['u_account']+1;
			$data['u_amount']=$data['u_account']*$orderdish['u_price'];
			$data['u_disamount']=$data['u_account']*$orderdish['u_disprice'];
			$ret1=$od->where($where)->save($data);
		}else{//不存在，则添加
			$dish=$d->where($where)->find();
			$u_id=$this->getId();
			$data['u_id']=$u_id;
			$data['d_id']=$d_id;
			$data['r_id']=$r_id;
			$data['u_flavor']=$u_flavor;
			$data['u_dish']=$dish['d_name'];
			$data['u_price']=$dish['d_price'];
			$data['u_disprice']=$dish['d_disprice'];
			$data['u_account']=1;
			$data['u_urgent']=0;
			$data['u_amount']=$data['u_account']*$data['u_price'];
			$data['u_disamount']=$data['u_account']*$data['u_disprice'];
			$data['u_state']='已点';	
			$ret1=$od->add($data);
		}

		$rid['r_id']=$r_id;
		$arr=$od->where($rid)->select();
		$vdata['r_amount']=0;
		$vdata['r_disamount']=0;

		foreach ($arr as $key=>$value){
			$vdata['r_amount']+=$value['u_amount'];
			$vdata['r_disamount']+=$value['u_disamount'];
		}

		$orderdesk=M('Orderdesk');
		$ret2=$orderdesk->where($rid)->save($vdata);
		if($ret1&&$ret2){
			$od->commit();
			echo '成功';
		}else{
			$od->rollback();
			echo '失败';
		}
	}


	public function getId(){
			$dt=date('YmdHis');
			$rd=rand(10,99);
			$n_id=$dt."".$rd;
			$_SESSION['n_id']=$n_id;
			return $n_id;
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
		$this->assign('r_id',$_GET['r_id']);
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
		$this->assign('r_id',$_GET['r_id']);
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
		$this->assign('r_id',$_GET['r_id']);
		$this->display('hot');
	}
	public function odlist(){//查看已点
		$r_id=$_GET['r_id'];

		$where['r_id']=$r_id;
		$od=M('Orderdish');

		$count=$od->where($where)->count();//获取数据的总数
		$page  = new \Think\Page($count,4);
		$show=$page->show();//返回分页信息
		$arr=$od->where($where)->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('list',$arr);
		$this->assign('show',$show);
		$this->assign('r_id',$r_id);

		$orderdesk=M('Orderdesk');
		$ret=$orderdesk->where($where)->select();
		$o_id=$ret[0]['o_id'];
		$arr=$od->where($where)->select();
		$amount=0;
		$disamount=0;

		foreach ($arr as $key=>$value){
			$amount+=$value['u_amount'];
			$disamount+=$value['u_disamount'];
		}
		$this->assign('amount',$amount);
		$this->assign('o_id',$o_id);
		$this->assign('disamount',$disamount);
		$this->display();
	}

	public function do_delete(){
		$od=M('Orderdish');

		$od->startTrans();
		$ret1=$od->delete($_GET['u_id']);


		$rid['r_id']=$_GET['r_id'];
		$arr=$od->where($rid)->select();

		$vdata['r_amount']=0;
		$vdata['r_disamount']=0;

		foreach ($arr as $key=>$value){
			$vdata['r_amount']+=$value['u_amount'];
			$vdata['r_disamount']+=$value['u_disamount'];
		}

		$orderdesk=M('Orderdesk');
		$ret2=$orderdesk->where($rid)->save($vdata);
		//dump($ret1);
		//dump($ret2);
     	if($ret1&&$ret2){
     		$od->commit();
       		$this->success('删除餐桌菜品记录成功');   
    	 }else{
    	 	$od->rollback();
       		$this->error('删除餐桌菜品记录失败!');
       	}
		
	}
	
	public function do_euse(){

		$where['r_id']=$_GET['r_id'];
		
		$od=M('Orderdesk');
		$od->startTrans();
		$data['r_state']='用餐毕';
		$ret1=$od->where($where)->save($data);
		$ret=$od->where($where)->select();

		$where['b_id']=$ret[0]['b_id'];
		$b_time=$ret[0]['r_time'];
		$d=M('Desk');
		$ddata[$b_time]='0';
		$ret2=$d->where($where)->save($ddata);
		if($ret1&&$ret2){
			$od->commit();
			$this->assign('finish',1);
			$this->assign('amount',$_GET['amount']);
			$this->assign('disamount',$_GET['disamount']);
			$this->assign('o_id',$_GET['o_id']);
			$this->display('odlist');
		}else{
			$od->rollback();
			$this->error('操作失败！');
		}
		
	}

	public function do_urgent(){
		$where['u_id']=$_GET['u_id'];
		$od=M('Orderdish');
		$dishes=$od->where($where)->find();
		
		$data['u_urgent']=$dishes['u_urgent']+10;
		if($data['u_urgent']>100){
			echo '失败';
		}else{
			$ret=$od->where($where)->save($data);
			if($ret){
				echo '成功';
			}else{
				echo '失败';
			}
			
		}	
	}
}