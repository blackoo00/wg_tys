<?php 
	class DoctorAction extends WapAction{
		public function __construct(){
			parent::_initialize();
			$where['openid']=$this->wecha_id;
			$doctor=D(MODULE_NAME)->where($where)->relation(true)->find();
			if(!$doctor){
				$this->error('请先登陆',U('Doctor/login'));
			}
				 // if($doctor['login']==0&&ACTION_NAME!='index'&&ACTION_NAME!='myqrcode'&&ACTION_NAME!='login'){
					// $this->redirect(U('Doctor/index',array('token'=>$this->token,'wecha_id'=>$this->wecha_id)));
				 // }
		}
		//登陆页面
		public function index(){
			//显示医院列表
			// $db=D('Hospital');
			// $id=$this->_get('id','intval');
			// if($id){
			// 	$hospital=$db->find($id);
			// 	$this->assign('hospital',$hospital);
			// }
			// //显示医生列表
			// $db=D(MODULE_NAME);
			// if($id){
			// 	$where['hid']=$id;
			// }
			// $doctor=$db->where($where)->select();
			// $this->assign('dnum',count($doctor));
			// $this->assign('doctor',$doctor);
			// $this->display();

			//登陆页面
			// $where['openid']=$this->wecha_id;
			// $doctor=D(MODULE_NAME)->where($where)->relation(true)->find();
			//  if($doctor['login']==1){
			// 	//$this->redirect(U('Doctor/personal',array('did'=>$doctor['id'],'token'=>$this->token,'wecha_id'=>$this->wecha_id)));
			//  }
			$this->display();
		}
		//登陆判断
		public function login(){
			if(IS_POST){
				$db=D('Doctor');
				$where['username']=$_POST['username'];
				$doctor=$db->where($where)->find();
				if(!$doctor){//账号不存在
					$this->error('账号或密码不正确',U('Doctor/index',array('token'=>$this->token,'wecha_id'=>$this->wecha_id)));
				}
				if($doctor['password']!=md5($_POST['password'])){//密码错误
					$this->error('账号或密码不正确',U('Doctor/index',array('token'=>$this->token,'wecha_id'=>$this->wecha_id)));
				}
				if($doctor['openid']==$this->wecha_id||$doctor['openid']==NULL){
						$where['id']=$doctor['id'];
						//设置二维码
						// if($doctor['qrcode']==NULL){
						// 	$qrcode=$this->makeCode($this->token,$this->wecha_id,$doctor['id']);
						// 	$qrcode='https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$qrcode;
						// 	$data['qrcode']=$qrcode;
						// }
						//设置微信ID
						if($doctor['openid']==NULL){
							$data['openid']=$this->wecha_id;
						}
						$data['login']=1;
						$db->where($where)->save($data);
						$this->success('登陆成功',U('Doctor/personal',array('token'=>$this->token,'wecha_id'=>$this->wecha_id)));
				}else{//该账号已经被人使用
					$this->error('该账号已经被人使用',U('Doctor/index',array('token'=>$this->token,'wecha_id'=>$this->wecha_id)));
				}
			}else{
				$this->display();
			}
		}
		//退出
		// public function loginout(){
		// 	$db=D('Doctor');
	 //        $where['openid']=$this->wecha_id;
	 //        $data['login']=0;
	 //        $r=$db->where($where)->save($data);
	 //        if($r){
	 //        	$this->success('退出成功',U('Doctor/index',array('token'=>$this->token,'wecha_id'=>$this->wecha_id)));
	 //        }
		// }
		//通过医生ID查询有没有新的患者咨询
		public function check_custom_consult($did){
			$db=D('Consult');
			$where['did']=$did;
			$check=0;
			$cm=$db->where($where)->select();
			foreach ($cm as $k => $v) {
				if($v['cnew']==1){
					$check=1;
				}
			}
			return $check;
		}
		//我的患者
		public function custom(){
			$db=D('Doctor');

			$where[openid]=$this->wecha_id;
			$doctor=$db->where($where)->find();
			//判断有没患者咨询
			$check=$this->check_custom_consult($doctor['id']);
			$this->assign('check',$check);
			// if($doctor['login']==0){
			// 	$this->redirect(U('Doctor/index',array('token'=>$this->token,'wecha_id'=>$this->wecha_id)));
			// }
			$db2=D('Custom');
			$where2['did']=$doctor['id'];
			//显示分页
			$count      = count($db2->where($where2)->select());       
	        $Page       = new Page($count,9);//每页显示一个
	    	$show       = $Page->show();
	    	$this->assign('page',$show);
	    	
			$custom=$db2->where($where2)->relation(true)->limit($Page->firstRow.','.$Page->listRows)->select();
			$this->assign('custom',$custom);
			$this->assign('doctor',$doctor);
			$this->display();
			
		}
		//患者详细
		public function cdetails(){
			$id=$this->_get('id','intval');
			$db=D('Custom');
			$custom=$db->relation(true)->where('id='.$id)->find();
			$this->assign('custom',$custom);
			$this->assign('doctor',$custom['doctor']);
			//判断有没患者咨询
			$check=$this->check_custom_consult($custom['doctor']['id']);
			$this->assign('check',$check);
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
		//个人中心
		public function personal(){
			// $did=$this->_get('did','intval');
			// echo $did;
			// echo "<br>";
			// echo $this->wecha_id;
			$db=D(MODULE_NAME);
			$where['openid']=$this->wecha_id;
			$doctor=$db->where($where)->relation(true)->find();
			//判断有没患者咨询
			$check=$this->check_custom_consult($doctor['id']);
			$this->assign('check',$check);
			if($this->_get('did','intval')){
				$did=$this->_get('did','intval');
				$doctor=$db->where("id=".$did)->relation(true)->find();
			}
			
		 	$this->assign('doctor',$doctor);
		 	//今日咨询数
		 	$t1=strtotime('today');
		 	$t2=$t1+86400;
		 	$condition['did']=$doctor['id'];
		 	$condition['time']=array('between',array($t1,$t2));
		 	$dconsultnums=D('Consult')->where($condition)->count();

		 	$this->assign('dconsultnums',$dconsultnums);
		 	$this->assign('click',"no");
		 	$this->display();
			 
		}
		//AJAX编辑出诊时间(显示)
		public function showvisits(){
			$id=$this->_get('id','intval');
			if($id){
				$where['id']=$id;
			}else{
				$where['openid']=$this->wecha_id;
			}
			$doctor=D('Doctor')->where($where)->find();
			echo $doctor['visitstime'];
		}
		//AJAX编辑出诊时间(修改)
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
			$db=D(MODULE_NAME);
			$where['openid']=$this->wecha_id;
			$data['visitstime']=$newstr;
			$r=$db->where($where)->save($data);
			if($r){
				echo $newstr;
			}
		}
		//AJAX上传个人头像
		public function headpic(){
			import("@.ORG.UploadFile");
			$config = array(
					'savePath'      =>  'uploads/doctor/', //保存路径
					'thumb'             =>  true,
					'thumbMaxWidth'     =>  '800',// 缩略图最大宽度
					'thumbMaxHeight'    =>  '800',// 缩略图最大高度
					'thumbPath'         =>  'uploads/doctor/',// 缩略图保存路径
					'thumbRemoveOrigin' =>  true,// 是否移除原图
			);
			//上传图片
			$upload=new UploadFile($config);
			$z=$upload->uploadOne($_FILES['pic']);
			if($z){
				$pic=$z['0']['savepath']."thumb_".$z['0']['savename'];
				$data['pic']=$pic;
				$db=D('Doctor');
				$id=$db->where('id='.$_POST['id'])->save($data);
				if($id){
					echo json_encode($pic);
				}
				//echo json_encode($pic);
			}else{
				echo json_encode($z);
			}
		}
		//二维码
		public function makeCode($token,$wecha_id,$mid){
			$api=M('Diymen_set')->where(array('token'=>$token))->find();
			//dump($api);
			if($api['appid']==false||$api['appsecret']==false){$this->error('必须先填写【AppId】【 AppSecret】');exit;}
			//获取微信认证

			$url_get='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$api['appid'].'&secret='.$api['appsecret'];
			$json=json_decode($this->curlGet($url_get));
			$qrcode_url='https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$json->access_token;
			//{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": 123}}}
			$data['action_name']='QR_LIMIT_SCENE';
			$data['action_info']['scene']['scene_id']=$mid;
			$data['action_info']['scene']['scene_id']=$mid;
			$post=$this->api_notice_increment($qrcode_url,json_encode($data));
			//if($post ==false ) $this->error('微信接口返回信息错误，请联系管理员');
			M('membercode')->where(array('token'=>$token,'wecha_id'=>$wecha_id))->delete();
			M('membercode')->add(array('token'=>$token,'wecha_id'=>$wecha_id,'mid'=>$mid,'code_url'=>$post));
			return $post;
		}
		function api_notice_increment($url, $data){
		$ch = curl_init();
		$header = "Accept-Charset: utf-8";
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$tmpInfo = curl_exec($ch);
		$errorno=curl_errno($ch);
		if ($errorno) {
			$this->error('发生错误：curl error'.$errorno);
			
		}else{

			$js=json_decode($tmpInfo,1);
			
			if (!$js['errcode']){
				return $js['ticket'];
			}else {
				$this->error('发生错误：错误代码'.$js['errcode'].',微信返回错误信息：'.$js['errmsg']);
			}
		}
	}
		//每日咨询数AJAX
		public function dailyconsult(){
			$db=D('Doctor');
			$where['openid']=$this->_get('wecha_id');
			$data['dailyconsult']=$this->_get('dailyconsult');
			$r=$db->where($where)->save($data);
			if($r||$r==0){
				echo 1;
			}
		}
		//咨询主列表
		public function consultm(){
			$db2=D('Doctor');
			$where['openid']=$this->wecha_id;
			$doctor=$db2->where($where)->find();
			$id=$doctor['id'];
			if($id){
				$db=D('Consult');
				$where['did']=$id;
				//显示分页
				$count      = count($db->where($where)->select());       
		        $Page       = new Page($count,6);//每页显示一个
		    	$show       = $Page->show();
		    	$this->assign('page',$show);

				$consult=$db->where($where)->relation(true)->limit($Page->firstRow.','.$Page->listRows)->select();
				$this->assign('consult',$consult);
				$this->assign('doctor',$doctor);
				$this->display();
			}
		}
		//咨询支表
		public function consultb(){
			//获取咨询主表ID
			$id=$this->_get('id','intval');
			$db=D('Consultb');
			$db2=D('Consult');
			if($id){
				$this->assign('cmid',$id);
				//获取咨询支表信息
				$where['cmid']=$id;
				$consultb=$db->where($where)->order('time asc')->select();
				$this->assign('consultb',$consultb);

				//通过咨询主表获取患者医生信息
				$where['id']=$id;
				$dc=$db2->relation(true)->where($where)->find();
			}
			$this->assign('customname',$dc['custom']['name']);
			$this->assign('doctorname',$dc['doctor']['name']);
			$this->display();
		}
		//反馈列表
		public function feedback(){
			//获取咨询主表ID
			$id=$this->_get('id','intval');
			$db=D('Feedback');
			$db2=D('Doctor');
			if($id){
				$this->assign('id',$id);
				//获取咨询支表信息
				$where['did']=$id;
				$list=$db->where($where)->order('id desc')->select();
				$this->assign('list',$list);
				//通过咨询主表获取患者医生信息
				$where1['id']=$id;
				$doctor=$db2->where($where1)->find();
			}
			//判断有没患者咨询
			$check=$this->check_custom_consult($doctor['id']);
			$this->assign('check',$check);

			$this->assign('doctor',$doctor);
			$this->display();
		}
		//插入反馈
		public function insertFeedback(){
			//获取咨询主表ID
			$id=$this->_get('id','intval');
			if($_POST['content']==''){
				$this->error('反馈内容不能为空！');
			}
			if($id){
				$db=D('Feedback');
				$data=array(
					'did'=>$id,
					'info'=>$_POST['content'],
					'time'=>time(),
					'status'=>0,
				);
				$r=$db->add($data);
				if($r){
					$this->success('提交成功', array('id' => $id,'token'=>$this->token,'wecha_id'=>$this->wecha_id));
				}else{
					$this->error('提交失败');
				}
			}
		}
		//插入咨询支表
		public function insert(){
			//获取咨询主表ID
			$id=$this->_get('id','intval');
			if($id){
				$db=D('Consultb');
				$data=array(
					'cmid'=>$id,
					'dtalk'=>1,
					'ctalk'=>0,
					'content'=>$_POST['content'],
					'time'=>time(),
				);
				$r=$db->add($data);
				if($r){
					$this->redirect('Doctor/consultb', array('id' => $id,'token'=>$this->token,'wecha_id'=>$this->wecha_id));
				}else{
					$this->error('发送失败');
				}
			}
		}
		//登陆信息修改
		public function modify(){
			$db=D('Doctor');
			$where['openid']=$this->wecha_id;
			$doctor=$db->relation(true)->where($where)->find();
			//判断有没患者咨询
			$check=$this->check_custom_consult($doctor['id']);
			$this->assign('check',$check);
			if($_POST==NULL){
				$this->assign('doctor',$doctor);
				$this->assign('click','yes');
				$this->display();
			}else{
				if ($db->create() === false) {
		            $this->error($db->getError());
		        }else{
					$id = $db->save();
					if ($id == true||$id == 0) {
					    $this->success('操作成功', U('Doctor/personal',array('id' => $id,'token'=>$this->token,'wecha_id'=>$this->wecha_id)));
					} else {
					    $this->error('操作失败', U('Doctor/personal',array('id' => $id,'token'=>$this->token,'wecha_id'=>$this->wecha_id)));
					}
				}
			}
		}
		//医生详细
		public function details(){
			$db=D(MODULE_NAME);
			//获取用户openid
			//医生ID
			$id=$this->_get('id','intval');
			if($id){
				$doctor=$db->relation(true)->find($id);
				$this->assign('doctor',$doctor);
			}else{
				$this->error("跳转出错");
				// $where['openid']=$this->wecha_id;
				// $custom=D('Custom')->field('did')->where($where)->find();
				// $doctor=$db->relation(true)->find($custom['did']);
				// $this->assign('doctor',$doctor);
			}
			$this->assign('click',"no");
			$this->display();
		}
		//我的二维码
		public function myqrcode(){
			$did=$this->_get('id','intval');
			$doctor=D('Doctor')->where('id='.$did)->find();
			$this->assign("doctor",$doctor);
			$this->display();
		}
		//化验单大图
		public function bigpic(){
			$src=$this->_get('src');
			$this->assign('src',$src);
			$this->display();
		}
	}
 ?>