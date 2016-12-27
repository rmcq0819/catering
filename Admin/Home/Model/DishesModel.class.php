<?php
	namespace Home\Model;
	class DishesModel extends \Think\Model{

		protected $_validate=array(
			array('d_id','require','菜品编号必须填写!'),
			array('d_id','/^\d{6}$/','菜品编号应由6位的数字组成!',0,'regex',1),
			array('d_id','','菜品编号已经存在！',0,'unique',1), // 在新增的时候验证字段是否唯一 
			array('d_name','require','菜品名称必须填写!'),
			array('d_name','1,32','菜品名称长度应不超过32!',2,'length'),
			
			array('d_price','require','菜品原价必须填写!'),
			array('d_account','require','菜品供应数量必须填写!'),
		);
	}
?>
