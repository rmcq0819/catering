<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function login(){
		$this->display();
    }

	function do_login(){
		//获取用户名和密码等。和数据库中比对，有该用户则允许登录，否则输出错误页面
		$m_name=$_POST['m_name'];
		$m_pwd=$_POST['m_pwd'];
		
		$m=M('Member');
		
		$where['m_name']=$m_name;
		$where['m_pwd']=$m_pwd;
		$n=$m->where($where)->count();
		if($n>0){
			$_SESSION['m_name']=$m_name;
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