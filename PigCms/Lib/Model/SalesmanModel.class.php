<?php 
class SalesmanModel extends Model {
	protected $tableName = 'salesman_list'; 
	protected $_validate =array(
		array('name','require','销售姓名不能为空',1),
		array("name","2,12","销售姓名在2到12位",0,"length"),
		//array('info','require','医院简介不能为空',1),
	);
}
?>