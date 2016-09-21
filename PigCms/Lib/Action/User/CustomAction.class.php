<?php 
	class CustomAction extends UserAction{
		public function index(){
			$db=D(MODULE_NAME);
			//显示分页
			$count      = count($db->select());       
            $Page       = new Page($count,20);//每页显示一个
        	$show       = $Page->show();
        	$this->assign('page',$show);
        	if($_POST){
        	    $map['name'] = array('like','%'.$_POST['search'].'%');
        	}
			$c=$db->relation(true)->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();
			$this->assign("custom",$c);
			$this->display();
		}
		public function details(){
			$db=D(MODULE_NAME);
			$id=$this->_get('id','intval');
			$where['id']=$id;
			$custom=$db->where($where)->relation(true)->find();
			$this->assign('info',$custom);
			//获取血糖记录
			$condition['cid']=$id;
			$bsuger=D('Bsuger')->where($condition)->order('recordtime desc')->limit(7)->select();
			$this->assign('bsuger',$bsuger);
			//获取重要指标
			$bprotein=D('Bprotein')->where($condition)->find();
			$this->assign('bprotein',$bprotein);
			//获取化验图片
			$laboratory=D('Laboratory')->field('pic')->where($condition)->order('recordtime desc')->select();
			$this->assign('laboratory',$laboratory);

			$this->display();
		}
	}
 ?>