<?php
class LinkAction extends UserAction{
	public $where;
	public $modules;
	public function _initialize() {
		parent::_initialize();
		$this->where=array('token'=>$this->token);
		$this->modules=array(
		'Home'=>'首页',
		'Classify'=>'网站分类',
		'Img'=>'图文回复',
		'Company'=>'LBS信息',
		'Adma'=>'DIY宣传页',
		'Photo'=>'相册',
		'Selfform'=>'万能表单',
		'Host'=>'商家订单',
		'Groupon'=>'团购',
		'Shop'=>'商城',
		'Repast'=>'订餐',
		'Wedding'=>'婚庆喜帖',
		'Vote'=>'投票',
		'Panorama'=>'全景',
		'Lottery'=>'大转盘',
		'Guajiang'=>'刮刮卡',
		'Coupon'=>'优惠券',
		'MemberCard'=>'会员卡',
		'Estate'=>'微房产',
		'Message'=>'留言板',
		'Car'=>'汽车',
		'GoldenEgg'=>'砸金蛋',
		'LuckyFruit'=>'水果机',
		'Forum'=>'论坛',
		'GreetingCard'=>'贺卡',
		'Medical'=>'微医疗',
		'School'=>'微教育',
		'Hotels'=>'酒店宾馆',
		'Business'=>'行业应用',
		'Market'=>'微商圈',
		'Research'=>'微调研',
		'Fansign'=>'微信签到',
		'OutsideLink'=>'<font color="red">生活服务</font>',
		);
	}
	public function insert(){
		if ($_GET['iskeyword']){
			$modules=$this->keywordModules();
		}else {
			$modules=$this->modules();
		}
		$this->assign('modules',$modules);
		$this->display();
	}
	public function keywordModules(){
		return array(
		array('module'=>'Home','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Index&a=index&token='.$this->token.'&wecha_id={wechat_id}','name'=>'微站首页','sub'=>0,'canselected'=>1,'linkurl'=>'','keyword'=>$this->modules['Home'],'askeyword'=>1),
		array('module'=>'Img','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Index&a=content&token='.$this->token.'&wecha_id={wechat_id}','name'=>$this->modules['Img'],'sub'=>1,'canselected'=>0,'linkurl'=>'','keyword'=>'','askeyword'=>1),
		array('module'=>'Company','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Company&a=map&token='.$this->token.'&wecha_id={wechat_id}','name'=>$this->modules['Company'],'canselected'=>1,'linkurl'=>'','keyword'=>'地图','askeyword'=>1),
		array('module'=>'Photo','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Photo&a=index&token='.$this->token.'&wecha_id={wechat_id}','name'=>$this->modules['Photo'],'canselected'=>1,'linkurl'=>'','keyword'=>'相册','askeyword'=>1),
		array('module'=>'Selfform','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Selfform&a=index&token='.$this->token.'&wecha_id={wechat_id}','name'=>$this->modules['Selfform'],'sub'=>1,'canselected'=>0,'linkurl'=>'','keyword'=>'','askeyword'=>1),
		array('module'=>'Host','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Host&a=detail&token='.$this->token.'&wecha_id={wechat_id}','name'=>$this->modules['Host'],'sub'=>1,'canselected'=>0,'linkurl'=>'','keyword'=>'','askeyword'=>1),
		array('module'=>'Groupon','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Groupon&a=grouponIndex&token='.$this->token.'&wecha_id={wechat_id}','name'=>$this->modules['Groupon'],'sub'=>0,'canselected'=>1,'linkurl'=>'','keyword'=>'团购','askeyword'=>1),
		array('module'=>'Shop','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Store&a=index&token='.$this->token.'&wecha_id={wechat_id}','name'=>$this->modules['Shop'],'canselected'=>1,'linkurl'=>'','keyword'=>'商城','askeyword'=>1),
		array('module'=>'Repast','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Repast&a=index&token='.$this->token.'&wecha_id={wechat_id}','name'=>$this->modules['Repast'],'sub'=>0,'canselected'=>1,'linkurl'=>'','keyword'=>'订餐','askeyword'=>1),
		array('module'=>'Wedding','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Wedding&a=index&token='.$this->token.'&wecha_id={wechat_id}','name'=>$this->modules['Wedding'],'sub'=>1,'canselected'=>0,'linkurl'=>'','keyword'=>'','askeyword'=>1),
		array('module'=>'Vote','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Vote&a=index&token='.$this->token.'&wecha_id={wechat_id}','name'=>$this->modules['Vote'],'sub'=>1,'canselected'=>0,'linkurl'=>'','keyword'=>'','askeyword'=>1),
		array('module'=>'Panorama','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Panorama&a=index&token='.$this->token.'&wecha_id={wechat_id}','name'=>$this->modules['Panorama'],'sub'=>1,'canselected'=>0,'linkurl'=>'','keyword'=>$this->modules['Panorama'],'askeyword'=>1),
		array('module'=>'Lottery','linkcode'=>'','name'=>$this->modules['Lottery'],'sub'=>1,'canselected'=>0,'linkurl'=>'','keyword'=>'','askeyword'=>1),
		array('module'=>'Guajiang','linkcode'=>'','name'=>$this->modules['Guajiang'],'sub'=>1,'canselected'=>0,'linkurl'=>'','keyword'=>'','askeyword'=>1),
		array('module'=>'Coupon','linkcode'=>'','name'=>$this->modules['Coupon'],'sub'=>1,'canselected'=>0,'linkurl'=>'','keyword'=>'','askeyword'=>1),
		array('module'=>'MemberCard','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Card&a=index&token='.$this->token.'&wecha_id={wechat_id}','name'=>$this->modules['MemberCard'],'sub'=>0,'canselected'=>1,'linkurl'=>'','keyword'=>'会员卡','askeyword'=>1),
		array('module'=>'Estate','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Estate&a=index&token='.$this->token.'&wecha_id={wechat_id}','name'=>$this->modules['Estate'],'sub'=>0,'canselected'=>1,'linkurl'=>'','keyword'=>'微房产','askeyword'=>1),
		array('module'=>'Message','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Reply&a=index&token='.$this->token.'&wecha_id={wechat_id}','name'=>$this->modules['Message'],'sub'=>0,'canselected'=>1,'linkurl'=>'','keyword'=>'留言','askeyword'=>1),
		array('module'=>'Car','linkcode'=>'{siteUrl}/index.php?g=Wap&m=brands&a=index&token='.$this->token.'&wecha_id={wechat_id}','name'=>$this->modules['Car'],'sub'=>0,'canselected'=>1,'linkurl'=>'','keyword'=>'汽车','askeyword'=>1),
		array('module'=>'GoldenEgg','linkcode'=>'','name'=>$this->modules['GoldenEgg'],'sub'=>1,'canselected'=>0,'linkurl'=>'','keyword'=>'','askeyword'=>1),
		array('module'=>'LuckyFruit','linkcode'=>'','name'=>$this->modules['LuckyFruit'],'sub'=>1,'canselected'=>0,'linkurl'=>'','keyword'=>'','askeyword'=>1),
		array('module'=>'Forum','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Forum&a=index&token='.$this->token.'&wecha_id={wechat_id}','name'=>$this->modules['Forum'],'sub'=>0,'canselected'=>1,'linkurl'=>'','keyword'=>'论坛','askeyword'=>1),
		array('module'=>'Hotels','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Hotels&a=index&token='.$this->token.'&wecha_id={wechat_id}','name'=>'酒店宾馆','sub'=>0,'canselected'=>1,'linkurl'=>'','keyword'=>'酒店','askeyword'=>1),
		array('module'=>'GreetingCard','linkcode'=>'','name'=>$this->modules['GreetingCard'],'sub'=>1,'canselected'=>0,'linkurl'=>'','keyword'=>'','askeyword'=>1),
		array('module'=>'Business','linkcode'=>'','name'=>$this->modules['Business'],'sub'=>1,'canselected'=>0,'linkurl'=>'','keyword'=>'','askeyword'=>1),
		
		array('module'=>'Market','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Market&a=index&token='.$this->token.'&wecha_id={wechat_id}','name'=>$this->modules['Market'],'sub'=>0,'canselected'=>1,'linkurl'=>'','keyword'=>'微商圈','askeyword'=>1),
		array('module'=>'Research','linkcode'=>'','name'=>$this->modules['Research'],'sub'=>1,'canselected'=>0,'linkurl'=>'','keyword'=>'','askeyword'=>1),
		array('module'=>'Fansign','linkcode'=>'','name'=>'微信签到','sub'=>0,'canselected'=>1,'linkurl'=>'','keyword'=>'微信签到','askeyword'=>1),
		);
	}
	public function modules(){
		return array(
		array('module'=>'Home','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Index&a=index&token='.$this->token.'&wecha_id={wechat_id}','name'=>'微站首页','sub'=>0,'canselected'=>1,'linkurl'=>'','keyword'=>$this->modules['Home'],'askeyword'=>1),
		array('module'=>'Classify','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Index&a=lists&token='.$this->token.'&wecha_id={wechat_id}','name'=>$this->modules['Classify'],'sub'=>1,'canselected'=>0,'linkurl'=>'','keyword'=>'','askeyword'=>0),
		array('module'=>'Img','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Index&a=content&token='.$this->token.'&wecha_id={wechat_id}','name'=>$this->modules['Img'],'sub'=>1,'canselected'=>0,'linkurl'=>'','keyword'=>'','askeyword'=>1),
		array('module'=>'Company','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Company&a=map&token='.$this->token.'&wecha_id={wechat_id}','name'=>$this->modules['Company'],'sub'=>1,'canselected'=>1,'linkurl'=>'','keyword'=>'地图','askeyword'=>1),
		array('module'=>'Adma','linkcode'=>'{siteUrl}/index.php/show/'.$this->token,'name'=>$this->modules['Adma'],'sub'=>0,'canselected'=>1,'linkurl'=>'','keyword'=>'','askeyword'=>0),
		array('module'=>'Photo','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Photo&a=index&token='.$this->token.'&wecha_id={wechat_id}','name'=>$this->modules['Photo'],'sub'=>1,'canselected'=>1,'linkurl'=>'','keyword'=>'相册','askeyword'=>1),
		array('module'=>'Selfform','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Custom&a=index&token='.$this->token.'&wecha_id={wechat_id}','name'=>$this->modules['Selfform'],'sub'=>1,'canselected'=>0,'linkurl'=>'','keyword'=>'','askeyword'=>1),
		array('module'=>'Host','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Host&a=detail&token='.$this->token.'&wecha_id={wechat_id}','name'=>$this->modules['Host'],'sub'=>1,'canselected'=>0,'linkurl'=>'','keyword'=>'','askeyword'=>1),
		array('module'=>'Groupon','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Groupon&a=grouponIndex&token='.$this->token.'&wecha_id={wechat_id}','name'=>$this->modules['Groupon'],'sub'=>0,'canselected'=>1,'linkurl'=>'','keyword'=>'团购','askeyword'=>1),
		array('module'=>'Shop','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Store&a=index&token='.$this->token.'&wecha_id={wechat_id}','name'=>$this->modules['Shop'],'sub'=>1,'canselected'=>1,'linkurl'=>'','keyword'=>'商城','askeyword'=>1),
		array('module'=>'Repast','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Repast&a=index&token='.$this->token.'&wecha_id={wechat_id}','name'=>$this->modules['Repast'],'sub'=>0,'canselected'=>1,'linkurl'=>'','keyword'=>'订餐','askeyword'=>1),
		array('module'=>'Wedding','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Wedding&a=index&token='.$this->token.'&wecha_id={wechat_id}','name'=>$this->modules['Wedding'],'sub'=>1,'canselected'=>0,'linkurl'=>'','keyword'=>'','askeyword'=>1),
		array('module'=>'Vote','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Vote&a=index&token='.$this->token.'&wecha_id={wechat_id}','name'=>$this->modules['Vote'],'sub'=>1,'canselected'=>0,'linkurl'=>'','keyword'=>'','askeyword'=>1),
		array('module'=>'Panorama','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Panorama&a=index&token='.$this->token.'&wecha_id={wechat_id}','name'=>$this->modules['Panorama'],'sub'=>1,'canselected'=>1,'linkurl'=>'','keyword'=>$this->modules['Panorama'],'askeyword'=>1),
		array('module'=>'Lottery','linkcode'=>'','name'=>$this->modules['Lottery'],'sub'=>1,'canselected'=>0,'linkurl'=>'','keyword'=>'','askeyword'=>1),
		array('module'=>'Guajiang','linkcode'=>'','name'=>$this->modules['Guajiang'],'sub'=>1,'canselected'=>0,'linkurl'=>'','keyword'=>'','askeyword'=>1),
		array('module'=>'Coupon','linkcode'=>'','name'=>$this->modules['Coupon'],'sub'=>1,'canselected'=>0,'linkurl'=>'','keyword'=>'','askeyword'=>1),
		array('module'=>'MemberCard','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Card&a=index&token='.$this->token.'&wecha_id={wechat_id}','name'=>$this->modules['MemberCard'],'sub'=>0,'canselected'=>1,'linkurl'=>'','keyword'=>'会员卡','askeyword'=>1),
		array('module'=>'Estate','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Estate&a=index&token='.$this->token.'&wecha_id={wechat_id}','name'=>$this->modules['Estate'],'sub'=>1,'canselected'=>1,'linkurl'=>'','keyword'=>'微房产','askeyword'=>1),
		array('module'=>'Message','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Reply&a=index&token='.$this->token.'&wecha_id={wechat_id}','name'=>$this->modules['Message'],'sub'=>0,'canselected'=>1,'linkurl'=>'','keyword'=>'留言','askeyword'=>1),
		array('module'=>'Car','linkcode'=>'{siteUrl}/index.php?g=Wap&m=brands&a=index&token='.$this->token.'&wecha_id={wechat_id}','name'=>$this->modules['Car'],'sub'=>1,'canselected'=>0,'linkurl'=>'','keyword'=>'','askeyword'=>1),
		array('module'=>'Medical','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Medical&a=index&token='.$this->token.'&wecha_id={wechat_id}','name'=>$this->modules['Medical'],'sub'=>1,'canselected'=>0,'linkurl'=>'','keyword'=>'微医疗','askeyword'=>0),
		array('module'=>'School','linkcode'=>'{siteUrl}/index.php?g=Wap&m=School&a=index&token='.$this->token.'&wecha_id={wechat_id}','name'=>$this->modules['School'],'sub'=>1,'canselected'=>1,'linkurl'=>'','keyword'=>'微医疗','askeyword'=>0),
		array('module'=>'GoldenEgg','linkcode'=>'','name'=>$this->modules['GoldenEgg'],'sub'=>1,'canselected'=>0,'linkurl'=>'','keyword'=>'','askeyword'=>1),
		array('module'=>'LuckyFruit','linkcode'=>'','name'=>$this->modules['LuckyFruit'],'sub'=>1,'canselected'=>0,'linkurl'=>'','keyword'=>'','askeyword'=>1),
		array('module'=>'Forum','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Forum&a=index&token='.$this->token.'&wecha_id={wechat_id}','name'=>$this->modules['Forum'],'sub'=>0,'canselected'=>1,'linkurl'=>'','keyword'=>'论坛','askeyword'=>1),
		array('module'=>'GreetingCard','linkcode'=>'','name'=>$this->modules['GreetingCard'],'sub'=>1,'canselected'=>0,'linkurl'=>'','keyword'=>'','askeyword'=>1),
		array('module'=>'Hotels','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Hotels&a=index&token='.$this->token.'&wecha_id={wechat_id}','name'=>'酒店宾馆','sub'=>0,'canselected'=>1,'linkurl'=>'','keyword'=>'酒店','askeyword'=>1),
		array('module'=>'Business','linkcode'=>'','name'=>$this->modules['Business'],'sub'=>1,'canselected'=>0,'linkurl'=>'','keyword'=>'','askeyword'=>1),
		array('module'=>'Market','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Market&a=index&token='.$this->token.'&wecha_id={wechat_id}','name'=>$this->modules['Market'],'sub'=>0,'canselected'=>1,'linkurl'=>'','keyword'=>'','askeyword'=>0),
		array('module'=>'Research','linkcode'=>'','name'=>$this->modules['Research'],'sub'=>1,'canselected'=>0,'linkurl'=>'','keyword'=>'','askeyword'=>0),
		array('module'=>'Fansign','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Fanssign&a=index&token='.$this->token.'&wecha_id={wechat_id}','name'=>$this->modules['Fansign'],'sub'=>0,'canselected'=>1,'linkurl'=>'','keyword'=>'','askeyword'=>0),
		array('module'=>'OutsideLink','linkcode'=>'','name'=>$this->modules['OutsideLink'],'sub'=>1,'canselected'=>0,'linkurl'=>'','keyword'=>'','askeyword'=>0),
		
		);
	}
	public function Classify(){
		$pid = (int)$_GET['pid'];
		$this->assign('moduleName',$this->modules['Classify']);
		$db=M('Classify');
		$where=$this->where;
		

		if($pid != NULL){
			$where['fid'] = $pid;
			$count      = $db->where($where)->count();
			$Page       = new Page($count,10);
			$show       = $Page->show();
			$list=$db->where($where)->limit($Page->firstRow.','.$Page->listRows)->order('id DESC')->select();
		}else{
			$where['fid'] = 0;
			$count      = $db->where($where)->count();
			$Page       = new Page($count,10);
			$show       = $Page->show();
			
			$list=$db->where($where)->limit($Page->firstRow.','.$Page->listRows)->order('id DESC')->select();
		}
		
		$items=array();
		if ($list){
			foreach ($list as $k=>$item){
				$fid = $item['id'];
				
				array_push($items,array('id'=>$item['id'],'name'=>$item['name'],'linkcode'=>'{siteUrl}/index.php?g=Wap&m=Index&a=lists&token='.$this->token.'&wecha_id={wechat_id}&classid='.$item['id'],'linkurl'=>'','keyword'=>$item['keyword'],'sub'=>$db->where(array('token'=>$this->token,'fid'=>$fid))->field('id,name')->select()));
		
			}
		}
		$this->assign('list',$items);
		$this->assign('page',$show);
		$this->display('detail');
	}
	public function Img(){
		$this->assign('moduleName',$this->modules['Img']);
		$db=M('Img');
		$where=$this->where;
		$count      = $db->where($where)->count();
		$Page       = new Page($count,5);
		$show       = $Page->show();
		$list=$db->where($where)->limit($Page->firstRow.','.$Page->listRows)->order('id DESC')->select();
		//
		$items=array();
		if ($list){
			foreach ($list as $item){
				array_push($items,array('id'=>$item['id'],'name'=>$item['title'],'linkcode'=>'{siteUrl}/index.php?g=Wap&m=Index&a=content&token='.$this->token.'&wecha_id={wechat_id}&id='.$item['id'],'linkurl'=>'','keyword'=>$item['keyword']));
			}
		}
		//
		$this->assign('list',$items);
		$this->assign('page',$show);
		$this->display('detail');
	}
	public function Company(){
		$this->assign('moduleName',$this->modules['Company']);
		$db=M('Company');
		$where=$this->where;
		$count      = $db->where($where)->count();
		$Page       = new Page($count,5);
		$show       = $Page->show();
		$list=$db->where($where)->limit($Page->firstRow.','.$Page->listRows)->order('id DESC')->select();
		//
		$items=array();
		if ($list){
			foreach ($list as $item){
				array_push($items,array('id'=>$item['id'],'name'=>$item['name'],'linkcode'=>'{siteUrl}/index.php?g=Wap&m=Company&a=map&token='.$this->token.'&wecha_id={wechat_id}&companyid='.$item['id'],'linkurl'=>'','keyword'=>'地图'));
			}
		}
		//
		$this->assign('list',$items);
		$this->assign('page',$show);
		$this->display('detail');
	}
	public function Photo(){
		$this->assign('moduleName',$this->modules['Photo']);
		$db=M('Photo');
		$where=$this->where;
		$count      = $db->where($where)->count();
		$Page       = new Page($count,5);
		$show       = $Page->show();
		$list=$db->where($where)->limit($Page->firstRow.','.$Page->listRows)->order('id DESC')->select();
		//
		$items=array();
		if ($list){
			foreach ($list as $item){
				array_push($items,array('id'=>$item['id'],'name'=>$item['title'],'linkcode'=>'{siteUrl}/index.php?g=Wap&m=Photo&a=plist&token='.$this->token.'&wecha_id={wechat_id}&id='.$item['id'],'linkurl'=>'','keyword'=>'相册'));
			}
		}
		//
		$this->assign('list',$items);
		$this->assign('page',$show);
		$this->display('detail');
	}
	public function Selfform(){
		$this->assign('moduleName',$this->modules['Selfform']);
		$db=M('Custom_set');
		$where=$this->where;
		$count      = $db->where($where)->count();
		$Page       = new Page($count,5);
		$show       = $Page->show();
		$list=$db->where($where)->limit($Page->firstRow.','.$Page->listRows)->order('set_id DESC')->select();
		//
		$items=array();
		if ($list){
			foreach ($list as $item){
				array_push($items,array('id'=>$item['set_id'],'name'=>$item['title'],'linkcode'=>'{siteUrl}/index.php?g=Wap&m=Custom&a=index&token='.$this->token.'&wecha_id={wechat_id}&id='.$item['set_id'],'linkurl'=>'','keyword'=>$item['keyword']));
			}
		}
		//
		$this->assign('list',$items);
		$this->assign('page',$show);
		$this->display('detail');
	}
	public function Host(){
		$moduleName='Host';
		$this->assign('moduleName',$this->modules[$moduleName]);
		$db=M($moduleName);
		$where=$this->where;
		$count      = $db->where($where)->count();
		$Page       = new Page($count,5);
		$show       = $Page->show();
		$list=$db->where($where)->limit($Page->firstRow.','.$Page->listRows)->order('id DESC')->select();
		//
		$items=array();
		if ($list){
			foreach ($list as $item){
				array_push($items,array('id'=>$item['id'],'name'=>$item['name'],'linkcode'=>'{siteUrl}/index.php?g=Wap&m=Host&a=index&token='.$this->token.'&wecha_id={wechat_id}&hid='.$item['id'],'linkurl'=>'','keyword'=>$item['keyword']));
			}
		}
		//
		$this->assign('list',$items);
		$this->assign('page',$show);
		$this->display('detail');
	}
	public function Panorama(){
		$this->assign('moduleName',$this->modules['Panorama']);
		$db=M('Panorama');
		$where=$this->where;
		$count      = $db->where($where)->count();
		$Page       = new Page($count,5);
		$show       = $Page->show();
		$list=$db->where($where)->limit($Page->firstRow.','.$Page->listRows)->order('time DESC')->select();
		//
		$items=array();
		if ($list){
			foreach ($list as $item){
				array_push($items,array('id'=>$item['id'],'name'=>$item['name'],'linkcode'=>'{siteUrl}/index.php?g=Wap&m=Panorama&a=item&token='.$this->token.'&wecha_id={wechat_id}&id='.$item['id'],'linkurl'=>'','keyword'=>$item['keyword']));
			}
		}
		//
		$this->assign('list',$items);
		$this->assign('page',$show);
		$this->display('detail');
	}
	public function Wedding(){
		$moduleName='Wedding';
		$this->assign('moduleName',$this->modules[$moduleName]);
		$db=M($moduleName);
		$where=$this->where;
		$count      = $db->where($where)->count();
		$Page       = new Page($count,5);
		$show       = $Page->show();
		$list=$db->where($where)->limit($Page->firstRow.','.$Page->listRows)->order('id DESC')->select();
		//
		$items=array();
		if ($list){
			foreach ($list as $item){
				array_push($items,array('id'=>$item['id'],'name'=>$item['title'],'linkcode'=>'{siteUrl}/index.php?g=Wap&m=Wedding&a=index&token='.$this->token.'&wecha_id={wechat_id}&id='.$item['id'],'linkurl'=>'','keyword'=>$item['keyword']));
			}
		}
		//
		$this->assign('list',$items);
		$this->assign('page',$show);
		$this->display('detail');
	}
	public function Lottery(){
		$moduleName='Lottery';
		$this->assign('moduleName',$this->modules[$moduleName]);
		$db=M($moduleName);
		$where=$this->where;
		$where['type']=1;
		$count      = $db->where($where)->count();
		$Page       = new Page($count,5);
		$show       = $Page->show();
		$list=$db->where($where)->limit($Page->firstRow.','.$Page->listRows)->order('id DESC')->select();
		//
		$items=array();
		if ($list){
			foreach ($list as $item){
				array_push($items,array('id'=>$item['id'],'name'=>$item['title'],'linkcode'=>'{siteUrl}/index.php?g=Wap&m=Lottery&a=index&token='.$this->token.'&wecha_id={wechat_id}&id='.$item['id'],'linkurl'=>'','keyword'=>$item['keyword']));
			}
		}
		//
		$this->assign('list',$items);
		$this->assign('page',$show);
		$this->display('detail');
	}
	public function Guajiang(){
		$moduleName='Guajiang';
		$this->assign('moduleName',$this->modules[$moduleName]);
		$db=M('Lottery');
		$where=$this->where;
		$where['type']=2;
		$count      = $db->where($where)->count();
		$Page       = new Page($count,5);
		$show       = $Page->show();
		$list=$db->where($where)->limit($Page->firstRow.','.$Page->listRows)->order('id DESC')->select();
		//
		$items=array();
		if ($list){
			foreach ($list as $item){
				array_push($items,array('id'=>$item['id'],'name'=>$item['title'],'linkcode'=>'{siteUrl}/index.php?g=Wap&m=Guajiang&a=index&token='.$this->token.'&wecha_id={wechat_id}&id='.$item['id'],'linkurl'=>'','keyword'=>$item['keyword']));
			}
		}
		//
		$this->assign('list',$items);
		$this->assign('page',$show);
		$this->display('detail');
	}
	public function Coupon(){
		$moduleName='Coupon';
		$this->assign('moduleName',$this->modules[$moduleName]);
		$db=M('Lottery');
		$where=$this->where;
		$where['type']=3;
		$count      = $db->where($where)->count();
		$Page       = new Page($count,5);
		$show       = $Page->show();
		$list=$db->where($where)->limit($Page->firstRow.','.$Page->listRows)->order('id DESC')->select();
		//
		$items=array();
		if ($list){
			foreach ($list as $item){
				array_push($items,array('id'=>$item['id'],'name'=>$item['title'],'linkcode'=>'{siteUrl}/index.php?g=Wap&m=Coupon&a=index&token='.$this->token.'&wecha_id={wechat_id}&id='.$item['id'],'linkurl'=>'','keyword'=>$item['keyword']));
			}
		}
		//
		$this->assign('list',$items);
		$this->assign('page',$show);
		$this->display('detail');
	}
	public function LuckyFruit(){
		$moduleName='LuckyFruit';
		$this->assign('moduleName',$this->modules[$moduleName]);
		$db=M('Lottery');
		$where=$this->where;
		$where['type']=4;
		$count      = $db->where($where)->count();
		$Page       = new Page($count,5);
		$show       = $Page->show();
		$list=$db->where($where)->limit($Page->firstRow.','.$Page->listRows)->order('id DESC')->select();
		//
		$items=array();
		if ($list){
			foreach ($list as $item){
				array_push($items,array('id'=>$item['id'],'name'=>$item['title'],'linkcode'=>'{siteUrl}/index.php?g=Wap&m=LuckyFruit&a=index&token='.$this->token.'&wecha_id={wechat_id}&id='.$item['id'],'linkurl'=>'','keyword'=>$item['keyword']));
			}
		}
		//
		$this->assign('list',$items);
		$this->assign('page',$show);
		$this->display('detail');
	}
	public function GoldenEgg(){
		$moduleName='GoldenEgg';
		$this->assign('moduleName',$this->modules[$moduleName]);
		$db=M('Lottery');
		$where=$this->where;
		$where['type']=5;
		$count      = $db->where($where)->count();
		$Page       = new Page($count,5);
		$show       = $Page->show();
		$list=$db->where($where)->limit($Page->firstRow.','.$Page->listRows)->order('id DESC')->select();
		//
		$items=array();
		if ($list){
			foreach ($list as $item){
				array_push($items,array('id'=>$item['id'],'name'=>$item['title'],'linkcode'=>'{siteUrl}/index.php?g=Wap&m=GoldenEgg&a=index&token='.$this->token.'&wecha_id={wechat_id}&id='.$item['id'],'linkurl'=>'','keyword'=>$item['keyword']));
			}
		}
		//
		$this->assign('list',$items);
		$this->assign('page',$show);
		$this->display('detail');
	}
	public function Research(){
		$moduleName='Research';
		$this->assign('moduleName',$this->modules[$moduleName]);
		$db=M('Research');
		$where=$this->where;
		$count      = $db->where($where)->count();
		$Page       = new Page($count,5);
		$show       = $Page->show();
		$list=$db->where($where)->limit($Page->firstRow.','.$Page->listRows)->order('id DESC')->select();
		//
		$items=array();
		if ($list){
			foreach ($list as $item){
				array_push($items,array('id'=>$item['id'],'name'=>$item['title'],'linkcode'=>'{siteUrl}/index.php?g=Wap&m=Research&a=index&token='.$this->token.'&wecha_id={wechat_id}&reid='.$item['id'],'linkurl'=>'','keyword'=>$item['keyword']));
			}
		}
		//
		$this->assign('list',$items);
		$this->assign('page',$show);
		$this->display('detail');
	}
	public function GreetingCard(){
		$moduleName='GreetingCard';
		$this->assign('moduleName',$this->modules[$moduleName]);
		$db=M('greeting_card');
		$where=$this->where;
		$where['type']=5;
		$count      = $db->where($where)->count();
		$Page       = new Page($count,5);
		$show       = $Page->show();
		$list=$db->where($where)->limit($Page->firstRow.','.$Page->listRows)->order('id DESC')->select();
		//
		$items=array();
		if ($list){
			foreach ($list as $item){
				array_push($items,array('id'=>$item['id'],'name'=>$item['title'],'linkcode'=>'{siteUrl}/index.php?g=Wap&m=Greeting_card&a=index&token='.$this->token.'&wecha_id={wechat_id}&id='.$item['id'],'linkurl'=>'','keyword'=>$item['keyword']));
			}
		}
		//
		$this->assign('list',$items);
		$this->assign('page',$show);
		$this->display('detail');
	}
	public function Vote(){
		$moduleName='Vote';
		$this->assign('moduleName',$this->modules[$moduleName]);
		$db=M($moduleName);
		$where=$this->where;
		$count      = $db->where($where)->count();
		$Page       = new Page($count,5);
		$show       = $Page->show();
		$list=$db->where($where)->limit($Page->firstRow.','.$Page->listRows)->order('id DESC')->select();
		//
		$items=array();
		if ($list){
			foreach ($list as $item){
				array_push($items,array('id'=>$item['id'],'name'=>$item['title'],'linkcode'=>'{siteUrl}/index.php?g=Wap&m=Vote&a=index&token='.$this->token.'&wecha_id={wechat_id}&id='.$item['id'],'linkurl'=>'','keyword'=>$item['keyword']));
			}
		}
		//
		$this->assign('list',$items);
		$this->assign('page',$show);
		$this->display('detail');
	}
	public function Shop(){
		$moduleName='Shop';
		$this->assign('moduleName',$this->modules[$moduleName]);
		$db=M('Product_cat');
		$where=array('dining'=>0,'token'=>$this->token);
		$count      = $db->where($where)->count();
		$Page       = new Page($count,5);
		$show       = $Page->show();
		$list=$db->where($where)->limit($Page->firstRow.','.$Page->listRows)->order('id DESC')->select();
		//
		$items=array();
		if ($list){
			foreach ($list as $item){
				array_push($items,array('id'=>$item['id'],'name'=>$item['name'],'linkcode'=>'{siteUrl}/index.php?g=Wap&m=Store&a=products&token='.$this->token.'&wecha_id={wechat_id}&catid='.$item['id'],'linkurl'=>'','keyword'=>'商城'));
			}
		}
		//
		$this->assign('list',$items);
		$this->assign('page',$show);
		$this->display('detail');
	}
	public function Estate(){
		$moduleName='Estate';
		$this->assign('moduleName',$this->modules[$moduleName]);
		//
		$items=array();
		array_push($items,array('id'=>1,'name'=>'楼盘介绍','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Estate&a=index&token='.$this->token.'&wecha_id={wechat_id}','linkurl'=>'','keyword'=>'微房产'));
		array_push($items,array('id'=>2,'name'=>'楼盘相册','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Estate&a=album&token='.$this->token.'&wecha_id={wechat_id}','linkurl'=>'','keyword'=>'微房产'));
		array_push($items,array('id'=>3,'name'=>'户型全景','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Estate&a=housetype&token='.$this->token.'&wecha_id={wechat_id}','linkurl'=>'','keyword'=>'微房产'));
		array_push($items,array('id'=>4,'name'=>'专家点评','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Estate&a=impress&token='.$this->token.'&wecha_id={wechat_id}','linkurl'=>'','keyword'=>'微房产'));
		$Estate=M('Estate')->where(array('token'=>$this->token))->find();
		$rt=M('Reservation')->where(array('id'=>$Estate['res_id']))->find();
		array_push($items,array('id'=>5,'name'=>'看房预约','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Reservation&a=index&rid='.$Estate['res_id'].'&token='.$this->token.'&wecha_id={wechat_id}','linkurl'=>'','keyword'=>$rt['keyword']));
		$this->assign('list',$items);
		$this->display('detail');
	}
	public function Car(){
		$moduleName='Car';
		$this->assign('moduleName',$this->modules[$moduleName]);
		//
		$thisItem=M('Carset')->where(array('token'=>$this->token))->find();
		$thisItemNews=M('Carnews')->where(array('token'=>$this->token))->find();
		$items=array();
		array_push($items,array('id'=>1,'name'=>'经销车型','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Car&a=brands&token='.$this->token.'&wecha_id={wechat_id}','linkurl'=>'','keyword'=>$thisItem['keyword']));
		array_push($items,array('id'=>2,'name'=>'销售顾问','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Car&a=salers&token='.$this->token.'&wecha_id={wechat_id}','linkurl'=>'','keyword'=>$thisItem['keyword']));
		array_push($items,array('id'=>3,'name'=>'车主关怀','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Car&a=owner&token='.$this->token.'&wecha_id={wechat_id}','linkurl'=>'','keyword'=>$thisItem['keyword']));
		array_push($items,array('id'=>4,'name'=>'车型欣赏','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Car&a=showcar&token='.$this->token.'&wecha_id={wechat_id}','linkurl'=>'','keyword'=>$thisItem['keyword']));
		array_push($items,array('id'=>5,'name'=>'实用工具','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Car&a=tool&token='.$this->token.'&wecha_id={wechat_id}','linkurl'=>'','keyword'=>$thisItem['keyword']));
		array_push($items,array('id'=>6,'name'=>'预约试驾','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Car&a=CarReserveBook&addtype=drive&token='.$this->token.'&wecha_id={wechat_id}','linkurl'=>'','keyword'=>$thisItem['keyword']));
		array_push($items,array('id'=>7,'name'=>'预约保养','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Car&a=CarReserveBook&addtype=maintain&token='.$this->token.'&wecha_id={wechat_id}','linkurl'=>'','keyword'=>$thisItem['keyword']));
		//
		array_push($items,array('id'=>8,'name'=>'最新车讯','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Index&a=lists&classid='.$thisItemNews['news_id'].'&token='.$this->token.'&wecha_id={wechat_id}','linkurl'=>'','keyword'=>$thisItem['keyword']));
		array_push($items,array('id'=>9,'name'=>'最新优惠','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Index&a=lists&classid='.$thisItemNews['pre_id'].'&token='.$this->token.'&wecha_id={wechat_id}','linkurl'=>'','keyword'=>$thisItem['keyword']));
		array_push($items,array('id'=>10,'name'=>'尊享二手车','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Index&a=lists&classid='.$thisItemNews['usedcar_id'].'&token='.$this->token.'&wecha_id={wechat_id}','linkurl'=>'','keyword'=>$thisItem['keyword']));
		array_push($items,array('id'=>11,'name'=>'品牌相册','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Photo&a=plist&id='.$thisItemNews['album_id'].'&token='.$this->token.'&wecha_id={wechat_id}','linkurl'=>'','keyword'=>$thisItem['keyword']));
		array_push($items,array('id'=>12,'name'=>'店铺LBS','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Company&a=map&companyid='.$thisItemNews['company_id'].'&token='.$this->token.'&wecha_id={wechat_id}','linkurl'=>'','keyword'=>$thisItem['keyword']));
		$this->assign('list',$items);
		$this->display('detail');
	}
	public function Medical(){
		$moduleName='Medical';
		$this->assign('moduleName',$this->modules[$moduleName]);
		//
		$thisItem=M('Medical_set')->where(array('token'=>$this->token))->find();
		//$thisItemNews=M('Carnews')->where(array('token'=>$this->token))->find();
		$items=array();
		array_push($items,array('id'=>1,'name'=>'医院简介','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Medical&a=Introduction&token='.$this->token.'&wecha_id={wechat_id}','linkurl'=>'','keyword'=>$thisItem['keyword']));
		array_push($items,array('id'=>2,'name'=>'热点聚焦','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Medical&a=publicListTmp&type=hotfocus&token='.$this->token.'&wecha_id={wechat_id}','linkurl'=>'','keyword'=>$thisItem['keyword']));
		array_push($items,array('id'=>3,'name'=>'医院专家','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Medical&&a=publicListTmp&type=experts&token='.$this->token.'&wecha_id={wechat_id}','linkurl'=>'','keyword'=>$thisItem['keyword']));
		array_push($items,array('id'=>4,'name'=>'尖端设备','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Medical&a=publicListTmp&type=equipment&token='.$this->token.'&wecha_id={wechat_id}','linkurl'=>'','keyword'=>$thisItem['keyword']));
		array_push($items,array('id'=>5,'name'=>'康复案例','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Medical&a=publicListTmp&type=rcase&token='.$this->token.'&wecha_id={wechat_id}','linkurl'=>'','keyword'=>$thisItem['keyword']));
		array_push($items,array('id'=>6,'name'=>'先进技术','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Medical&&a=publicListTmp&type=technology&token='.$this->token.'&wecha_id={wechat_id}','linkurl'=>'','keyword'=>$thisItem['keyword']));
		array_push($items,array('id'=>6,'name'=>'研发药物','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Medical&&a=publicListTmp&type=drug&token='.$this->token.'&wecha_id={wechat_id}','linkurl'=>'','keyword'=>$thisItem['keyword']));
		array_push($items,array('id'=>6,'name'=>'预约挂号','linkcode'=>'{siteUrl}/index.php?g=Wap&m=Medical&&a=registered&token='.$this->token.'&wecha_id={wechat_id}','linkurl'=>'','keyword'=>$thisItem['keyword']));
		//
	
		$this->assign('list',$items);
		$this->display('detail');
	}
	public function School(){
		$moduleName='School';
		$this->assign('moduleName',$this->modules[$moduleName]);
		//
		$thisItem=M('Medical_set')->where(array('token'=>$this->token))->find();
		//$thisItemNews=M('Carnews')->where(array('token'=>$this->token))->find();
		$items=array();
		array_push($items,array('id'=>1,'name'=>'成绩查询','linkcode'=>'{siteUrl}/index.php?g=Wap&m=School&a=qresults&token='.$this->token.'&wecha_id={wechat_id}','linkurl'=>'','keyword'=>$thisItem['keyword']));
		array_push($items,array('id'=>1,'name'=>'食谱列表','linkcode'=>'{siteUrl}/index.php?g=Wap&m=School&a=public_list&type=school&token='.$this->token.'&wecha_id={wechat_id}','linkurl'=>'','keyword'=>$thisItem['keyword']));
		//
	
		$this->assign('list',$items);
		$this->display('detail');
	}
	
//外链小工具
	
