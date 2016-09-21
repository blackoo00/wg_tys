<?php 
	class ConsultModel extends RelationModel{
		protected $tableName ='consult_master'; 
		protected $_link = array(
			'Custom' => array(
				'mapping_type' => BELONGS_TO,
				'class_name'=>'Custom',
				'foreign_key'=>'cid',
				'mapping_name'=>'custom',
			),
			'Doctor' => array(
				'mapping_type' => BELONGS_TO,
				'class_name'=>'Doctor',
				'foreign_key'=>'did',
				'mapping_name'=>'doctor',
			),
		);
	}
?>