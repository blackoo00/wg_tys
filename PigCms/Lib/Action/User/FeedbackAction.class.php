<?php 
	class FeedbackAction extends UserAction{
		//反馈列表
		public function index(){
		$db=D(MODULE_NAME);
		/*if($_POST){
			$where=" name like '%".$_POST['search']."%' ";
		}*/
		//显示分页
		$count      = count($db->relation(true)->select());       
        $Page       = new Page($count,10);//每页显示一个
    	$show       = $Page->show();
    	$this->assign('page',$show);	

    	if($where){
    		$list = $db->relation(true)->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
    	}else{
    		$list = $db->relation(true)->limit($Page->firstRow.','.$Page->listRows)->select();
    	}
		$this->assign('list',$list);
		$this->display();
		}
		//处理反馈
		public function handleInfo(){
			$id=$this->_get('id','intval');//获取反馈ID
			$db=D(MODULE_NAME);
			$data['status'] = 1;
			if($db->where('id='.$id)->save($data)){
				$this->success('处理成功');
			}else{
				$this->error('处理失败');
			}
		}
	}
 ?>