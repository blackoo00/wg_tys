<?php
class HospitalAction extends UserAction{
	//医院列表
	public function index(){
		$db = D(MODULE_NAME);
		//显示分页
			$count      = count($db->select());       
            $Page       = new Page($count,10);//每页显示一个
        	$show       = $Page->show();
        	$this->assign('page',$show);

		$hospital=$db->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('hospital',$hospital);
		$this->display();
	}
	//新增医院页面
	public function add(){
		$db=D('Salesman');
		$sname=$db->field('id,name')->select();
		$this->assign('sname',$sname);
		$this->display();
	}
	//新增医院
	public function insert(){
		$db=D(MODULE_NAME);
		if ($db->create() === false) {
			$this->error($db->getError());
		}
		$r=$db->add();
		$h=D('Salesman');
		if($r){
			$where ['id'] = $_POST['sid'];
			$r=$h->where($where)->setInc('hospitalnum'); 
			if(!$r){
				Log::write("销售医院数量自增失败!",'ERR');
			}else{
				$this->success('添加成功',U('Hospital/index'));
			}
		}else{
			Log::write("新增医院失败,错误信息!",'ERR');
		}
	}
	//删除医院
	public function del(){
		$where['id']=$this->_get('id','intval');
		if(D(MODULE_NAME)->where($where)->delete()){
			$this->success('操作成功',U(MODULE_NAME.'/index'));
			//删除医院中相对应的医生
			$h=D('Salesman');
			$where ['id'] = $this->_get('sid','intval');
			$r=$h->where($where)->setDec('hospitalnum'); 
			if(!$r){
				Log::write("销售医院数量自减失败!",'ERR');
			}
		}else{
			$this->error('操作失败',U(MODULE_NAME.'/index'));
		}
	}
	//编辑医院
	public function edit(){
		$where['id']=$this->_get('id','intval');
		$res=D(MODULE_NAME)->where($where)->find();
		$this->assign('info',$res);
		$db=D('Salesman');
		$sname=$db->field('id,name')->select();
		$this->assign('sname',$sname);
		$this->display();
	}
	//更新医院信息
	public function upsave(){
		$r=$this->all_save();
		if($r){
			$h=D('Salesman');
			//判断所属医院有没有修改如果不相等就对医院医生数操作
			if($_POST['sid']!= $_POST['sid2']){
				//增加医生数
				$where['id'] = $_POST['sid'];
				$r=$h->where($where)->setInc('hospitalnum'); 
				//减少医生数
				$where2['id'] = $_POST['sid2'];
				$r2=$h->where($where2)->setDec('hospitalnum'); 
				if(!$r&&!$r2){
					Log::write("销售医院数量操作失败!",'ERR');
				}
			}
		}
	}
}


?>