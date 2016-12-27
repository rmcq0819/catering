<?php
	namespace Home\Model;
	class WaiterModel extends \Think\Model{

		protected $_validate=array(
			array('w_id','require','服务员编号必须填写!'),
			array('w_id','/^\d{6}$/','服务员编号应由6位的数字组成!',0,'regex',1),
			array('w_id','','服务员编号已经存在！',0,'unique',1), // 在新增的时候验证字段是否唯一 
			array('w_name','require','服务员名称必须填写!'),
			array('w_name','1,10','服务员名称长度应不超过10!',2,'length'),
			array('w_age','18,60','服务员年龄的范围应在18-60之间!',2,'between'),
		);

	
	}
?>
