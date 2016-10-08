<?php
class DistributionAction extends UserAction{
	//升级记录表
	public function upgrade(){
		$db=D('TopupRecord');
		$condition['type']=2;
		$condition['paid']=1;
		$count=$db->where($condition)->count();
		$page=new Page($count,25);
		
		$this->assign('page',$page->show());
		if(!$_POST){
			
		}else{
			$condition['orderid']=trim($_POST['searchname']);
		}
		$tr = $db->relation(true)->where($condition)->limit($page->firstRow.','.$page->listRows)->order('id desc')->select();
		$this->assign('list',$tr);
		$this->display();
	}
	//充值记录表
	public function topup(){
		$db=D('TopupRecord');
		$condition['type']=1;
		$condition['paid']=1;

		$count=$db->where($condition)->count();
		$page=new Page($count,25);
		
		$this->assign('page',$page->show());
		if(!$_POST){
			
		}else{
			$condition['orderid']=trim($_POST['searchname']);
		}
		$tr = $db->relation(true)->where($condition)->limit($page->firstRow.','.$page->listRows)->order('id desc')->select();
		$this->assign('list',$tr);
		$this->display();
	}
	//统计记录
	public function statistical(){
		$db=D('TopupRecord');
		$pdb=M("Product_cart");
		$condition['paid']=1;
		if(IS_POST){
			$starttime=date(strtotime($_POST['starttime']));
			$endtime=date(strtotime($_POST['endtime']))+86400;
			//购物入账
			$condition['time']=array("gt",$starttime);
			$condition['time']=array("lt",$endtime);
			$ptotal=$pdb->where($condition)->sum("price");

			$sql="SELECT COUNT(id) as nums, SUM(price) as price,SUM(getMoney) as getMoney,SUM(getvc) as getvc,SUM(comm) as comm,paytime FROM `pigcms_topup_record` WHERE paid=1 and type!=3 and time>=".$starttime." and time<=".$endtime;
			$sql2="SELECT SUM(toLower*lNums) as fuzhu, SUM(offerMoney) as offermoney FROM `pigcms_distribution_ordermoney` WHERE status=4 and addtime>=".$starttime." and addtime<=".$endtime;
		}else{
		 	$sql="SELECT COUNT(id) as nums, SUM(price) as price,SUM(getMoney) as getMoney,SUM(getvc) as getvc,SUM(comm) as comm,paytime FROM `pigcms_topup_record` WHERE paid=1 and type!=3";
			$sql2="SELECT SUM(toLower*lNums) as fuzhu, SUM(offerMoney) as offermoney FROM `pigcms_distribution_ordermoney` WHERE status=4";
		}
		$ptotal=$pdb->where($condition)->sum("price");
		
		$all=$db->query($sql);
		$offer=$db->query($sql2);
		$this->assign('list',$all);
		$this->assign('offer',$offer);
		$this->assign('ptotal',$ptotal);
		$this->display();
	}
	//管理员充值记录
	public function mtopup(){
		$db=D('TopupRecord');
		$condition['type']=3;

		$count=$db->where($condition)->count();
		$page=new Page($count,25);
		
		$this->assign('page',$page->show());
		
		if(!$_POST){
			
		}else{
			$condition['orderid']=trim($_POST['searchname']);
		}
		$tr = $db->relation(true)->where($condition)->limit($page->firstRow.','.$page->listRows)->order('id desc')->select();
		$this->assign('list',$tr);
		$this->display();
	}
	//管理员充值
	public function managerTopup(){
		if(IS_POST){
			$getmoney=$this->_post('getmoney');
			$getvc=$this->_post('getvc');
			$id=$this->_post('id');
			$member=D('Distribution_member')->field('id,lid')->where('id='.$id)->find();
			$data=array(
				'orderid'=>$this->returnymd().String::randString(10,1),
				'mid'=>$id,
				'lid'=>$member['lid'],
				'paid'=>1,
				'getmoney'=>$getmoney,
				'getvc'=>$getvc,
				'type'=>3,
				'token'=>$this->token,
				'topupIp'=>get_client_ip(),
				'time'=>time(),
				'paytime'=>time()-86400*10,
				'year'=>date('Y',time()),
				'month'=>date('m',time()),
				'day'=>date('d',time()),
			);
			$id=D('TopupRecord')->add($data);
			$sql=D('TopupRecord')->getLastsql();
			if($id){
				$this->ajaxReturn("","",1);
			}else{
				$this->ajaxReturn("",$sql,2);
			}
		}else{
			$where['id']=$this->_get("mid");
			$member=D("Distribution_member")->where($where)->find();
			$this->assign("member",$member);
			$this->display();
		}
	}
	//管理员升级记录
	public function mupgrade(){
		$db=D('ManagerRecord');
		if($_POST){
			$where['name|nickname'] = array('like','%'.$this->_post('searchname').'%');
			$member=D("Distribution_member")->where($where)->select();
			if($member){
				foreach ($member as $k => $v) {
					$str.=$v['id'].",";
				}
				$condition['mid']=array("in",$str);
			}
		}

		$count=$db->where($condition)->count();
		$page=new Page($count,25);
		
		$this->assign('page',$page->show());

		$tr = $db->relation(true)->where($condition)->limit($page->firstRow.','.$page->listRows)->order('id desc')->select();
		$this->assign('list',$tr);
		$this->display();
	}
	//管理设置会员等级(AJAX)
	public function managerSetMember(){
		$mid=$this->_post('id');
		$lid=$this->_post('lid');
		$member=D("Distribution_member")->where("id=".$mid)->find();
		if($member){
			D("Distribution_member")->where("id=".$mid)->setField("bind",1);
			D("Distribution_member")->where("id=".$mid)->setField("lid",$lid);
			if($member['distritime']==0&&$lid!=0){
				D("Distribution_member")->where("id=".$mid)->setField("distritime",time());
			}
			if($lid==0){
				$this->removeRelation($member['bindmid'],$mid);
			}
			if($member['bindmid']&&$member['bind']==0&&$lid!=0){
				$this->bindRelation($member['bindmid'],$mid);
			}

			$data=array(
				'mid'=>$mid,
				'oldlid'=>$member['lid'],
				'newlid'=>$lid,
				'token'=>$this->token,
				'topupIp'=>get_client_ip(),
				'time'=>time(),
				'year'=>date('Y',time()),
				'month'=>date('m',time()),
				'day'=>date('d',time()),
			);
			$id=D('ManagerRecord')->add($data);
			$sql=D('ManagerRecord')->getLastsql();
			if($id){
				$this->ajaxReturn("","",1);
			}else{
				$this->ajaxReturn("",$sql,2);
			}
		}
	}
	//退款记录
	public function returnMoney(){
		$tr=D('TopupRecord')->where(array('refund'=>array('neq',0)))->relation(true)->select();
		$this->assign("list",$tr);
		$this->display();
	}
	public function returnMoneyAjax(){
		$id=$_POST['id'];
		//$id=$_GET['id'];
		$data=array(
			"refund"=>2,
			"gettime"=>time(),
		);
		$success=D('TopupRecord')->where("id=".$id)->save($data);
		$order=D('TopupRecord')->where("id=".$id)->find();
		$member=D('Distribution_member')->where('id='.$order['mid'])->find();
		$sql=D('TopupRecord')->getLastsql();
		if($success){
			//改变返佣状态
			M('Distribution_ordermoney')->where('order_id='.$id)->setField('status',-1);
			//扣除下级消费记录
			$this->setTotalPay($order['price'],$member['fid']);
			//对自身等级和绑定关系处理
			if($order['type']==2){
				//使用会员
				if($member['lid']==1){
					$data=array(
						'lid'=>0,
						'bind'=>0,
						'bindmid'=>0,
					);
					D('Distribution_member')->where('id='.$order['mid'])->save($data);
				}else if($order[lid]==$member['lid']&&$member['lid']!=1){//非试用会员
					$checkorder=D('TopupRecord')->where(array('mid'=>$order['mid'],'paid'=>1,'refund'=>0,'type'=>2,'id'=>array('neq',$order['id'])))->limit(1)->order("lid desc")->find();
					if($checkorder){//如果有升级记录
						D('Distribution_member')->where('id='.$order['mid'])->setField('lid',$checkorder['lid']);
					}else{//如果没有升级记录
						$data=array(
							'lid'=>0,
							'bind'=>0,
							'bindmid'=>0,
						);
						D('Distribution_member')->where('id='.$order['mid'])->save($data);
					}
				}
			}

			$this->ajaxReturn("",M('Distribution_ordermoney')->getLastsql(),1);
		}else{
			$this->ajaxReturn("",$sql,2);
		}
	}
	// public function test(){
	// 	$url=$this->siteUrl.U("Distribution/test2");
	// 	echo $url;
	// 	$data=array(
	// 		"lid"=>1,
	// 	);
	// 	S("test",$data);
	// 	dump(S("test"));
	// 	Http::asyncFsockopen($url);
	// }
	// public function test2(){
	// 	Log::write("testaa","DEBUG");
	// 	M("Distribution_member")->add(S("test"));
	// 	S("test",NULL);
	// }
	public function setTotalPay($value,$id,$num=0){
        $member=D('Distribution_member')->where('id='.$id)->find();
        D('Distribution_member')->where('id='.$id)->setDec('totalPay',$value);
        if($num==10){
            return false;
        }
        if($member['fid']!=0){
            $this->setTotalPay($value,$member['fid'],$num++);
        }else{
        	return false;
        }
    }
	public function set(){		
		//if($this->_get('token')!=session('token')){$this->error('非法操作');}
		$data=D('Distribution_set');
		$set=$data->where(array('token'=>session('token'),'uid'=>session('uid')))->find();
		$this->assign('set',$set);
		if(IS_POST){
			$_POST['token']=session('token');			
			if($data->create()){
				if($set==false){
					if($data->add()){
						$this->success('操作成功');					
					}else{
						$this->error('服务器繁忙，请稍候再试1');
					}
				}else{
					$_POST['id']=$set['id'];
					if($data->save($_POST)){
						$this->success('操作成功');					
					}else{
						$this->error('服务器繁忙，请稍候再试2');
					}
				}
			}else{
				$this->error($data->getError());
			}
		}else{
			$this->display();
		}
	}
	public function forwardSet(){		
		//if($this->_get('token')!=session('token')){$this->error('非法操作');}
		$data=D('Distribution_forward_set');
		$info=$data->where(array('token'=>session('token'),'uid'=>session('uid')))->find();
		$this->assign('info',$info);
		if(IS_POST){
			$_POST['token']=session('token');			
			if($data->create()){
				if($info==false){
					if($data->add()){
						$this->success('操作成功');					
					}else{
						$this->error('服务器繁忙，请稍候再试1');
					}
				}else{
					$_POST['id']=$info['id'];
					if($data->save($_POST)){
						$this->success('操作成功');					
					}else{
						$this->error('服务器繁忙，请稍候再试2');
					}
				}
			}else{
				$this->error($data->getError());
			}
		}else{
			$this->display();
		}
	}
	public function member(){
		$id = $this->_get('id');
		$mid = $this->_get('mid');
		$level = $this->_get('level');
		if($id){
			$day = 10;//十天冻结
			$token = session('token');
			$db = M('Distribution_member');
			$member = $db->where('id='.$id)->find();
			$from_user = $db->where('id='.$member['bindmid'])->find();
			$db = M('Distribution_ordermoney');
			$order['status_-1'] = $db->where(array('token'=>$token,'mid'=>$id,'status'=>-1))->sum('offerMoney');//已退款
			$order['status_-1'] += $db->where(array('token'=>$token,'mid'=>$member['fid'],'status'=>-1,'addtime'=>array('gt',$member['distritime'])))->sum('toLower');//已退款

			$order['status_4'] = $db->where(array('token'=>$token,'mid'=>$id,'status'=>4,'addtime'=>array('elt',time()-86400*$day)))->sum('offerMoney');//可提现佣金
			$condition4['token'] = $token;
			$condition4['mid'] = $member['fid'];
			$condition4['status'] = 4;
			$time = time()-86400*$day;
			$condition4['_string'] = 'addtime<='.$time.' AND addtime>='.$member['distritime'];
			if($member['lid']>1){//分给1000档以上会员
				$order['status_4'] += $db->where($condition4)->sum('toLower');//可提现辅助金
			}

			$order['status_5'] = $db->where(array('token'=>$token,'mid'=>$id,'status'=>4,'addtime'=>array('egt',time()-86400*$day)))->sum('offerMoney');//已冻结佣金
			$condition5['token'] = $token;
			$condition5['mid'] = $member['fid'];
			$condition5['status'] = 4;
			$time = time()-86400*$day;
			$condition5['_string'] = 'addtime>='.$time.' AND addtime>='.$member['distritime'];
			if($member['lid']>1){//分给1000档以上会员
				$order['status_5'] += $db->where($condition5)->sum('toLower');//已冻结辅助金
			}

			$order['balance'] = M("TopupRecord")->where(array('mid'=>$member['id'],'paid'=>1,'refund'=>0))->sum('getmoney');//总余额
			$order['balance_1'] = M("TopupRecord")->where(array('mid'=>$member['id'],'paid'=>1,'refund'=>0))->sum('getmoney')-$member['usedBalance']-$member['getBalance'];//可提现余额
			//$order['balance_2'] = M("TopupRecord")->where(array('mid'=>$member['id'],'paid'=>1,'refund'=>0,'paytime'=>array('egt',time()-86400*10)))->sum('getmoney');//已冻结余额
			if($member['lid']>1){//分给1000档以上会员
				$order['tolower'] =			$db->where(array('token'=>$token,'mid'=>$member['fid'],'status'=>4,'addtime'=>array('gt',$member['distritime'])))->sum('toLower');//辅助奖金
			}

			$order['vc']=M("TopupRecord")->where(array('mid'=>$member['id'], 'paid'=>1,'refund'=>0))->sum('getvc')-$member['usedVc'];//虚拟币


			$where['fid'] = $id;
			$where['sid'] = $id;
			$where['tid'] = $id;
			$where['_logic'] = 'or';
			$childmember = M('Distribution_member')->where($where)->select();
			$distriCount = M('Distribution_member')->where(array('token'=>$token,'bindmid'=>$id,'bind'=>1))->count();//正式A分店
			$downCount = M('Distribution_member')->where(array('token'=>$token,'bindmid'=>$id,'bind'=>0))->count();//普通A分店
			$totalMoney = $db->where(array('token'=>$token,'mid'=>$id,'status'=>array('gt',0)))->sum('orderMoney');//累计销售
			$totalOfferMoney = $db->where(array('token'=>$token,'mid'=>$id,'status'=>array('gt',0)))->sum('offerMoney');//累计佣金
			$orderNums = $db->where(array('token'=>$token,'mid'=>$id,'status'=>array('gt',0)))->count();
			$totalScore = M('product_cart')->where(array('token'=>$token,'wecha_id'=>$member['wecha_id'],'handled'=>1))->sum('price');
			$this->assign('totalScore',$totalScore);
			$this->assign('orderNums',$orderNums);
			$this->assign('totalMoney',$totalMoney);
			$this->assign('totalOfferMoney',$totalOfferMoney);
			$this->assign('distriCount',$distriCount);
			$this->assign('downCount',$downCount);
            $this->assign('childmember',$childmember);
			$this->assign('order',$order);
			$this->assign('from_user',$from_user);
			$this->assign('member',$member);
			$this->display('memberDetail');
		}else if($mid){
			$member=D('Distribution_member')->where("id=".$mid)->relation(true)->find();
			$balance=M("TopupRecord")->where(array('mid'=>$member['id'],'paid'=>1,'refund'=>0))->sum('getmoney')-$member['usedBalance']-$member['getBalance'];//可提现余额
			$vc=M("TopupRecord")->where(array('mid'=>$member['id'],'paid'=>1,'refund'=>0))->sum('getvc')-$member['usedVc'];//虚拟币
			
			$this->assign("member",$member);
			$this->assign("balance",$balance);
			$this->assign("vc",$vc);
			if($level){
				$mlevel=D("MemberLevel")->select();
				$this->assign("mlevel",$mlevel);
				$this->display('managerSet');
			}else{
				$this->display('managerTopup');
			}
		}else{
			$db = D('Distribution_member');
			if($this->_post('name')!=''){
				$where['name|nickname'] = array('like','%'.$this->_post('name').'%');
			}
			$where['token'] = session('token');
			$count=$db->where($where)->count();
			$page=new Page($count,25);
			$member = $db->relation(true)->where($where)->limit($page->firstRow.','.$page->listRows)->order('id desc')->select();
			$this->assign('page',$page->show());
			$this->assign('member',$member);
			$this->display();
		}
	}
	//辅助金列表
	public function toLowerList(){
		$id = $this->_get('id');
		if($id){
			$member = M('Distribution_member')->where('id='.$id)->find();
			$token = session('token');
			$db = M('Distribution_ordermoney');
			$where = array('token'=>$token,'mid'=>$member['fid'],'status'=>4,'addtime'=>array('egt',$member['distritime']));
			$count=$db->where($where)->count();
			$page=new Page($count,25);
			$list = $db->where($where)->limit($page->firstRow.','.$page->listRows)->order('id desc')->select();
			$this->assign('list',$list);
			$this->assign('member',$member);
			$this->assign('page',$page->show());
			$this->display();
		}else{
			$this->error('异常访问');
		}
	}
	//AJAX加载余额虚拟币
	public function showbv(){
		$id=$this->_get("id","intval");
		$member=D("Distribution_member")->where("id=".$id)->find();
		$balance=M("TopupRecord")->where(array('mid'=>$member['id'],'paid'=>1,'refund'=>0))->sum('getmoney')-$member['usedBalance']-$member['getBalance'];//可提现余额
		$vc=M("TopupRecord")->where(array('mid'=>$member['id'],'paid'=>1,'refund'=>0))->sum('getvc')-$member['usedVc'];//虚拟币
		$sql=M("TopupRecord")->getLastsql();
		$this->ajaxReturn($balance."/".$vc,$sql,1);
	}
	public function delMember(){
		// $db = M('Distribution_member');
		// $id = $this->_get('id');
		// if($id){
		// 	$wecha_id = $db->where(array('id'=>$id,'token'=>session('token')))->getField('wecha_id');
		// 	if($db->where(array('id'=>$id,'token'=>session('token')))->delete()){
		// 		if($wecha_id){
		// 			M('Membercode')->where(array('wecha_id'=>$wecha_id,'token'=>session('token')))->delete();
		// 		}
		// 		$this->success('删除成功');
		// 	}else{
		// 		$this->error('删除失败');
		// 	}
		// }else{
		// 	$this->error('异常操作');
		// }
		$db = M('Distribution_member');
		$id = $this->_post('mid');
		$pwd = $this->_post('pwd','trim,md5');;
		$users=D("Users")->where("id=".session("uid"))->find();
		if($pwd==""){
			$this->ajaxReturn("","密码不能为空！",4);
		}
		if($users['password']!=$pwd){
			$this->ajaxReturn("","密码错误",5);
		}
		if($id){
			$wecha_id = $db->where(array('id'=>$id,'token'=>session('token')))->getField('wecha_id');
			if($db->where(array('id'=>$id,'token'=>session('token')))->delete()){
				if($wecha_id){
					M('Membercode')->where(array('wecha_id'=>$wecha_id,'token'=>session('token')))->delete();
				}
				$this->ajaxReturn("","删除成功",1);
			}else{
				$this->ajaxReturn("","删除失败",2);
			}
		}else{
			$this->ajaxReturn("","出现异常",3);
		}
	}
	public function bank(){
		$db = M('Distribution_bank');
		if($this->_post('name')!=''){
			$where['name|bankName'] = array('like','%'.$this->_post('name').'%');
		}
		$where['token'] = session('token');
		$count=$db->where($where)->count();
		$page=new Page($count,25);
		$list = $db->where($where)->limit($page->firstRow.','.$page->listRows)->order('id desc')->select();
		foreach($list as $key=>$value){
			$member = M('Distribution_member')->where(array('wecha_id'=>$value['wecha_id'],'token'=>$value['token']))->find();
			$list[$key]['nickname'] = $member['nickname'];
			$list[$key]['headimgurl'] = $member['headimgurl'];
			//所属区域
			if($value['classid']){
				import ( "@.Org.TypeFile" );
				$tid = $value['classid'];
				$TypeFile = new TypeFile ( 'ClassCity' ); //实例化分类类
				$result = $TypeFile->getPathName ( $tid ); //获取分类路径
				$list[$key]['typeNumArr']= $result ;
			}
		}
		$this->assign('page',$page->show());
		$this->assign('list',$list);
		$this->display();
	}
	public function moneylist(){
		$db = M('Distribution_applystore');
		$id=$this->_get('id',intval);
		if($id){
			$info=$db->where('id='.$id)->find();
			$this->assign('set',$info);
			$this->assign('edit',1);
			$this->display("moneyListEdit");
		}
		if($this->_post('name')!=''){
			$where['name|bankName'] = array('like','%'.$this->_post('name').'%');
		}
		$gettype=$this->_get("gettype");
		$where['token'] = session('token');
		$where['gettype'] = $gettype;
		$count=$db->where($where)->count();
		$page=new Page($count,25);
		$list = $db->where($where)->limit($page->firstRow.','.$page->listRows)->order('id desc')->select();
		foreach($list as $key=>$value){
			$member = M('Distribution_member')->where(array('id'=>$value['mid']))->find();
			$list[$key]['memberid'] = $member['id'];
			$list[$key]['nickname'] = $member['nickname'];
			$list[$key]['headimgurl'] = $member['headimgurl'];
			//应付金额
			$list[$key]['paymoney'] = $list[$key]['money']*0.95;
			//所属区域
			if($value['classid']){
				import ( "@.Org.TypeFile" );
				$tid = $value['classid'];
				$TypeFile = new TypeFile ( 'ClassCity' ); //实例化分类类
				$result = $TypeFile->getPathName ( $tid ); //获取分类路径
				$list[$key]['typeNumArr']= $result ;
			}
		}
		$this->assign('page',$page->show());
		$this->assign('list',$list);
		$this->display();
	}
	public function moneylist2(){
		$db = M('Distribution_applystore');
		$id=$this->_get('id',intval);
		if($id){
			$info=$db->where('id='.$id)->find();
			$this->assign('set',$info);
			$this->assign('edit',2);
			$this->display("moneyListEdit");
		}
		if($this->_post('name')!=''){
			$where['name|bankName'] = array('like','%'.$this->_post('name').'%');
		}
		$gettype=$this->_get("gettype");
		$where['token'] = session('token');
		$where['gettype'] = $gettype;
		$count=$db->where($where)->count();
		$page=new Page($count,25);
		$list = $db->where($where)->limit($page->firstRow.','.$page->listRows)->order('id desc')->select();
		foreach($list as $key=>$value){
			$member = M('Distribution_member')->where(array('id'=>$value['mid']))->find();
			$list[$key]['memberid'] = $member['id'];
			$list[$key]['nickname'] = $member['nickname'];
			$list[$key]['headimgurl'] = $member['headimgurl'];
			//应付金额
			$list[$key]['paymoney'] = $list[$key]['money']*0.98;
			//所属区域
			if($value['classid']){
				import ( "@.Org.TypeFile" );
				$tid = $value['classid'];
				$TypeFile = new TypeFile ( 'ClassCity' ); //实例化分类类
				$result = $TypeFile->getPathName ( $tid ); //获取分类路径
				$list[$key]['typeNumArr']= $result ;
			}
		}
		$this->assign('page',$page->show());
		$this->assign('list',$list);
		$this->display();
	}
	//佣金余额提现修改
	public function moneyListEdit(){
		$db = M('Distribution_applystore');
		$id=$this->_post('id');
		$edit=$this->_post('edit');
		switch ($edit) {
			case '1':
				$back="moneylist";
				break;
			
			case '2':
				$back="moneylist2";
				break;
		}
		$data=array(
			'bankName'=>$this->_post('bankName'),
			'bankNumber'=>$this->_post('bankNumber'),
			'aliName'=>$this->_post('aliName'),
			'aliNumber'=>$this->_post('aliNumber'),
		);
		$result=$db->where("id=".$id)->save($data);
		if($result){
			$this->success("修改成功",U("Distribution/".$back,array('id'=>$id)));
		}else{
			$this->success("修改失败",U("Distribution/".$back,array('id'=>$id)));
		}
	}
	public function changeStatus(){
		$db = M('Distribution_applystore');
		$id = $this->_get('id');
		$status = $this->_get('status');
		if($status!=1&&$status!=2){
			$this->error('异常操作');
		}
		$data['status'] = $status;
		if($db->where('id='.$id)->save($data)){
			$this->success('处理成功');
		}else{
			$this->error('处理失败');
		}
	}
	public function sendMoney(){
		$id = $this->_get('id');
		if(!$id){
			$this->error('非法操作！');
			exit();
		}
		$result = $this->TXhongbao($id);
		if($result['return_code']=='SUCCESS'){
			M('Distribution_applystore')->where(array('token'=>session('token'),'id'=>$id,'status'=>0))->setField('status',1);
			$this->success('发放成功！');
		}else{
			$this->error($result['return_msg']);
		}
	}
	public function address(){
		$db = M('Distribution_member');
		if($this->_post('name')!=''){
			$where['name|nickname'] = array('like','%'.$this->_post('name').'%');
		}
		$where['token'] = session('token');
		$count=$db->where($where)->count();
		$page=new Page($count,25);
		$list = $db->where($where)->limit($page->firstRow.','.$page->listRows)->order('id desc')->select();
		$this->assign('page',$page->show());
		$this->assign('list',$list);
		$this->display();
	}
	public function collection(){
		$db = M('Product_collection');
		$where['token'] = session('token');
		$count=$db->where($where)->count();
		$page=new Page($count,25);
		$list = $db->where($where)->limit($page->firstRow.','.$page->listRows)->order('id desc')->select();
		$memberModel = M('Distribution_member');
		$productModel = M('Product');
		foreach($list as $key=>$value){
			$member = $memberModel->where(array('token'=>$value['token'],'wecha_id'=>$value['wecha_id']))->field('nickname,headimgurl')->find();
			$list[$key]['nickname'] = $member['nickname'];
			$list[$key]['headimgurl'] = $member['headimgurl'];
			$product = $productModel->where('id='.$value['productid'])->field('name')->find();
			$list[$key]['productname'] = $product['name'];
		}
		$this->assign('page',$page->show());
		$this->assign('list',$list);
		$this->display();
	}
	public function beDistribution(){
		$db = M('Distribution_member');
		$id = $this->_get('id');
		if($id){
			$data['distritime'] = time();
			if($db->where(array('id'=>$id,'token'=>session('token')))->save($data)){
				$this->success('设为分销成功');
			}else{
				$this->error('设为分销失败');
			}
		}else{
			$this->error('异常操作');
		}
	}
	private function TXhongbao($id)
	{
		//读取微信支付配置
		$payConfig = M('Alipay_config')->where(array('token'=>session('token')))->find();
		//读取商家信息
		$company = M('company')->where(array('token'=>session('token')))->find();
		//读取提现申请
		$apply = M('Distribution_applystore')->where(array('token'=>session('token'),'id'=>$id,'status'=>0))->find();
		if(!$apply){
			$this->error('异常操作！');
			exit();
		}
		$url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
		$key = $payConfig['paysignkey'];//API密钥
		$mch_id = $payConfig['mchid'];//商户号
		$sub_mch_id = '';//子商户号
		$wxappid = $payConfig['appid'];//appid
		$nick_name = '佣金提现';//提供方名称
		$send_name = '佣金提现';//商户名称
		$re_openid = $apply['wecha_id'];//用户openid
		$total_amount = $apply['money'];//付款金额
		$min_value = $apply['money'];//最小红包金额
		$max_value = $apply['money'];//最大红包金额
		$total_num = 1;//红包发放总人数
		$wishing = '恭喜您，提现成功啦';//红包祝福语
		$client_ip = $payConfig['ip'];//Ip地址
		$act_name = '佣金提现';//活动名称
		$remark = '备注';//备注
		$logo_imgurl = $company['logourl'];//商户logo的url

		$data = array();
		$data['nonce_str'] = md5(rand(10000000,99999999));
		$data['mch_billno'] = $mch_id.date('Ymd').rand(1000000000,9999999999);
		$data['mch_id'] = $mch_id;
		$data['sub_mch_id'] = $sub_mch_id;
		$data['wxappid'] = $wxappid;
		$data['nick_name'] = $nick_name;
		$data['send_name'] = $send_name;
		$data['re_openid'] = $re_openid;
		$data['total_amount'] = $total_amount;
		$data['min_value'] = $min_value;
		$data['max_value'] = $max_value;
		$data['total_num'] = $total_num;
		$data['wishing'] = $wishing;
		$data['client_ip'] = $client_ip;
		$data['act_name'] = $act_name;
		$data['remark'] = $remark;
		$data['logo_imgurl'] = $logo_imgurl;
		
		$data['sign'] = $this->signValue($data,$key);
		$xml = new SimpleXMLElement('<xml></xml>');
        $this->data2xml($xml, $data);
        $postXML = $xml->asXML();
		$result = $this->api_notice_increment_xml($url,$postXML);
		return $this->xmlToArray($result);
	}
	private function data2xml($xml, $data, $item = 'item')
    {
        foreach ($data as $key => $value) {
            is_numeric($key) && $key = $item;
            if (is_array($value) || is_object($value)) {
                $child = $xml->addChild($key);
                $this->data2xml($child, $value, $item);
            } else {
                if (is_numeric($value)) {
                    $child = $xml->addChild($key, $value);
                } else {
                    $child = $xml->addChild($key);
                    $node  = dom_import_simplexml($child);
                    $node->appendChild($node->ownerDocument->createCDATASection($value));
                }
            }
        }
    }
	private function signValue($data,$keyStr)
    {
		$str = '';
		ksort($data,SORT_STRING);
		foreach($data as $key=>$value){
			if($value!=''){
				$str .= $key.'='.$value.'&';
			}
		}
		$str .= 'key='.$keyStr;
		$sign = strtoupper(MD5($str));
		return $sign;
    }
	private	function api_notice_increment_xml($url, $data){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);

		//因为微信红包在使用过程中需要验证服务器和域名，故需要设置下面两行
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // 只信任CA颁布的证书 
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 检查证书中是否设置域名，并且是否与提供的主机名匹配


		curl_setopt($ch, CURLOPT_SSLCERT,CONF_PATH.'hongbao/apiclient_cert.pem');
		curl_setopt($ch, CURLOPT_SSLKEY,CONF_PATH.'hongbao/apiclient_key.pem');
		curl_setopt($ch, CURLOPT_CAINFO,CONF_PATH.'hongbao/rootca.pem'); // CA根证书（用来验证的网站证书是否是CA颁布）


		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$res = curl_exec($ch);
		curl_close($ch);
		return $res;
	}
	/**
	 * 作用：将xml转为array
	 */
	public function xmlToArray($xml)
	{       
	   //将XML转为array        
	   $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);       
	   return $array_data;
	}
}


?>