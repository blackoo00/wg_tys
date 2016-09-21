<?php 
	class DoctorModel extends RelationModel{
		protected $tableName = 'doctor_list'; 
		protected $_validate =array(
			array('name','require','医生名称不能为空',0),
			array('username','require','账号不能为空',0),
			array('password','require','密码不能为空',0),
			array('newpassword','require','新密码不能为空',0),
			array('repassword','newpassword','两次密码输入不同',0,'confirm'), // WAP验证确认密码是否和密码一致
			array('arepassword','password','两次密码输入不同',0,'confirm'), // USER验证确认密码是否和密码一致
			array("name","2,12","医院名称在2到12位",0,"length"),
			array('hid','require','请选择医院',0),
			array('persition','require','请填写职位',0),

		);
		protected $_auto = array ( 
		    array('password','md5',3,'function') , // 对password字段在新增的时候使md5函数处理
		);
		protected $_link = array(
			'Hospital' => array(
				'mapping_type' => BELONGS_TO,
				'class_name'=>'Hospital',
				'foreign_key'=>'hid',
				'mapping_name'=>'hospital',
			),
			'Consult' => array(
				'mapping_type' => HAS_MANY,
				'class_name'=>'Consult',
				'foreign_key'=>'did',
				'mapping_name'=>'consult',
			),
			'Custom' => array(
				'mapping_type' => HAS_MANY,
				'class_name'=>'Custom',
				'foreign_key'=>'did',
				'mapping_name'=>'custom',
				'mapping_fields'=>'id',
			),
		);
	}
?>