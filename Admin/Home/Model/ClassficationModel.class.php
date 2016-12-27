<?php
	namespace Home\Model;
	class ClassficationModel extends \Think\Model{

		protected $_validate=array(
			array('c_id','require','分类编号必须填写!'),
			array('c_id','/^\d{2}$/','分类编号应由2位的数字组成!',0,'regex',1),
			array('c_id','','分类编号已经存在！',0,'unique',1), // 在新增的时候验证字段是否唯一 
			array('c_name','require','分类名称必须填写!'),
			array('c_name','1,10','分类名称长度应不超过10!',2,'length'),
		);
	}
?>
