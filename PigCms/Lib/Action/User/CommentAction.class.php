<?php 
	class CommentAction extends UserAction{
		public function index(){
			$db=D(MODULE_NAME);
			//显示分页
			$count      = count($db->select());       
            $Page       = new Page($count,10);//每页显示一个
        	$show       = $Page->show();
        	$this->assign('page',$show);
        	
        	//判断是显示全部还是指定医生
        	// $did=$this->_get('did','intval');
        	// if($did){
        	// 	$where['did']=$did;
        	// 	$comment=$db->relation(true)->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
        	// 	$this->assign('comment',$comment);
        	// }else{
        	// 	$comment=$db->relation(true)->limit($Page->firstRow.','.$Page->listRows)->select();
        	// 	$this->assign('comment',$comment);
        	// }
            //搜索条件
            if($_POST){
                $where=" name like '%".$_POST['search']."%' and commentnums>0";
                $doctor=D('Doctor')->where($where)->select();
                foreach ($doctor as $k => $v) {
                    $where2.=$v['id'].",";
                }
                $map['did']  = array('in',$where2);
            }
            if($where){
                $comment = $db->relation(true)->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();
            }else{
                $comment = $db->relation(true)->limit($Page->firstRow.','.$Page->listRows)->select();
            }
            $this->assign('comment',$comment);
        	//医生列表
        	$db=D('Doctor');
        	$doctor=$db->select();
        	$this->assign('did',$did);
        	$this->assign('doctor',$doctor);
			$this->display();
		}
	}
 ?>