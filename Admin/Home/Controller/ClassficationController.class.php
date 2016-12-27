<?php
namespace Home\Controller;
use Common\Controller\CommonController;
use Home\Model\ClassficationModel as Classfication;  
class ClassficationController extends CommonController {
  
    public function add(){
		$this->display();
    }
     public function modify(){
     	$cf=D('Classfication');
		$where['c_id']=$_GET['c_id'];
		$arr=$cf->where($where)->select();
		$this->assign('cf',$arr[0]);
		$this->display();
    }
    public function checkId(){
		$c_id=$_GET['c_id'];
		if(!preg_match('/^\d{2}$/',$c_id)){
			echo "超界";
		}else{
			$cf=M('Classfication');
			$where['c_id']=$c_id;
			$count=$cf->where($where)->count();
			if($count){
				echo '已存在';
			}else{
				echo '允许';
			}
		}	
	}

	public function cflist(){//分类列表
		//获取classfication表中的所有数据
		$cf=D('Classfication');
        $where['c_exist']='1';
		$count=$cf->where($where)->count();//获取数据的总数
        $page  = new \Think\Page($count,4);
		$show=$page->show();//返回分页信息
		$arr=$cf->where($where)->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('list',$arr);
		$this->assign('show',$show);
		$this->display();
	}

	public function do_add(){
		$cf=D('Classfication');

		if(!$cf->create()){//自动创建
			$this->error($cf->getError());
		}
		$lastId=$cf->add();
		if($lastId){
			$this->success('添加菜品分类信息成功！');
		}else{
			$this->error('添加菜品分类信息失败！');
		}

	}



	public function do_delete(){
		$cf=D('Classfication');
		$data['c_exist']='0';
		$where['c_id']=$_GET['c_id'];
     	if($cf->where($where)->save($data)){//外码约束，删除时需注意！！！
       		$this->success('删除菜品分类信息成功',U('Classfication/cflist'));   
    	 }else{
      		$this->error('删除菜品分类信息失败!');
        }
		
	}
	public function do_modify(){
		$cf=D('Classfication');
		if(!$cf->create()){//自动创建
			$this->error($cf->getError());
		}
		$lastId=$cf->save();
		if($lastId){
			$this->success('修改菜品分类信息成功',U('Classfication/cflist'));
		}else{
			$this->error('修改菜品分类信息失败！');
		}


	}
}