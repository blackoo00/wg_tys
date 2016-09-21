<?php
class DistributionAction extends WapAction{
	private $my;
    public function __construct(){
        parent::_initialize();
		$agent = $_SERVER['HTTP_USER_AGENT']; 
		if(!strpos($agent,"icroMessenger")) {
			//echo '此功能只能在微信浏览器中使用';exit;
		}
		$token		= $this->_get('token');
		$wecha_id	= $this->wecha_id;
        $this->assign('token',$token);
		$my = M('Distribution_member')->where(array('token'=>$token,'wecha_id'=>$wecha_id))->find();
		if(!$my){
			if(ACTION_NAME!='forward'&&ACTION_NAME!='intro'&&ACTION_NAME!='autoHandle'&&ACTION_NAME!='myScanner'){
				/*$db = M('Distribution_member');
				$user_info = $this->get_user_info();
				$mydata['nickname'] = $user_info['nickname'];
				$mydata['headimgurl'] = $user_info['headimgurl'];
				$mydata['wecha_id'] = $wecha_id;
				$mydata['token'] = $token;
				$mydata['createtime'] = time();
				$mydata['status'] = 1;
				if($myid = $db->add($mydata)){
					$click = M('Distribution_click')->where(array('token'=>$token,'wecha_id'=>$wecha_id))->find();
					$set = M('Distribution_set')->where(array('token'=>$token))->find();
					if($click&&$click['mid']!=0){
						$from_member = $db->where('id='.$click['mid'])->find();
						if($from_member){
							$memberData['bindmid'] = $from_member['id'];
							$db->where('id='.$myid)->save($memberData);//绑定所属会员id
							if($db->where(array('token'=>$token,'wecha_id'=>$wecha_id,'id'=>array('neq',$myid)))->find()){
								$db->where('id='.$myid)->delete();
							}else{
								$db->where('id='.$from_member['id'])->setInc('followNums');//关注累加
								$db->where('id='.$from_member['id'])->setInc('firstNums');//一级会员累加
								$leveData['fid'] = $from_member['id'];
								if($from_member['fid']!=0){
									$db->where('id='.$from_member['fid'])->setInc('secondNums');//二级会员累加
									$leveData['sid'] = $from_member['fid'];
								}
								if($from_member['sid']!=0){
									$db->where('id='.$from_member['sid'])->setInc('thirdNums');//三级会员累加
									$leveData['tid'] = $from_member['sid'];
								}
								$leveData['handle'] = 1;//处理结束
								$db->where('id='.$myid)->save($leveData);//会员所属绑定
							}
						}else{
							if($db->where(array('token'=>$token,'wecha_id'=>$wecha_id,'id'=>array('neq',$myid)))->find()){
								$db->where('id='.$myid)->delete();
							}
						}
					}else{
						if($db->where(array('token'=>$this->token,'wecha_id'=>$wecha_id,'id'=>array('neq',$myid)))->find()){
							$db->where('id='.$myid)->delete();
						}
					}
				}*/
				exit('异常访问');
			}
		}else{
			if($my['handle']==0&&$my['bindmid']!=0){
				$db = M('Distribution_member');
				$from_member = $db->where('id='.$my['bindmid'])->find();
				$db->where('id='.$my['bindmid'])->setInc('followNums');//关注累加
				$db->where('id='.$my['bindmid'])->setInc('firstNums');//一级会员累加
				if($from_member){
					$leveData['fid'] = $from_member['id'];
				}
				if($from_member&&$from_member['fid']!=0){
					$db->where('id='.$from_member['fid'])->setInc('secondNums');//二级会员累加
					$leveData['sid'] = $from_member['fid'];
				}
				if($from_member&&$from_member['sid']!=0){
					$db->where('id='.$from_member['sid'])->setInc('thirdNums');//三级会员累加
					$leveData['tid'] = $from_member['sid'];
				}
				$leveData['handle'] = 1;//处理结束
				$db->where('id='.$my['id'])->save($leveData);//会员所属绑定
			}
			$my['recommended'] = M('Distribution_member')->where('id='.$my['bindmid'])->getField('nickname');
		}
		$this->my = $my;
		$set = M('Distribution_set')->where(array('token'=>$token))->find();
		$totalMoney = M('Distribution_ordermoney')->where(array('token'=>$token,'mid'=>$my['id'],'status'=>array('gt',0)))->sum('orderMoney');//累计销售
		$totalOfferMoney = M('Distribution_ordermoney')->where(array('token'=>$token,'mid'=>$my['id'],'status'=>array('gt',0)))->sum('offerMoney');//累计佣金
		$this->assign('totalMoney',$totalMoney);
		$this->assign('totalOfferMoney',$totalOfferMoney);
		$this->assign('set',$set);
        $this->assign('my',$my);
    }
	public function index(){
		$token		= $this->_get('token');
		$wecha_id	= $this->wecha_id;
		$totalScore = M('product_cart')->where(array('token'=>$token,'wecha_id'=>$wecha_id,'handled'=>1))->sum('price');
		$order['status_4'] = M('Distribution_ordermoney')->where(array('token'=>$token,'mid'=>$this->my['id'],'status'=>4))->sum('offerMoney');//已审核
		$this->assign('order',$order);
		$this->assign('totalScore',$totalScore);
		$this->display();
	}
	public function myDistribution(){
		$id = $this->my['id'];
		$token = $this->_get('token');
		$wecha_id = $this->wecha_id;
		if($this->my['distritime']==0){
			$access_token = $this->get_access_token();
			$set = M('Distribution_forward_set')->where(array('token'=>$token))->find();
			$data = '{"touser":"'.$wecha_id.'","msgtype":"news","news":{"articles":[{"title":"'.$set['fxtitle'].'","description":"'.$set['fxtext'].'","url":"'.$set['fxurl'].'","picurl":"'.$set['fxpic'].'"]}}';
			$result = $this->api_notice_increment('https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$access_token,$data);
			$url = U('Distribution/index',array('token'=>$token,'wecha_id'=>$wecha_id,'notBe'=>1));
			$this->redirect($url);//跳回
		}
		$db = M('Distribution_ordermoney');
		$order['status_0'] = $db->where(array('token'=>$token,'mid'=>$id,'status'=>0))->sum('offerMoney');//未付款
		$order['status_1'] = $db->where(array('token'=>$token,'mid'=>$id,'status'=>1))->sum('offerMoney');//已付款
		$order['status_2'] = $db->where(array('token'=>$token,'mid'=>$id,'status'=>2))->sum('offerMoney');//未收货
		$order['status_3'] = $db->where(array('token'=>$token,'mid'=>$id,'status'=>3))->sum('offerMoney');//已收货
		$order['status_-1'] = $db->where(array('token'=>$token,'mid'=>$id,'status'=>-1))->sum('offerMoney');//已退款
		$order['status_4'] = $db->where(array('token'=>$token,'mid'=>$id,'status'=>4))->sum('offerMoney');//已审核
		$distriCount = M('Distribution_member')->where(array('token'=>$token,'bindmid'=>$id,'distritime'=>array('neq',0)))->count();
		$orderNums = $db->where(array('token'=>$token,'mid'=>$id,'status'=>array('gt',0)))->count();
		$this->assign('orderNums',$orderNums);
		$this->assign('distriCount',$distriCount);
		$this->assign('order',$order);
		$this->display();
	}
	public function memberList(){
		$token		= $this->_get('token');
		$type		= $this->_get('type');
		$wecha_id	= $this->wecha_id;
		if($type=='first'){
			$condition['fid'] = $this->my['id'];
			$flag = 1;
			$level = 'A';
		}
		if($type=='second'){
			$condition['sid'] = $this->my['id'];
			$flag = 1;
			$level = 'B';
		}
		if($type=='third'){
			$condition['tid'] = $this->my['id'];
			$flag = 1;
			$level = 'C';
		}
		if($flag!=1){
			exit('异常访问');
		}
		$condition['token'] = $token;
		//$condition['wecha_id'] = $wecha_id;
		$db = M('Distribution_member');
		$member = $db->where($condition)->order('id desc')->select();
		$this->assign('member',$member);
		$this->assign('level',$level);
		$this->display();
	}
	public function memberAllList(){
		$token		= $this->_get('token');
		$wecha_id	= $this->wecha_id;
		/*$condition['fid'] = $this->my['id'];
		$condition['sid'] = $this->my['id'];
		$condition['tid'] = $this->my['id'];
		$condition['_logic'] = 'or';
		$map['_complex'] = $condition;*/
		$map['bindmid'] = $this->my['id'];
		$map['token'] = $token;
		$map['distritime'] = array('neq',0);
		//$condition['wecha_id'] = $wecha_id;
		$db = M('Distribution_member');
		$member = $db->where($map)->order('id desc')->select();
		$this->assign('member',$member);
		$this->display();
	}
	public function agentList(){
		$token		= $this->_get('token');
		$mid		= $this->_get('mid');
		$type		= $this->_get('type');
		$wecha_id	= $this->wecha_id;
		if($type=='first'){
			$condition['fid'] = $mid;
			$flag = 1;
			$level = 'A';
		}
		if($type=='second'){
			$condition['sid'] = $mid;
			$flag = 1;
			$level = 'B';
		}
		if($type=='third'){
			$condition['tid'] = $mid;
			$flag = 1;
			$level = 'C';
		}
		if($flag!=1){
			exit('异常访问');
		}
		$condition['token'] = $token;
		//$condition['wecha_id'] = $wecha_id;
		$db = M('Distribution_member');
		$childmember = $db->where($condition)->order('id desc')->select();
		$this->assign('childmember',$childmember);
		$this->assign('level',$level);
		$this->display();
	}
	public function clickList(){
		$token		= $this->_get('token');
		$wecha_id	= $this->wecha_id;
		$condition['token'] = $token;
		$condition['mid'] = $this->my['id'];
		$db = M('Distribution_click');
		$click = $db->where($condition)->order('id desc')->select();
		$this->assign('click',$click);
		$this->display();
	}
	public function followList(){
		$token		= $this->_get('token');
		$wecha_id	= $this->wecha_id;
		$condition['token'] = $token;
		$condition['bindmid'] = $this->my['id'];
		$db = M('Distribution_member');
		$follow = $db->where($condition)->order('id desc')->select();
		$this->assign('follow',$follow);
		$this->display();
	}
	public function memberIndex(){
		$token		= $this->_get('token');
		$id	= $this->_get('id');
		$wecha_id	= $this->wecha_id;
		$member = M('Distribution_member')->where(array('token'=>$token,'id'=>$id))->find();
		$db = M('Distribution_ordermoney');
		$member['first_member_totalMoney'] = $db->where(array('type'=>'fid','mid'=>$id,'token'=>$token,'status'=>array('gt',0)))->sum('orderMoney');
		$member['first_member_offerMoney'] = $db->where(array('type'=>'fid','mid'=>$id,'token'=>$token,'status'=>array('gt',0)))->sum('offerMoney');
		$member['second_member_totalMoney'] = $db->where(array('type'=>'sid','mid'=>$id,'token'=>$token,'status'=>array('gt',0)))->sum('orderMoney');
		$member['second_member_offerMoney'] = $db->where(array('type'=>'sid','mid'=>$id,'token'=>$token,'status'=>array('gt',0)))->sum('offerMoney');
		$member['third_member_totalMoney'] = $db->where(array('type'=>'tid','mid'=>$id,'token'=>$token,'status'=>array('gt',0)))->sum('orderMoney');
		$member['third_member_offerMoney'] = $db->where(array('type'=>'tid','mid'=>$id,'token'=>$token,'status'=>array('gt',0)))->sum('offerMoney');
		$offerMoney = $db->where(array('from_mid'=>$id,'mid'=>$this->my['id'],'token'=>$token,'status'=>4))->sum('offerMoney');
		$this->assign('offerMoney',$offerMoney);
		$this->assign('member',$member);
		$this->display();
	}
	public function getMoney(){
		$token	= $this->_get('token');
		$wecha_id	= $this->wecha_id;
		$id = $this->my['id'];
		$order['status_4'] = M('Distribution_ordermoney')->where(array('token'=>$token,'mid'=>$id,'status'=>4))->sum('offerMoney');//已审核
		$this->assign('order',$order);
		if(IS_POST){
			$name = $this->_post('name');
			$bankName = $this->_post('bankName');
			$bankNumber = $this->_post('bankNumber');
			$tele = $this->_post('tele');
			$money = $this->_post('money');
			$classid = $this->_post('classid');
			$wecha_id	= $this->wecha_id;
			if($name!=''&&$bankName!=''&&$bankNumber!=''&&$tele!=''&&$money!=''&&$classid!=''){
				$data['name'] = $name;
				$data['bankName'] = $bankName;
				$data['bankNumber'] = $bankNumber;
				$data['tele'] = $tele;
				$data['classid'] = $classid;
				$data['mid'] = $this->my['id'];
				$data['wecha_id'] = $wecha_id;
				$data['money'] = $money*100;
				$data['token'] = $this->_get('token');
				$data['applytime'] = time();
				if(($order['status_4']-$this->my['alreadyGetMoney'])<$money){
					$arr = array('success'=>-1,'info'=>'提现金额超出可提现值');
					echo json_encode($arr);
					exit;
				}
				if(M('Distribution_applystore')->add($data)){
					M('Distribution_member')->where('id='.$this->my['id'])->setInc('alreadyGetMoney',$money*100);
					$bank = M('Distribution_bank')->where(array('token'=>$token,'wecha_id'=>$wecha_id))->find();
					if($bank){
						$bankData['name'] = $name;
						$bankData['bankName'] = $bankName;
						$bankData['bankNumber'] = $bankNumber;
						$bankData['tele'] = $tele;
						$bankData['classid'] = $classid;
						$bankData['lasttime'] = time();
						M('Distribution_bank')->where('id='.$bank['id'])->save($bankData);
					}else{
						$bankData['token'] = $token;
						$bankData['wecha_id'] = $wecha_id;
						$bankData['name'] = $name;
						$bankData['bankName'] = $bankName;
						$bankData['bankNumber'] = $bankNumber;
						$bankData['tele'] = $tele;
						$bankData['classid'] = $classid;
						$bankData['lasttime'] = time();
						M('Distribution_bank')->add($bankData);
					}
					$arr = array('success'=>1,'info'=>'提现申请成功，请等待审核');
					echo json_encode($arr);
					exit;
				}else{
					$arr = array('success'=>0,'info'=>'提现失败');
					echo json_encode($arr);
					exit;
				}
			}else{
				$arr = array('success'=>-1,'info'=>'所有内容不能为空');
				echo json_encode($arr);
				exit;
			}
		}else{
			$bank = M('Distribution_bank')->where(array('token'=>$token,'wecha_id'=>$wecha_id))->find();
			//所属区域
			if($bank['classid']){
				import ( "@.Org.TypeFile" );
				$tid = $bank['classid'];
				$TypeFile = new TypeFile ( 'ClassCity' ); //实例化分类类
				$result = $TypeFile->getPath ( $tid ); //获取分类路径
				$this->assign ( 'typeNumArr', $result );
			}
			$this->assign('bank',$bank);
			$this->display();
		}
	}
	public function getMoneyList(){
			$token		= $this->_get('token');
			$wecha_id	= $this->wecha_id;
			$status	= $this->_get('status');
			if($status!=''){
				$condition['status'] = $status;
			}
			$condition['token'] = $token;
			$condition['wecha_id'] = $wecha_id;
			$list = M('Distribution_applystore')->where($condition)->order('id desc')->select();
			$db = M('Distribution_member');
			foreach($list as $key=>$value){
				$info = $db->where('id='.$value['mid'])->field('nickname,headimgurl')->find();
				$list[$key]['nickname'] = $info['nickname'];
				$list[$key]['headimgurl'] = $info['headimgurl'];
			}
			$this->assign('list',$list);
			$this->display();
	}
	public function getMoneyProcess(){
			$this->display();
	}
	public function myScanner(){
		$token = $this->_get('token');
		$wecha_id = $this->wecha_id;
		$mid = $this->_get('mid');
		if($mid){
			$res = M('Distribution_forward_set')->where(array('token'=>$token))->find();
			if($mid==$this->my['id']){
				$this->assign('wecha_id',$wecha_id);
				$this->assign('res',$res);
				$this->display();
			}else{
				$follow = M('Newstore')->where(array('token'=>$token,'wecha_id'=>$wecha_id,'status'=>1))->find();
				if($follow){
					$res['follow'] = 1;
				}
				$click = M('Distribution_click')->where(array('token'=>$token,'wecha_id'=>$wecha_id))->find();
				if($click){
					$data['mid'] = $mid;
					$data['updatetime'] = time();
					M('Distribution_click')->where('id='.$click['id'])->save($data);
					M('Distribution_click')->where('id='.$click['id'])->setInc('count');
				}else{
					$user_info = $this->get_user_info($wecha_id);
					$data['nickname'] = $user_info['nickname'];
					$data['headimgurl'] = $user_info['headimgurl'];
					$data['updatetime'] = time();
					$data['token'] = $token;
					$data['wecha_id'] = $wecha_id;
					$data['mid'] = $mid;
					$data['count'] = 1;
					$clickid = M('Distribution_click')->add($data);
					M('Distribution_member')->where('id='.$mid)->setInc('clickNums');
				}
				$from_member = M('Distribution_member')->where('id='.$mid)->find();
				$this->assign('from_member',$from_member);
				$this->assign('res',$res);
				$this->display('forward');
			}
		}else{
			exit('异常访问');
		}
	}
	public function getqrCode(){
		$token = $this->_get('token');
		$wecha_id = $this->wecha_id;
		$mid = $this->_get('mid');
		$data = C('site_url').U('Distribution/forward',array('token'=>$token,'mid'=>$mid));
		vendor("phpqrcode.phpqrcode");
		// 纠错级别：L、M、Q、H
		$level = 'L';
		// 点的大小：1到10,
		$size = 10;
		echo QRcode::png($data, false, $level, $size);
	}
	public function myInfo(){
		if(IS_POST){
			$name = $this->_post('name');
			$tele = $this->_post('tele');
			//$sex = $this->_post('sex');
			$email = $this->_post('email');
			if($name!=''&&$tele!=''&&$email!=''){
				$data['name'] = $name;
				$data['tele'] = $tele;
				$data['sex'] = $sex;
				$data['email'] = $email;
				$condition['token'] = $this->_get('token');
				$condition['wecha_id'] = $this->wecha_id;
				if(M('Distribution_member')->where($condition)->save($data)){
					$arr = array('success'=>1,'info'=>'信息保存成功');
					echo json_encode($arr);
					exit;
				}else{
					$arr = array('success'=>-1,'info'=>'保存失败或信息未改动');
					echo json_encode($arr);
					exit;
				}
			}else{
				$arr = array('success'=>-1,'info'=>'所有内容不能为空');
				echo json_encode($arr);
				exit;
			}
		}else{
			$this->display();
		}
	}
	public function myBank(){
		if(IS_POST){
			$name = $this->_post('name');
			$bankName = $this->_post('bankName');
			$bankNumber = $this->_post('bankNumber');
			$tele = $this->_post('tele');
			$classid = $this->_post('classid');
			if($name!=''&&$bankName!=''&&$bankNumber!=''&&$tele!=''&&$classid!=''){
				$data['name'] = $name;
				$data['bankName'] = $bankName;
				$data['bankNumber'] = $bankNumber;
				$data['tele'] = $tele;
				$data['classid'] = $classid;
				$condition['token'] = $this->_get('token');
				$condition['wecha_id'] = $this->wecha_id;
				if(M('Distribution_bank')->where($condition)->find()){
					if(M('Distribution_bank')->where($condition)->save($data)){
						$arr = array('success'=>1,'info'=>'信息保存成功');
						echo json_encode($arr);
						exit;
					}else{
						$arr = array('success'=>0,'info'=>'保存失败或信息未改动');
						echo json_encode($arr);
						exit;
					}
				}else{
					$data['token'] = $this->_get('token');
					$data['wecha_id'] = $this->wecha_id;
					$data['lasttime'] = time();
					if(M('Distribution_bank')->add($data)){
						$arr = array('success'=>1,'info'=>'信息保存成功');
						echo json_encode($arr);
						exit;
					}else{
						$arr = array('success'=>0,'info'=>'保存失败');
						echo json_encode($arr);
						exit;
					}
				}
			}else{
				$arr = array('success'=>-1,'info'=>'所有内容不能为空');
				echo json_encode($arr);
				exit;
			}
		}else{
			$token = $this->_get('token');
			$wecha_id = $this->wecha_id;
			$bank = M('Distribution_bank')->where(array('token'=>$token,'wecha_id'=>$wecha_id))->find();
			//所属区域
			if($bank['classid']){
				import ( "@.Org.TypeFile" );
				$tid = $bank['classid'];
				$TypeFile = new TypeFile ( 'ClassCity' ); //实例化分类类
				$result = $TypeFile->getPath ( $tid ); //获取分类路径
				$this->assign ( 'typeNumArr', $result );
			}
			$this->assign('bank',$bank);
			$this->display();
		}
	}
	public function forward(){
		$token = $this->_get('token');
		$mid = $this->_get('mid');
		$wecha_id = $this->wecha_id;
		$res = M('Distribution_forward_set')->where(array('token'=>$token))->find();
		$follow = M('Newstore')->where(array('token'=>$token,'wecha_id'=>$wecha_id,'status'=>1))->find();
		if($follow){
			$res['follow'] = 1;
		}
		if($mid){//个人
			$click = M('Distribution_click')->where(array('token'=>$token,'wecha_id'=>$wecha_id))->find();
			if($click){
				$data['mid'] = $mid;
				$data['updatetime'] = time();
				M('Distribution_click')->where('id='.$click['id'])->save($data);
				M('Distribution_click')->where('id='.$click['id'])->setInc('count');
			}else{
				$user_info = $this->get_user_info($wecha_id);
				$data['nickname'] = $user_info['nickname'];
				$data['headimgurl'] = $user_info['headimgurl'];
				$data['updatetime'] = time();
				$data['token'] = $token;
				$data['wecha_id'] = $wecha_id;
				$data['mid'] = $mid;
				$data['count'] = 1;
				$clickid = M('Distribution_click')->add($data);
				M('Distribution_member')->where('id='.$mid)->setInc('clickNums');
			}
			$from_member = M('Distribution_member')->where('id='.$mid)->find();
			$this->assign('from_member',$from_member);
		}
		$this->assign('res',$res);
		$this->display();
	}
	public function forward1(){
		$token = $this->_get('token');
		$mid = $this->_get('mid');
		$wecha_id = $this->wecha_id;
		$res = M('Distribution_forward_set')->where(array('token'=>$token))->find();
		$follow = M('Newstore')->where(array('token'=>$token,'wecha_id'=>$wecha_id,'status'=>1))->find();
		if($follow){
			$res['follow'] = 1;
		}
		if($mid){//个人
			$click = M('Distribution_click')->where(array('token'=>$token,'wecha_id'=>$wecha_id))->find();
			if($click){
				$data['mid'] = $mid;
				$data['updatetime'] = time();
				M('Distribution_click')->where('id='.$click['id'])->save($data);
				M('Distribution_click')->where('id='.$click['id'])->setInc('count');
			}else{
				$user_info = $this->get_user_info($wecha_id);
				$data['nickname'] = $user_info['nickname'];
				$data['headimgurl'] = $user_info['headimgurl'];
				$data['updatetime'] = time();
				$data['token'] = $token;
				$data['wecha_id'] = $wecha_id;
				$data['mid'] = $mid;
				$data['count'] = 1;
				$clickid = M('Distribution_click')->add($data);
				M('Distribution_member')->where('id='.$mid)->setInc('clickNums');
			}
			$from_member = M('Distribution_member')->where('id='.$mid)->find();
			$this->assign('from_member',$from_member);
		}
		$this->assign('res',$res);
		$this->display();
	}
	public function intro(){
		$token = $this->_get('token');
		$mid = $this->_get('mid');
		$wecha_id = $this->wecha_id;
		$res = M('Distribution_forward_set')->where(array('token'=>$token))->find();
		$follow = M('Newstore')->where(array('token'=>$token,'wecha_id'=>$wecha_id,'status'=>1))->find();
		if($follow){
			$res['follow'] = 1;
		}
		if($mid){//个人
			$click = M('Distribution_click')->where(array('token'=>$token,'wecha_id'=>$wecha_id))->find();
			if($click){
				$data['mid'] = $mid;
				$data['updatetime'] = time();
				M('Distribution_click')->where('id='.$click['id'])->save($data);
				M('Distribution_click')->where('id='.$click['id'])->setInc('count');
			}else{
				$user_info = $this->get_user_info($wecha_id);
				$data['nickname'] = $user_info['nickname'];
				$data['headimgurl'] = $user_info['headimgurl'];
				$data['updatetime'] = time();
				$data['token'] = $token;
				$data['wecha_id'] = $wecha_id;
				$data['mid'] = $mid;
				$data['count'] = 1;
				$clickid = M('Distribution_click')->add($data);
				M('Distribution_member')->where('id='.$mid)->setInc('clickNums');
			}
			$from_member = M('Distribution_member')->where('id='.$mid)->find();
			$this->assign('from_member',$from_member);
		}
		$this->assign('res',$res);
		$this->display();
	}
	public function collection(){
		$token = $this->_get('token');
		$wecha_id = $this->wecha_id;
		$db = M('Product_collection');
		$where = array('token'=>$token,'wecha_id'=>$wecha_id);
		$list = $db->where($where)->order('id desc')->select();
		$productModel = M('Product');
		foreach($list as $key=>$value){
			$product = $productModel->where('id='.$value['productid'])->find();
			$list[$key]['product'] = $product;
		}
		$this->assign('list',$list);
		$this->display();
	}
	private function get_user_info($wecha_id){
		$access_str = $this->get_access_token();
		$info = $this->curlGet('https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_str.'&openid='.$wecha_id.'&lang=zh_CN');
		$infoarr = json_decode($info, 1);
		return $infoarr;
	}
}?>