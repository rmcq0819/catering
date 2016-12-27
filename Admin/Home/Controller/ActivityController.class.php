<?php
namespace Home\Controller;
use Common\Controller\CommonController;
use Home\Model\ActivityModel as Activty;  
class ActivityController extends CommonController {

    public function add(){
		$this->display();
    }

    public function modify(){
		$a=D('Activity');
		$where['a_id']=$_GET['a_id'];
		$arr=$a->where($where)->select();
		$this->assign('a',$arr[0]);
		$this->display();
    }

    public function search(){
		$condi=$_GET['condi'];
		if($condi=='1'){
			$where['a_state']='进行中';
		}
		if($condi=='2'){
			$where['a_state']='已结束';
		}
		$where['a_exist']='1';
		$a=D('Activity');
		$count=$a->where($where)->count();//获取数据的总数
		$page  = new \Think\Page($count,4);
		$show=$page->show();//返回分页信息
		$arr=$a->where($where)->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('list',$arr);
		$this->assign('show',$show);
		$this->assign('condi',$condi);
		$this->display('alist');
	}

    public function alist(){//活动列表
		//获取Activity表中的所有数据
		$a=D('Activity');
        $where['a_exist']='1';
		$count=$a->where($where)->count();//获取数据的总数
		$page  = new \Think\Page($count,4);
      
		$show=$page->show();//返回分页信息
		$arr=$a->where($where)->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('list',$arr);
		$this->assign('show',$show);
		$this->display();
	}

    public function checkId(){
		$a_id=$_GET['a_id'];
		if(!preg_match('/^\d{6}$/',$a_id)){
			echo "超界";
		}else{
			$a=M('Activity');
			$where['a_id']=$a_id;
			$count=$a->where($where)->count();
			if($count){
				echo '已存在';
			}else{
				echo '允许';
			}
		}	
	}

	public function do_add(){
		$a=D('Activity');

		if(!$a->create()){//自动创建
			$this->error($a->getError());
		}
		$lastId=$a->add();
		if($lastId){
			$this->success('添加活动信息成功！');
		}else{
			$this->error('添加活动信息失败！');
		}

	}

	public function do_delete(){
		$a=D('Activity');
		$data['a_exist']='0';
		$where['a_id']=$_GET['a_id'];
     	if($a->where($where)->save($data)){
       		$this->success('删除活动信息成功',U('Activity/alist'));   
    	 }else{
       $this->error('删除活动信息失败!');
       }
		
	}
	public function do_modify(){
		$a=D('Activity');
		if(!$a->create()){//自动创建
			$this->error($a->getError());
		}
		$lastId=$a->save();
		if($lastId){
			$this->success('修改活动信息成功',U('Activity/alist'));
		}else{
			$this->error('修改活动信息失败！');
		}


	}
}