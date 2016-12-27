<?php
namespace Home\Controller;
use Think\Controller; 
class ReserveController extends Controller {
	public function reserve(){
		$d=M('Desk');
		$b_time=$_POST['b_time'];//POST变量不能跨页传递
		$where[$b_time]='0';
		$where['b_exist']='1';
		$arr=$d->where($where)->select();
		$this->assign('list',$arr);
		$this->assign('b_time',$b_time);
		$this->display();
	}
	public function abrogate(){
		$this->display();
	}
	public function reservelist(){

		$n_id=$_POST['n_id'];
		$r=M('Reserve');
		$where['n_id']=$n_id;
		$reserve=$r->where($where)->find();
		//dump($reserve);
		
		if(empty($reserve)){
			$this->error('该预定单号不存在！');
		}
		if($reserve['n_state']=='订单生成'){
			$this->error('订单已生成，不允许删除');
		}
		
		$rd=M('Reservedesk');
		$arr=$rd->where($where)->select();
		$this->assign('res',$reserve);
		$this->assign('n_id',$n_id);
		$this->assign('list',$arr);
		$this->display();
	}

	public function do_delete(){
		$r=M('Reserve');
		$r->startTrans();
		$where['n_id']=$_GET['n_id'];

		$reserve=$r->where($where)->find();

		if(empty($reserve)){
			$this->error('该预定单号不存在！');
		}
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
       		$this->success('取消预定成功',U('Reserve/abrogate'));   
    	 }else{
    	 	$r->rollback();
       		$this->error('取消预定失败!');
       }
		
	}
	public function do_reserve(){
		$r=M('Reserve');
		$r->startTrans();//启用事物
		$id=$this->getId();
		//$_SESSION['id']=$id;
		$rdata['n_id']=$id;
		$rdata['n_reservetime']=$this->getReservetime();
		$rdata['n_usernumber']=$_POST['n_usernumber'];
		$rdata['n_name']=$_POST['n_name'];
		if(!preg_match('/^(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/',$_POST['n_phone'])){
			$_SESSION['sarr']='';
			$this->error('请填写正确的手机号码');
		}
		$rdata['n_phone']=$_POST['n_phone'];
		$rdata['n_description']=$_POST['n_description'];
		$rdata['n_state']='预定成功';
		$arr=$_SESSION['sarr'];
		$b_time=$_SESSION['b_time'];
		$rdata['n_usetime']=$b_time;

		$data[$b_time]='1';
		$d=M('Desk');
		$rd=M('Reservedesk');
		$rddata['n_id']=$id;//外码约束
		$deposit=0;
		foreach($arr as $key=>$value){
			$where['b_id']=$value;
			$desk=$d->where($where)->find();
			$deposit+=$desk['b_deposit'];
		}
		$rdata['n_money']=$deposit;
		$ret1=$r->add($rdata);//返回最新插入的值
		
		$ret2=true;
		$ret3=true;
		dump($b_time);
		foreach($arr as $key=>$value){
			$where['b_id']=$value;
			$r1=$d->where($where)->save($data);//返回受影响的记录数，从处理逻辑上来讲，受影响的记录数是大于0的
	
			if(!$r1){
				$ret2=false;
			}
			$rddata['b_id']=$value;
			$rddata['v_id']=$this->getId();
			$r2=$rd->add($rddata);
			if(!$r2){
				$ret3=false;
			}
		}
		if($ret1&&$ret2&&$ret3){
			$r->commit();//成功则提交
			$_SESSION['sarr']='';
			$this->success('成功!',U('reservemsg?n_id='.$id));
		}else{
			$r->rollback();//不成功，则回滚
			$_SESSION['sarr']='';
			$this->error('失败');
		}
		
	}

	public function select_desk(){
		$_SESSION['b_time']=$_GET['b_time'];
		$b_id=$_GET['b_id'];
		$_SESSION['sarr'][$b_id]=$b_id;
		if($b_id&&$_SESSION['b_time']){
			echo '选择成功';
		}else{
			echo '选择失败';
		}
		
	}
	public function getId(){
			$dt=date('YmdHis');
			$rd=rand(10,99);
			$n_id=$dt."".$rd;
			$_SESSION['n_id']=$n_id;
			return $n_id;
	}
		public function getReservetime(){
			$dt=date('Y-m-d H:i:s');
			return $dt;
		}

	  public function checkPhone(){
		$n_phone=$_GET['n_phone'];
		if(!preg_match('/^(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/',$n_phone)){
			echo "错误";
		}else{
			echo "正确";
		}	
	}	
}