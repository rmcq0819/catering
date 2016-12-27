<?php
	namespace Home\Model;
	class AdminModel extends \Think\Model{

		protected $_validate=array(
			array('p_id','require','管理员编号必须填写!'),
			array('p_id','/^\d{6}$/','管理员编号应由6位的数字组成!',0,'regex',1),
			array('p_id','','管理员编号已经存在！',0,'unique',1), // 在新增的时候验证字段是否唯一 
		
			array('p_username','require','管理员账号必须填写!'),
			array('p_password','require','管理员密码必须填写!'),
			array('p_verifypwd','require','验证密码必须填写!'),
			array('p_verifypwd','p_password','确认密码不正确',0,'confirm'), // 验证确认密码是否和密码一致
			array('m_pwd','6,12','密码长度应在6-12之间!',2,'length'),
			array('m_name','6,20','用户名长度应6-15之间!',2,'length'),
			
		);
	}
?>
