<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function login(){
		$this->display();
    }

	function do_login(){
		//获取用户名和密码等。和数据库中比对，有该用户允许登录,否则输出错误页面
		$username=$_POST['username'];
		$password=$_POST['password'];
		
		$m=M('Admin');
		
		$where['p_username']=$username;
		$where['p_password']=$password;
		$adm=$m->where($where)->find();
		
		if($adm){
			$_SESSION['id']=$adm['p_id'];
			$_SESSION['username']=$username;
			$this->redirect('Index/index');
		}else{
			$this->error('用户名或密码错误!');
		}
	}

	//退出
	public function do_logout(){
		$_SESSION=array();
			if(isset($_COOKIE[session_name()])){
				setcookie(session_name(),'',time()-1,'/');
			}
		session_destroy();
		$this->redirect('Login/login');
	}
}