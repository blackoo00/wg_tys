<?php 
	class CustomModel extends RelationModel{
		protected $tableName = 'custom_list';
		protected $_validate =array(
			array('card','isPersonalCard','身份证号码不正确',2,'callback'),
			// array('tel','isMobile','电话号码格式不正确',2,'callback'),
		); 
		/**
	     * 正则表达式验证身份证号码
	     *
	     * @param integer $num    所要验证的身份证号码
	     * @return boolean
	     */
	    function isPersonalCard($num) {
	        if (!$num) {
	            return false;
	        }
	        return preg_match('#^[\d]{15}$|^[\d]{18}$#', $num) ? true : false;
	    }
	    /**
         * 用正则表达式验证手机号码(中国大陆区)
         * @param integer $num    所要验证的手机号
         * @return boolean
         */
        function isMobile($num) {
            if (!$num) {
                return false;
            }
            return preg_match('#^13[\d]{9}$|14^[0-9]\d{8}|^15[0-9]\d{8}$|^18[0-9]\d{8}$#', $num) ? true : false;
        }
        
		protected $_link = array(
			'Doctor' => array(
				'mapping_type' => BELONGS_TO,
				'class_name'=>'Doctor',
				'foreign_key'=>'did',
				'mapping_name'=>'doctor',
			),
			'Consult' => array(
				'mapping_type' => HAS_ONE,
				'class_name'=>'Consult',
				'foreign_key'=>'cid',
				'mapping_name'=>'consult',
			),
		);
	}
 ?>