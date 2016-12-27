<?php
	namespace Home\Model;
	use Think\Model\RelationModel;
	class OrdersModel extends RelationModel{

		protected $_validate=array(
			array('o_id','require','订单编号必须填写!'),
			array('o_id','/^\d{16}$/','会员编号应由16位的数字组成!',0,'regex',1),
			array('o_id','','订单编号已经存在！',0,'unique',1), // 在新增的时候验证字段是否唯一 
			array('m_id','require','会员编号必须填写!'),	
			array('w_id','require','服务员编号必须填写!'),	
			array('m_id','/^\d{12}$/','会员编号应由12位的数字组成!',0,'regex',1),
			array('w_id','/^\d{6}$/','服务员编号应由6位的数字组成!',0,'regex',1),

			array('o_etime','require','结单时间必须填写!'),	
			array('o_amount','require','消费总额必须填写!'),	
			array('o_discount','require','会员优惠必须填写!'),	
			array('o_receivable','require','应收款必须填写!'),	
			array('o_received','require','实收款必须填写!'),	
			array('o_integral','require','本次积分必须填写!'),	
			array('o_state','require','订单状态必须填写!'),			
			
		);

		protected $_link=array(//关联
			'Waiter'=> array(  
     			'mapping_type'=>BELONGS_TO,
          		'class_name'=>'Waiter',
          		'foreign_key'=>'w_id',
				'mapping_name'=>'waiter',
				'mapping_fields'=>'w_name',
				'as_fields'=>'w_name',
			),
		);
	}
?>