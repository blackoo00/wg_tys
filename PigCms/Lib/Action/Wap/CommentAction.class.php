<?php 
	class CommentAction extends WapAction{
		public function index(){
			//孕育师ID
			$id=$this->_get('id','intval');
			$db=D('Doctor');
			$where['id']=$id;
			$doctor=$db->where($where)->find();
			$this->assign('doctor',$doctor);
			$this->display();
		}
		//插入评价
		public function insert(){
			$db=D('Comment');
			$db2=D('Custom');
			$where['openid']=$this->wecha_id;
			$cid=$db2->field('id')->where($where)->find();

			$data['cid']=$cid['id'];
			$data['did']=$_POST['did'];
			$data['info']=$_POST['info'];
			$data['stars']=$_POST['starnum'];
			$data['time']=time();

			$r=$db->add($data);
			if($r){
				$db3=D('Doctor');
				$where['id']=$_POST['did'];
				$db3->where($where)->setInc('commentnums');
				$this->success('评价成功',U('Doctor/details', array('id'=>$_POST['did'],'token'=>$this->token,'wecha_id'=>$this->wecha_id)));
			}else{
				$this->error('评价失败',U('Doctor/details', array('id'=>$_POST['did'],'token'=>$this->token,'wecha_id'=>$this->wecha_id)));
			}
		}
		//判断是否已经做过评价
		public function checkcomment(){
			$db=D('Comment');
			//获取评价表中相对应孕妈ID
			$id=$this->_get('id','intval');//孕育师ID
			$cid=$db->field('cid')->where('did='.$id)->select();
			//获取当前用户ID
			$where['openid']=$this->wecha_id;
			$custom=D('Custom')->field('id')->where($where)->find();
			foreach ($cid as $v) {
				if($custom['id']==$v['cid']){
					echo '1';
				}
			}
		}
	}
?>