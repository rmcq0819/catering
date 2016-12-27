<?php
namespace Home\Controller;
use Common\Controller\CommonController;
use Home\Model\AdminModel as Admin;  
class AdminController extends CommonController {

    public function add(){
		$this->display();
    }

    public function modify(){
		$a=D('Admin');
		$where['p_id']=$_SESSION['id'];
		$arr=$a->where($where)->select();
		$this->assign('a',$arr[0]);
		$this->display();
    }
   
   

    public function checkId(){
		$p_id=$_GET['p_id'];
		if(!preg_match('/^\d{6}$/',$p_id)){
			echo "超界";
		}else{
			$a=M('Admin');
			$where['p_id']=$p_id;
			$count=$a->where($where)->count();
			if($count){
				echo '已存在';
			}else{
				echo '允许';
			}
		}	
	}
	 

	public function do_add(){
		$a=D('Admin');

		if(!$a->create()){//自动创建
			$this->error($a->getError());
		}
		$lastId=$a->add();
		if($lastId){
			$this->success('添加管理员信息成功！',U('Index/index'));
		}else{
			$this->error('添加管理员信息失败！');
		}

	}

	
	public function do_modify(){
		$a=D('Admin');
		$p_id=$_POST['p_id'];
		$where['p_id']=$p_id;

		$p_password=$_POST['p_password'];
		$p_npwd=$_POST['p_npwd'];
		$p_verifypwd=$_POST['p_verifypwd'];
		
		$data['p_username']=$_POST['p_username'];
		if($p_verifypwd!=$p_npwd||$p_verifypwd==''||$p_npwd==''){
			$this->error('密码为空或两次密码不一致！！');
		}
		$data['p_password']=$p_npwd;
		$ret=$a->where($where)->find();
		if($p_password!=$ret['p_password']){
				$this->error('原密码错误！');
		}
			
		$lastId=$a->where($where)->save($data);
		
		if($lastId){
			$this->success('修改管理员信息成功！',U('Index/index'));
		}else{
			$this->error('修改管理员信息失败！');
		}


	}
}