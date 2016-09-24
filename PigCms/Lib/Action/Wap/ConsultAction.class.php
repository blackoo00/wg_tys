<?php 
	class ConsultAction extends WapAction{
		public function test(){
			$this->display();
		}
		//咨询列表
		public function index(){
			//获取医生ID
			$db=D('Doctor');
			$id=$this->_get('id','intval');
			if($id){
				$doctor=$db->find($id);
				$this->assign('doctor',$doctor);
				C('TOKEN_ON',false);
				$this->display();
			}
		}
		//插入咨询主表
		public function insert(){
			$db=D(MODULE_NAME);
			$date=$_POST;
			$arr=explode(',', $date['uppic']);
			foreach ($arr as $k=>$v){
				if($v){
					$arr2=explode("@", $v);
					$date['pic'].=$arr2['0'].",";
					$date['spic'].=$arr2['1'].",";
				}
			}
			$db2=D('Custom');
			$where['openid']=$this->wecha_id;
			$custom=$db2->where($where)->find();
			
			$date['cid']=$custom['id'];
			$date['time']=time();
			unset($date['uppic']);
			$r=$db->add($date);
			if ($r) {
				//对患者咨询次数加一8888888888888
				$db2->where("id=".$date['cid'])->setInc('consultnum'); 
				D('Doctor')->where("id=".$date['did'])->setInc('consultnums');
			    $this->success('操作成功', U('Doctor/details',array('id'=>$date['did'],'token'=>$this->token)));
			} else {
			    $this->error('操作失败', U('Doctor/details',array('id'=>$date['did'],'token'=>$this->token)));
			}
		}
		//AJAX上传图片
		public function picupsave(){
			import("@.ORG.UploadFile");
			$config = array(
					'savePath'      =>  'uploads/', //保存路径
					'thumb'             =>  true,
					'thumbMaxWidth'     =>  '800',// 缩略图最大宽度
					'thumbMaxHeight'    =>  '800',// 缩略图最大高度
					'thumbPath'         =>  'uploads/',// 缩略图保存路径
					'thumbRemoveOrigin' =>  true,// 是否移除原图
			);
			$upload=new UploadFile($config);
			$z=$upload->uploadOne($_FILES['pic']);
			if($z){
				$pic=$z['0']['savepath']."thumb_".$z['0']['savename']."@".$z['0']['savepath']."thumb_".$z['0']['savename'];
				echo json_encode($pic);
			}else{
				echo json_encode($z);
			}
		}
		//咨询主表
		public function consultm(){
			//获取医生ID
			$did=$this->_get('did','intval');
			// $dconsult=$db->relation(true)->where('did='.$did)->select();
			// $this->assign('info',$dconsult);
			$condition1['did']=$did;
			$condition1['new']=1;
			$consult1=D('Consult')->relation(true)->where($condition1)->order('time desc')->select();
			$condition2['did']=$did;
			$condition2['new']=0;
			$consult2=D('Consult')->relation(true)->where($condition2)->order('time desc')->select();
			$this->assign('consult1',$consult1);
			$this->assign('consult2',$consult2);
			$this->display();
		}
		//咨询支表
		public function consultb(){
			$did=$this->_get('did','intval');
			$cid=$this->_get('cid','intval');
			$where['did']=$did;
			$where['cid']=$cid;
			$cmid=D('Consult')->field('id')->where($where)->find();
			$doctor = M('Doctor_list')->where(array('id'=>$did))->find();
			if($cmid){
				$cmid=$cmid['id'];
				$data['cnew']=0;
				D('Consult')->where($where)->save($data);
			}else{
				$newconsult=array(
					'did'=>$did,
					'cid'=>$cid,
					'time'=>time(),
				);
				$cmid=D('Consult')->add($newconsult);
				if(!$cmid){
					$this->error("系统出错");
				}
			}
			$condition['cmid']=$cmid;
			$consultb=D('Consultb')->where($condition)->limit(6)->order('time desc')->select();
			krsort($consultb);
			//获取患者信息
			$custom=D('Custom')->where('id='.$cid)->find();
			$this->assign('custom',$custom);
			$this->assign('cmid',$cmid);
			$this->assign('did',$did);
			$this->assign('doctor',$doctor);
			$this->assign('consultb',$consultb);
			$this->display();
		}
		//AJAX删除consult中的new
		public function ajaxconsultb(){
			$did=$this->_get('did','intval');
			$cid=$this->_get('cid','intval');
			$condition['did']=$did;
			$condition['cid']=$cid;
			$data['new']=0;
			$r=D('Consult')->where($condition)->save($data);
			echo $r;
		}
		//插入咨询支表
		public function insertb(){
			//获取咨询主表ID
			$id=$this->_get('id','intval');
			if($id){
				$db=D('Consultb');
				$data['cmid']=$id;
				$data['content']=$_POST['content'];
				$data['time']=time();
				if($_POST['talk']=='doctor'){
					$data['dtalk']=1;
				}
				if($_POST['talk']=='custom'){
					$data['ctalk']=1;
				}
				$r=$db->add($data);
				if($r){
					$this->redirect('Consult/consultb', array('talk'=>$_POST['talk'],'id' => $id,'token'=>$this->token,'openid'=>$this->wecha_id));
				}else{
					$this->error('发送失败');
				}
			}
		}
		//AJXA显示咨询内容
		public function showconsultb(){
			$cmid=$this->_get('cmid');
			//$conbid=$this->_get('conbid');
			$conbid=45;
			$db=D('Consultb');
			$where['cmid']=$cmid;
			$where['id']=array('gt',$conbid);
			$arr=$db->where($where)->select();
			if($arr){
				echo json_encode($arr);
			}else{
				echo json_encode($conbid);
			}
		}
		//AJAX发送咨询（患者）
		public function sendconsult(){
			$content=$this->_get('con');
			$cid=$this->_get('cid');
			$did=$this->_get('did');
			$cmid=$this->_get('cmid');
			$ccm=$this->_get('ccm');
			if($ccm==1){//重新打开一次聊天刷新记录时间
				//查询对话是否存在
				$cm=D('Consult');
				$id=$cm->where('cid='.$cid)->find();
				if($id){//存在
					$condition['did']=$did;
					$condition['cid']=$cid;
					$data['time']=time();
					$data['cnew']=1;//新打开一个聊天提示医生此处为新内容
					$data['dnew']=0;
					$data['did']=$did;//新关注的医生ID
					$cm->where($condition)->save($data);
				}else{//不存在
					$data=array(
						'cid'=>$cid,
						'did'=>$did,
						'cnew'=>1,//新打开一个聊天提示医生此处为新内容
						'time'=>time(),
					);
					$cm->add($data);
					D('Doctor')->where('id='.$did)->setInc('consultnums');
				}
			}
			//获取头像
			$condition['openid']=$this->wecha_id;
			$pic=D('Custom')->field('pic')->where($condition)->find();
			$pic=$pic['pic'];
			$db=D('Consultb');
			$data=array(
				'cid'=>$cid,
				'did'=>$did,
				'cmid'=>$cmid,
				'content'=>$content,
				'dtalk'=>0,
				'ctalk'=>1,
				'time'=>time(),
				'pic' =>$pic,
				'year'=>date('Y',time()),
				'month'=>date('m',time()),
				'day'=>date('d',time()),
			);
			$id=$db->add($data);
			if($id){
				$str.="<div class='message right'>";
				$str.=        "<span>".friendlyDate(time(),'normal',false)."</span>";
				$str.= 	"<input type='hidden' id='time' value='".time()."'>";
		        $str.=	"<img src='".$pic."' />";
		        $str.=    "<div class='bubble'>";
		        $str.=    	$content;
		       	// $str.=        "<span>".friendlyDate($v['time'],'normal',false)."</span>";
		        $str.=    "</div>";
		        $str.=    "<div class='clear'></div>";
		        // $str.=        "<span>".friendlyDate(time(),'normal',false)."</span>";
		        $str.="</div>";
		        echo $str;
			}else{
				echo 'error';
			}
		}
		//AJAX发送咨询（医生）
		public function sendconsult2(){
			$content=$this->_get('con');
			$cid=$this->_get('cid');
			$did=$this->_get('did');
			$cmid=$this->_get('cmid');
			$ccm=$this->_get('ccm');
			if($ccm==1){//重新打开一次聊天刷新记录时间
				//查询对话是否存在
				$cm=D('Consult');
				$id=$cm->where('did='.$did)->find();
				if($id){//存在
					$condition['did']=$did;
					$condition['cid']=$cid;
					$data['time']=time();
					$data['dnew']=1;//新打开一个聊天提示医生此处为新内容
					$data['cnew']=0;
					$data['cid']=$cid;
					$cm->where($condition)->save($data);
				}else{//不存在
					$data=array(
						'cid'=>$cid,
						'did'=>$did,
						'dnew'=>1,//新打开一个聊天提示医生此处为新内容
						'time'=>time(),
					);
					$cm->add($data);
					D('Doctor')->where('id='.$did)->setInc('consultnums');
				}
			}
			//获取头像
			$condition['openid']=$this->wecha_id;
			$pic=D('Doctor')->field('pic')->where($condition)->find();
			$pic=$pic['pic'];

			$db=D('Consultb');
			$data=array(
				'cid'=>$cid,
				'did'=>$did,
				'cmid'=>$cmid,
				'content'=>$content,
				'dtalk'=>1,
				'ctalk'=>0,
				'time'=>time(),
				'pic' =>$pic,
				'year'=>date('Y',time()),
				'month'=>date('m',time()),
				'day'=>date('d',time()),
			);
			$id=$db->add($data);
			if($id){
				$str.="<div class='message right'>";
				$str.=        "<span>".friendlyDate(time(),'normal',false)."</span>";
				$str.= 	"<input type='hidden' id='time' value='".time()."'>";
		        $str.=	"<img src='".$pic."' />";
		        $str.=    "<div class='bubble'>";
		        $str.=    	$content;
		        $str.=    "</div>";
		        $str.=    "<div class='clear'></div>";
		        $str.="</div>";
		        echo $str;
			}else{
				echo 'error';
			}
		}
		//AJAX刷新咨询信息
		public function refreshconsult(){
			$time=$this->_get('time');
			$cid=$this->_get('cid');
			$did=$this->_get('did');
			$db=D('Consultb');

			$condition['did']=$did;
			$condition['cid']=$cid;
			$condition['time']=array('gt',$time);
			$consultb=$db->where($condition)->select();
			if($consultb){
				foreach ($consultb as $k => $v) {
					if($v['dtalk']==1){
							$str.="<div class='message left'>";
					}
					if($v['ctalk']==1){
						$str.="<div class='message right'>";
					}
					$str.=        "<span>".friendlyDate($v['time'],'normal',false)."</span>";
					$str.= 	"<input type='hidden' id='time' value='".$v['time']."'>";
			        $str.=	"<img src='".$v['pic']."' />";
			        $str.=    "<div class='bubble'>";
			        $str.=    	$v['content'];
			       	// $str.=        "<span>".friendlyDate($v['time'],'normal',false)."</span>";
			        $str.=    "</div>";
			        $str.=    "<div class='clear'></div>";
			        // $str.=        "<span>".friendlyDate($v['time'],'normal',false)."</span>";
			        $str.="</div>";
				}
					echo $str;
			}else{
				echo "none";
			}
		}
		//AJAX刷新咨询信息(医生)
		public function refreshconsult2(){
			$time=$this->_get('time');
			$cid=$this->_get('cid');
			$did=$this->_get('did');
			$db=D('Consultb');

			$condition['did']=$did;
			$condition['cid']=$cid;
			$condition['time']=array('gt',$time);
			$consultb=$db->where($condition)->select();
			if($consultb){
				foreach ($consultb as $k => $v) {
					if($v['dtalk']==1){
							$str.="<div class='message right'>";
					}
					if($v['ctalk']==1){
						$str.="<div class='message left'>";
					}
					$str.=        "<span>".friendlyDate($v['time'],'normal',false)."</span>";
					$str.= 	"<input type='hidden' id='time' value='".$v['time']."'>";
			        $str.=	"<img src='".$v['pic']."' />";
			        $str.=    "<div class='bubble'>";
			        $str.=    	$v['content'];
			        $str.=    "</div>";
			        $str.=    "<div class='clear'></div>";
			        $str.="</div>";
				}
					echo $str;
			}else{
				echo "none";
			}
		}
		//AJAX上拉加载
		public function loadmore(){
			$cmid=$this->_get("cmid","intval");
			$cnums=$this->_get("cnums");
			$consultb=D("Consultb")->where("cmid=".$cmid)->limit($cnums.",".($cnums+10))->order('time desc')->select();
			krsort($consultb);
			if($consultb){
				foreach ($consultb as $k => $v) {
					if($v['dtalk']==1){
						$str.="<div class='message right'>";
					}
					if($v['ctalk']==1){
						$str.="<div class='message'>";
					}
					$str.=        "<span>".friendlyDate($v['time'],'normal',false)."</span>";
					$str.= 	"<input type='hidden' id='time' value='".$v['time']."'>";
			        $str.=	"<img src='".$v['pic']."' />";
			        $str.=    "<div class='bubble'>";
			        $str.=    	$v['content'];
			       	// $str.=        "<span>".friendlyDate($v['time'],'normal',false)."</span>";
			        $str.=    "</div>";
			        $str.=    "<div class='clear'></div>";
			        // $str.=        "<span>".friendlyDate(time(),'normal',false)."</span>";
			        $str.="</div>";
				}
			}else{
			    $str="none";
			}
	        echo $str;
		}
		//群发
		public function allsend(){
			$did=$this->_get('did','intval');
			$con=$this->_get('con');
			$doctor=D('Doctor')->field('id,pic')->where('id='.$did)->relation('custom')->find();
			$cidarr=$doctor['custom'];
			if($cidarr==NULL){
				echo "nocustom";
				exit();
			}
			// echo "<pre>";
			// var_dump($doctor);
			// echo "</pre>";
			// exit();
			//通过患者ID循环创建咨询主表
			foreach ($cidarr as $k => $v) {
				//先查询该主表是否存在
				$condition['did']=$did;
				$condition['cid']=$v['id'];
				$cmid=D('Consult')->where($condition)->find();
				if($cmid){//存在主表
					$data=array(
						'did'=>$did,
						'cid'=>$v['id'],
						'dnew'=>1,
						'cnew'=>0,
					);
					$cmid2=D('Consult')->where($condition)->save($data);//新建咨询主表

					$data=array(
						'pic'=>$doctor['pic'],
						'cmid'=>$cmid['id'],
						'did'=>$did,
						'cid'=>$v['id'],
						'dtalk'=>1,
						'content'=>$con,
						'time'=>time(),
						'year'=>date('Y',time()),
						'month'=>date('m',time()),
						'day'=>date('d',time()),
					);
					$ccid=D('Consultb')->add($data);
					if($ccid){
						echo "ok";
					}
				}else{//不存在主表先建立主表
					$data=array(
						'did'=>$did,
						'cid'=>$v['id'],
						'dnew'=>1,
					);
					$cmid2=D('Consult')->add($data);//新建咨询主表

					$data2=array(
						'pic'=>$doctor['pic'],
						'cmid'=>$cmid2,
						'did'=>$did,
						'cid'=>$v['id'],
						'dtalk'=>1,
						'content'=>$con,
						'time'=>time(),
						'year'=>date('Y',time()),
						'month'=>date('m',time()),
						'day'=>date('d',time()),
					);
					$ccid=D('Consultb')->add($data2);//添加咨询对话
					if($ccid){
						echo "ok";
					}
				}
			}
		}

		//群发页面
		public function allsendpage(){
			$did=$this->_get("did","intval");
			$this->assign('did',$did);
			$this->display();
		}
	}
?>