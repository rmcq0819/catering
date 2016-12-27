<?php
namespace Home\Controller;
use Common\Controller\CommonController;
class IndexController extends CommonController { 
 	public function index(){
 		$this->assign('username',$_SESSION['username']);
 		$this->assign('id',$_SESSION['id']);
		$this->display();
    }

     public function wel(){
		$this->display();
    }
}