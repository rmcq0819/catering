<?php
	namespace Home\Model;
	class ReserveModel extends \Think\Model{

		protected $_validate=array(
			array('n_id','require','预定编号必须填写!'),
			array('n_id','/^\d{16}$/','预定编号应由16位的数字组成!',0,'regex',1),
			array('n_id','','预定编号已经存在！',0,'unique',1), 
			// 在新增的时候验证字段是否唯一 
			array('n_name','require','顾客姓名必须填写!'),
			array('n_money','require','定金必须填写!'),
			array('n_usernumber','require','用餐人数必须填写!'),
			array('n_reservetime','require','预定时间必须填写!'),
			array('n_name','1,10','顾客姓名长度应不超过10!',2,'length'),
			array('n_phone','require','手机号必须填写!'),
			array('n_phone','/^13(\d{9})$|^18(\d{9})$|^15(\d{9})$/','手机号码有误!',0,'regex',1),
		);
	}
?>
