<?php 
class HospitalModel extends Model {
	protected $tableName = 'hospital_list'; 
	protected $_validate =array(
		array('name','require','医院名称不能为空',1),
		//array('info','require','医院简介不能为空',1),
	);
}
?>