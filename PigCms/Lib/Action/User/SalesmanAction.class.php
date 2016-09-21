<?php
class SalesmanAction extends UserAction{
	//销售列表
	public function index(){
		$db = D(MODULE_NAME);
		//显示分页
			$count      = count($db->select());       
            $Page       = new Page($count,10);//每页显示一个
        	$show       = $Page->show();
        	$this->assign('page',$show);

		$salesman=$db->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('list',$salesman);
		$this->display();
	}
	//新增销售页面
	public function add(){
		$this->display();
	}
	//新增销售
	public function insert(){
		$this->all_insert(MODULE_NAME,'/add');
	}
	//删除销售
	public function del(){
		$where['id']=$this->_get('id','intval');
		if(D(MODULE_NAME)->where($where)->delete()){
			$this->success('操作成功',U(MODULE_NAME.'/index'));
		}else{
			$this->error('操作失败',U(MODULE_NAME.'/index'));
		}
	}
	//编辑医院
	public function edit(){
		$where['id']=$this->_get('id','intval');
		$res=D(MODULE_NAME)->where($where)->find();
		$this->assign('info',$res);
		$this->display();
	}
	//更新医院信息
	public function upsave(){
		$this->all_save();
	}
}


?>