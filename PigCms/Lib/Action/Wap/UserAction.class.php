<?php 
	class UserAction extends WapAction{
		public $did;
		public $cid;
		public $custom;
		public function __construct(){
			parent::_initialize();
			$custom = D('Custom')->where(array('openid'=>$this->wecha_id))->relation(true)->find();
			$this->assign('did',$custom['did']);
			$this->assign('cid',$custom['cid']);
			$this->assign('custom',$custom);
			$this->assign('doctor',$custom['doctor']);
			$this->custom = $custom;
			$this->did = $custom['did'];
			$this->cid = $custom['id'];
		}
		//咨询主列表
		// public function consultm(){
		// 	$db2=D('Custom');
		// 	$where['openid']=$this->wecha_id;
		// 	$custom=$db2->where($where)->find();
		// 	$id=$custom['id'];
		// 	if($id){
		// 		$db=D('Consult');
		// 		$where['cid']=$id;
		// 		//显示分页
		// 		$count      = count($db->where($where)->select());       
		//         $Page       = new Page($count,6);//每页显示一个
		//     	$show       = $Page->show();
		//     	$this->assign('page',$show);

		// 		$consult=$db->order('time desc')->where($where)->relation(true)->limit($Page->firstRow.','.$Page->listRows)->select();
		// 		$this->assign('consult',$consult);
		// 		$this->assign('custom',$custom);
		// 		$this->display();
		// 	}
		// }
		// //咨询支表
		// public function consultb(){
		// 	//获取咨询主表ID
		// 	$id=$this->_get('id','intval');
		// 	$db=D('Consultb');
		// 	$db2=D('Consult');
		// 	if($id){
		// 		$this->assign('cmid',$id);
		// 		//获取咨询支表信息
		// 		$where['cmid']=$id;
		// 		$consultb=$db->where($where)->order('time asc')->select();
		// 		$this->assign('consultb',$consultb);

		// 		//通过咨询主表获取孕妈孕育師信息
		// 		$where['id']=$id;
		// 		$dc=$db2->relation(true)->where($where)->find();
		// 		$dc['spic']=explode(",", $dc['spic']);
		// 		$this->assign('consultm',$dc);
		// 	}
		// 	$this->assign('customname',$dc['custom']['name']);
		// 	$this->assign('doctorname',$dc['doctor']['name']);
		// 	$this->display();
		// }
		//新咨询对话
		public function customconsultb(){
			//获取孕育師信息
			$did=$this->_get('did','intval');
			$doctor=D('Doctor')->where('id='.$did)->find();
			$this->assign('doctor',$doctor);
			//获取孕妈信息
			$cid=$this->_get('cid','intval');
			$condition['openid']=$this->wecha_id;
			$custom=D('Custom')->where($condition)->find();
			$this->assign('custom',$custom);
			//判断孕育師日咨询量
			$t1=strtotime('today');
			$t2=$t1+86400;
			$where['did']=$did;
			$where['time']=array('between',array($t1,$t2));
			$consult=D('Consult')->where($where)->select();
			$ccounts=count($consult);
			if($ccounts==$doctor['dailyconsult']){
				$check=0;
				foreach ($consult as $k => $v) {
					if($v['cid']==$cid){
						$check=1;
					}
				}
				if($check==0){
					$this->error("已达孕育師今日咨询总量",U('User/doctorlist', array('token'=>$this->token,'openid'=>$this->wecha_id)));
				}
			}
			//获取咨询分支
			$condition2['did']=$did;
			$condition2['cid']=$custom['id'];
			$cmid=D('Consult')->field('id')->where($condition2)->find();
			if($cmid){
				$cmid=$cmid['id'];
				$data['dnew']=0;
				D('Consult')->where($condition2)->save($data);
			}else{
				$newconsult=array(
					'did'=>$did,
					'cid'=>$custom['id'],
					'time'=>time(),
				);
				$cmid=D('Consult')->add($newconsult);
				D('Doctor')->where('id='.$did)->setInc('consultnums');
				if(!$cmid){
					$this->error("系统出错");
				}
			}
			
			$consultb=D('Consultb')->where('cmid='.$cmid)->limit(10)->order('time desc')->relation(true)->select();
			$consultm = D('Consult')->where('id='.$cmid)->find();
			krsort($consultb);
			$this->assign('cmid',$cmid);
			$this->assign('custom',$custom);
			$this->assign('doctor',$doctor);
			$this->assign('consultb',$consultb);
			$this->assign('consultm',$consultm);

			$this->display();
		}
		//插入咨询支表
		public function insert(){
			//获取咨询主表ID
			$id=$this->_get('id','intval');
			if($id){
				$db=D('Consultb');
				$data=array(
					'cmid'=>$id,
					'dtalk'=>0,
					'ctalk'=>1,
					'content'=>$_POST['content'],
					'time'=>time(),
				);
				$r=$db->add($data);
				if($r){
					$this->redirect('User/consultb', array('id' => $id,'token'=>$this->token,'openid'=>$this->wecha_id));
				}else{
					$this->error('发送失败');
				}
			}
		}
		public function doctorlist(){
			$condition['openid']=$this->wecha_id;
			$custom=D('Custom')->field('id,did')->relation(true)->where($condition)->find();
			
			if($custom['did']){
				$doctor=D('Doctor')->relation(true)->where('id='.$custom['did'])->select();
				$this->assign('doctor',$doctor);
				$this->assign('did',$custom['did']);
				$this->assign('cid',$custom['id']);
			}
			$this->assign('custom',$custom);
			$this->assign('cid',$custom['id']);
			// echo "<pre>";
			// var_dump($custom);
			// echo "</pre>";
			// exit();
			$this->display();
		}
		public function doctor(){
			if(!$this->custom['doctor']){
				$this->error('您还没有关注孕育师');
			}
			$this->assign('click',"no");
			$this->display();
		}
		//我
		public function custom(){
			//获取血糖记录
			$condition['openid']=$custom['openid'];
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
		//个人信息
		public function person(){
			$db=D('Custom');
			$where['openid']=$this->wecha_id;
			$custom=$db->where($where)->find();
			$this->assign('custom',$custom);
			$this->display();
		}
		//个人信息插入
		public function pinsert(){
			$db=D('Custom');
			if ($db->create() === false) {
			    $this->error($db->getError());
			}else{
				$data['name']=$_POST['name'];
				$data['tel']=$_POST['tel'];
				$data['card']=$_POST['card'];
				$where['openid']=$this->wecha_id;
				$z=$db->where($where)->save($data);
				if($z||$z==0){
					$this->success('提交成功',U(MODULE_NAME . '/custom', array('token'=>$this->token,'openid'=>$this->wecha_id)));
				}else{
					$this->error('提交失败',U(MODULE_NAME . '/custom', array('token'=>$this->token,'openid'=>$this->wecha_id)));
				}
			}
		}
		//取消关注
		public function cancel(){
			$did=$this->_get('id','intval');
			$r=D('Doctor')->where('id='.$did)->setDec('followers');//粉丝数减1
			if(!r){
				$this->error('孕育师粉丝数操作失败',U(MODULE_NAME . '/custom', array('token'=>$this->token,'openid'=>$this->wecha_id)));
			}
			$db=D('Custom');
			$where['openid']=$this->wecha_id;
			$data['did']=NULL;
			$id=$db->where($where)->save($data);//关注孕育师的ID清0

			$cid=D('Custom')->field('id')->where($where)->find();
			$cid=$cid['id'];
			$r=D('Consult')->where('cid='.$cid)->delete();//清除咨询主表
			if($id){
				$this->success('操作成功',U(MODULE_NAME . '/doctorlist', array('token'=>$this->token,'openid'=>$this->wecha_id)));
			}else{
				$this->error('操作失败',U(MODULE_NAME . '/doctorlist', array('token'=>$this->token,'openid'=>$this->wecha_id)));
			}

		}
	}
 ?>