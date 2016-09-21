<?php
class ManagerModel extends Model{
	protected $tableName ='users'; 
	//自动验证
	protected $_validate=array(
		array('username','require','用户名称必须填写！',1,'',3),
		array('password','require','用户密码必须填写！',1,'',3),
	);
}