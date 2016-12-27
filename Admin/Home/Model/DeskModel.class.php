<?php
	namespace Home\Model;
	class DeskModel extends \Think\Model{

		protected $_validate=array(
			array('b_id','require','餐桌编号必须填写!'),
			array('b_id','/^\d{2}$/','餐桌编号应由2位的数字组成!',0,'regex',1),
			array('b_id','','餐桌编号已经存在！',0,'unique',1), // 在新增的时候验证字段是否唯一 
			array('b_block','require','餐桌所在区域必须填写!'),
			array('b_seats','require','餐桌座位数必须填写!'),
			array('b_deposit','require','餐桌应付定金必须填写!'),
		);
	}
?>
