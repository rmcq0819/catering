<?php
namespace Home\Controller;
use Think\Controller;
class JudgementController extends Controller {
    public function judgement(){
		$this->display();
    }

    public function do_judge(){
		$jm=M('Judgement');
		$data['j_id']=$this->getId();
		$data['j_openid']=$_POST['j_openid'];
		$data['j_subtime']=time();
		$data['j_nickname']=$_POST['j_nickname'];
		$data['j_headimgurl']=$_POST['j_headimgurl'];
		$data['j_judgement']=$_POST['j_judgement'];
		$lastId=$jm->add($data);
		if($lastId){
			$this->redirect('judgelist');
		}else{
			$this->error('提交评价失败！');
		}	
	}

	public function judgelist(){
		$jm=M('Judgement');
		$arr=$jm->select();
		foreach ($arr as $key=>$value){
			$arr[$key]['j_subtime']=timespan($arr[$key]['j_subtime']);
		}
		$this->assign('list',$arr);
		$this->display();
	}

	public function getId(){
			$dt=date('YmdHis');
			$rd=rand(10,99);
			$j_id=$dt."".$rd;
		
			return $j_id;
	}
}