<?php 
	class FeedbackModel extends RelationModel{
		protected $tableName = 'feedback_list'; 
		protected $_link = array(
			'Doctor' => array(
				'mapping_type' => BELONGS_TO,
				'class_name'=>'Doctor',
				'foreign_key'=>'did',
				'mapping_name'=>'doctor',
			),
		);
	}
?>