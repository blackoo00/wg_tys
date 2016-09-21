<?php 
	class HospitalAction extends WapAction{
		public function index(){
			$db=D(MODULE_NAME);
			$hospital=$db->select();
			foreach ($hospital as $key => $value) {
				$doctornum+=$value['doctornum'];
			}
			$this->assign('doctornum',$doctornum);
			$this->assign('hospitalnum',count($hospital));
			$this->assign('hospital',$hospital);
			$this->display();
		}
	}
 ?>