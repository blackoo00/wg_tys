<?php 
	class ConsultAction extends UserAction{
		//咨询列表
		public function index(){
			$db=D(MODULE_NAME);
			//显示分页
			$count      = count($db->select());       
            $Page       = new Page($count,10);//每页显示一个
        	$show       = $Page->show();
        	$this->assign('page',$show);
        	//判断是显示全部还是指定患者的咨询
        	$id=$this->_get('id','intval');
        	if($id){
        		$where['cid']=$id;
        		$consult=$db->relation(true)->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
        		$this->assign('consult',$consult);
        	}else{
        		if($_POST){
	                $where=" name like '%".$_POST['search']."%' ";
	                $doctor=D('Doctor')->where($where)->select();
	                foreach ($doctor as $k => $v) {
	                    $where2.=$v['id'].",";
	                }
	                $map['did']  = array('in',$where2);
	            }
        		$consult=$db->relation(true)->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();
        		// echo "<pre>";
        		// var_dump($str);
        		// echo "</pre>";
        		// exit();
        		$this->assign('consult',$consult);
        	}

			$this->display();
		}
		//咨询详细
		public function detail(){
			$db=D('Consultb');
			//显示分页
			$count      = count($db->select());       
            $Page       = new Page($count,10);//每页显示一个
        	$show       = $Page->show();
        	$this->assign('page',$show);

        	//赋值咨询详细信息
        	$id=$this->_get('id','intval');
        	$where['cmid']=$id;
			$consultb=$db->relation(true)->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
			$this->assign('consultb',$consultb);

			//查询医生患者姓名
			$db=D(MODULE_NAME);
			$where['id'] = $this->_get('id','intval');
			$consult=D(MODULE_NAME)->relation(true)->where($where)->select();
			$this->assign('consult',$consult['0']);

			$this->display();
		}
	}
?>