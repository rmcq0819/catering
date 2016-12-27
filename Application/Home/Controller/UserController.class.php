<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {
    public function user(){

    	$u=M('User');
		$arr=$u->select();
		/*dump(timespan($arr[0]['s_subtime']));*/
		foreach ($arr as $key=>$value){
			$arr[$key]['s_subtime']=timespan($arr[$key]['s_subtime']);
		}
		$this->assign('list',$arr);
		$this->display();
    }
}