	public function OutsideLink(){
		//处理小工具数组文件
			$f = include('./PigCms/Lib/ORG/Func.links.php');
		//取出分类总汇
			$i=0;
		foreach ($f['func'] as $k=>$v){
			
			$list[$i]['name'] = $v;
			$list[$i]['code'] = $k;
			$i++;
		}

		$this->assign('list',$list);
		$this->display();
	}
	
	public function outsideLinkDetail(){
		$c = $this->_get('c');
		
		$f = include('./PigCms/Lib/ORG/Func.links.php');
		
		$list = $f[$c];
		$this->assign('list',$list);
		$this->display('OutsideLink');
	
	}
	public function Business(){
		$this->assign('moduleName',$this->modules['Business']);
		$db=M('Busines');
		$where=$this->where;
		$count      = $db->where($where)->count();
		$Page       = new Page($count,5);
		$show       = $Page->show();
		$list=$db->where($where)->limit($Page->firstRow.','.$Page->listRows)->order('bid DESC')->select();
		//
		$items=array();
		if ($list){
			foreach ($list as $item){
				array_push($items,array('bid'=>$item['bid'],'name'=>$item['mtitle'],'linkcode'=>'{siteUrl}/index.php?g=Wap&m=Business&a=index&token='.$this->token.'&wecha_id={wechat_id}&bid='.$item['bid'].'&type='.$item['type'],'linkurl'=>'','keyword'=>$item['keyword']));
			}
		}
		$this->assign('list',$items);
		$this->assign('page',$show);
		$this->display('detail');
	}
	
}


?>