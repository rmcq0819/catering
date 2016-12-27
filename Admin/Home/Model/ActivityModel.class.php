<?php
	namespace Home\Model;
	class ActivityModel extends \Think\Model{
		/*
		array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),
		
		验证条件（可选）
		self::EXISTS_VALIDATE 或者0 存在字段就验证（默认） 
		self::MUST_VALIDATE 或者1 必须验证 
		self::VALUE_VALIDATE或者2 值不为空的时候验证 
		验证时间（可选）
		self::MODEL_INSERT或者1新增数据时候验证 
		self::MODEL_UPDATE或者2编辑数据时候验证 
		self::MODEL_BOTH或者3全部情况下验证（默认） */

		protected $_validate=array(
			array('a_id','require','活动编号必须填写!'),
			array('a_id','/^\d{6}$/','活动编号应由6位的数字组成!',0,'regex',1),
			array('a_id','','活动编号已经存在！',0,'unique',1), // 在新增的时候验证字段是否唯一 
			array('a_startdate','require','活动开始时间必须填写!'),
			array('a_enddate','require','活动结束时间必须填写!'),
			array('a_startdate','2016-4-23,2016-12-31','活动开始时间不在有效时间范围内!',2,'expire'),
			array('a_enddate','2016-4-23,2016-12-31','活动开始时间不在有效时间范围内!',2,'expire'),
		
			array('a_classfication','require','活动类型必须填写!'),
			array('a_state','require','活动状态必须填写!'),

			array('a_state','1,10','活动状态长度应不超过10!',2,'length'),
			array('a_classfication','1,36','活动类型长度应不超过36!',2,'length'),
		);
	}
?>
