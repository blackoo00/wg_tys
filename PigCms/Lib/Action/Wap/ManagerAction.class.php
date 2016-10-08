<?php 
	class ManagerAction extends WapAction{
		public function __construct(){
			parent::_initialize();
			if(!session("tys_manager_login") && ACTION_NAME !='index' && ACTION_NAME !='checklogin'){
				$this->error('请先登陆',U('Manager/index'));
			}
		}
		public function index(){
			if(session("tys_manager_login") == '1'){
				$this->redirect(U('Manager/operation'));
			}else{
				$this->display();
			}
		}
		public function checklogin(){
			$db=D('Manager');
			if (!$db->create()){ // 登录验证数据
			    // 验证没有通过 输出错误提示信息
			    $this->error($db->getError());
			 }
			$where['username']=$_POST['username'];
			$users=$db->where($where)->find();
			if(!$users){//账号不存在
				$this->error('账号或密码错误',U('Manager/index'));
			}else{
				$pwd=$this->_post('password','trim,md5');
				if($users['password']!=$pwd){//密码错误
					$this->error('账号或密码错误',U('Manager/index'));
				}else{
					$condition['openid']=$this->wecha_id;
					D('Custom')->where($condition)->setInc('login');
					session("tys_manager_login", '1');
					$this->success('登陆成功', U('Manager/operation'));
				}
			}
		}
		//退出
		public function loginout(){
			session("tys_manager_login",NULL);
			// $condition['openid']=$this->wecha_id;
			// D('Custom')->where($condition)->setDec('login');
			$this->success('退出成功', U('Manager/index'));
		}
		//管理操作
		public function operation(){
			$db=D('Doctor');
			//显示分页
			$count      = count($db->select());       
	        $Page       = new Page($count,6);//每页显示一个
	    	$show       = $Page->show();
	    	$this->assign('page',$show);

			$doctor=$db->limit($Page->firstRow.','.$Page->listRows)->select();
			$this->assign('doctor',$doctor);
			$this->display();
		}
		//判断孕育师账号是否存在(AJAX)
		public function judgeDoctorByUsernameAjax($username){
			$username = $this->_get('username');
			if($this->judgeDoctorByUsername($username)){
				$this->ajaxReturn('','该孕育师账号已经存在',2);
			}else{
				$this->ajaxReturn('','',1);
			}
		}
		//判断孕育师账号是否存在
		public function judgeDoctorByUsername($username){
			$db=D('Doctor');
			$where['username']=$username;
			$doctor=$db->where($where)->find();
			if($doctor){
				return true;
			}else{
				return false;
			}
		}
		//添加孕育师
		public function doctoradd(){
			if($_POST==NULL){
				//获取医院列表
				$hospital=D('Hospital')->select();
				$this->assign('hospital',$hospital);
				$this->assign('click','manager');
				$this->display();
			}else{
				$db=D('Doctor');

				if($this->judgeDoctorByUsername($_POST['username'])){
					$this->error('登陆账号已存在', U('Manager/doctoradd',array('id' => $id,'token'=>$this->token,'wecha_id'=>$this->wecha_id)));
				}

				if ($db->create() === false) {
		            $this->error($db->getError());
		        }
		        //图片处理
		        if($_FILES['pic']['tmp_name']!=NULL){
		        	import("@.ORG.UploadFile");
		        	$config = array(
		        			'savePath'      =>  'uploads/doctor/', //保存路径
		        			'thumb'             =>  true,
		        			'thumbMaxWidth'     =>  '800',// 缩略图最大宽度
		        			'thumbMaxHeight'    =>  '800',// 缩略图最大高度
		        			'thumbPath'         =>  'uploads/doctor/',// 缩略图保存路径
		        			'thumbRemoveOrigin' =>  true,// 是否移除原图
		        	);
		        	$upload=new UploadFile($config);
		        	$z=$upload->uploadOne($_FILES['pic']);
		        	if($z){
		        		$pic=$z['0']['savepath'].$z['0']['savename'];
		        	}
		        	$db->pic=$pic;
		        }
		        //判断医院是否存在
		   //      $hcondition['name']=$_POST['hname'];
		   //      $hospital=D('Hospital')->where($hcondition)->find();
		   //      if($hospital){
		   //      	$db->hid=$hospital['id'];
		   //      	D('Hospital')->where($hcondition)->setInc('doctornum');
		   //      }else{
		   //      	$data=array(
		   //      		'name'=>$_POST['hname'],
		   //      		'doctornum'=>1,
		   //      	);
		   //      	$hid=D('Hospital')->add($data);
					// $db->hid=$hid;
		   //      }

		        $id = $db->add();
		        if ($id == true) {
		            $this->success('操作成功', U('Manager/operation',array('id' => $id,'token'=>$this->token,'wecha_id'=>$this->wecha_id)));
		        } else {
		            $this->error('操作失败', U('Manager/doctoradd',array('id' => $id,'token'=>$this->token,'wecha_id'=>$this->wecha_id)));
		        }
			}
		}
		//AJAX编辑出诊时间(显示)
		public function showvisits(){
			$id=$this->_get('id','intval');
			$where['id']=$id;
			$doctor=D('Doctor')->where($where)->find();
			echo $doctor['visitstime'];
		}
		//AJAX编辑出诊时间
		public function editvisits(){
			$str=$_GET['str'];
			$str1=$_GET['str1'];
			$reg=$_GET['regular'];
			$regular='/'.$reg.'\d/';
			$replace=$str1;
			$num=preg_match_all($regular, $str,$str2);
			if($num==1){
				if($str1==''){
					$regular2='/'.$reg.'\d@/';
					$newstr=preg_replace($regular2, $str1, $str);
				}else{
					$newstr=preg_replace($regular, $str1, $str);
				}
			}elseif($num==0){
				$newstr=$str.$replace."@";
			}
				echo $newstr;
		}
		//孕育师详细
		public function doctor(){
			//获取孕育师ID
			$id=$this->_get('id','intval');
			if($id){
				$db=D('Doctor');
				$where['id']=$id;
				$doctor=$db->where($where)->find();
				$this->assign('info',$doctor);
				$this->assign('doctor',$doctor);
				$this->assign('click','no');
				$this->display();
			}
		}
	}
?>