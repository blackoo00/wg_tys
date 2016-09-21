<?php 
	class ConsultbModel extends RelationModel{
		protected $tableName ='consult_branch'; 
		protected $_link = array(
			'Consult' => array(
				'mapping_type' => BELONGS_TO,
				'class_name'=>'Consult',
				'foreign_key'=>'cmid',
				'mapping_name'=>'consult',
			),
			'Doctor' => array(
				'mapping_type' => BELONGS_TO,
				'class_name'=>'Doctor',
				'foreign_key'=>'did',
				'mapping_name'=>'doctor',
			),
			'Custom' => array(
				'mapping_type' => BELONGS_TO,
				'class_name'=>'Custom',
				'foreign_key'=>'cid',
				'mapping_name'=>'custom',
			),
		);
	}
?>