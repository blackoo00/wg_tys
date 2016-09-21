<?php 
	class DoctorAction extends UserAction{
		//医生列表
		public function index(){
		$db=D(MODULE_NAME);
		if($_POST){
			$where=" name like '%".$_POST['search']."%' ";
		}
		//显示分页
		$count      = count($db->relation(true)->select());       
        $Page       = new Page($count,10);//每页显示一个
    	$show       = $Page->show();
    	$this->assign('page',$show);	

    	if($where){
    		$doctor = $db->relation(true)->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
    	}else{
    		$doctor = $db->relation(true)->limit($Page->firstRow.','.$Page->listRows)->select();
    	}
		$this->assign('doctor',$doctor);
		$this->display();
		}
		//查看详细信息
		public function details(){
			$id=$this->_get('id','intval');//获取医生ID
			$db=D(MODULE_NAME);
			$doctor=$db->relation(true)->where('id='.$id)->find();
			$dailyconsult=$doctor['consult'];
			$dcnums=0;
			foreach ($dailyconsult as $k => $v) {
				$date1=strtotime('today');
				$date2=$date1+86400;
				if($v['time']>=$date1&&$v['time']<$date2){
					$dcnums++;
				}
			}
			$this->assign('dcnums',$dcnums);
			$this->assign('info',$doctor);
			$this->display();
		}
		//新增医生页面
		public function add(){
			$db=D('Hospital');
			$hname=$db->field('name,id')->select();
			$this->assign('hname',$hname);
			$this->display();
		}
		//新增医生
		public function insert(){
			$db=D(MODULE_NAME);
			$where['username']=$_POST['username'];
			$doctor=$db->where($where)->find();
			if($doctor){
				$this->error('用户名已存在', U('Doctor/add'));
			}
			if ($db->create() === false) {
	            $this->error($db->getError());
	        }
	        $r=$db->add();
			$h=D('Hospital');
			if($r){
				$where ['id'] = $_POST['hid'];
				$r=$h->where($where)->setInc('doctornum'); 
				if(!$r){
					Log::write("医院医生数量自增失败!",'ERR');
				}else{
					$this->success('添加成功',U('Doctor/index'));
				}
			}else{
				Log::write("新增医生失败,错误信息!",'ERR');
			}
		}
		//删除医生
		public function del(){
			$where['id']=$this->_get('id','intval');
			if(D(MODULE_NAME)->where($where)->delete()){
				$this->success('操作成功',U(MODULE_NAME.'/index'));
				//删除医院中相对应的医生
				$h=D('Hospital');
				$where ['id'] = $this->_get('hid','intval');
				$r=$h->where($where)->setDec('doctornum'); 
				if(!$r){
					Log::write("医院医生数量自减失败!",'ERR');
				}
			}else{
				$this->error('操作失败',U(MODULE_NAME.'/index'));
			}
		}
		//编辑医生
		public function edit(){
			$where['id']=$this->_get('id','intval');
			$res=D(MODULE_NAME)->where($where)->find();
			$this->assign('info',$res);
			$db=D('Hospital');
			$hname=$db->field('id,name')->select();
			$this->assign('hname',$hname);
			$this->display();
		}
		//编辑登陆信息
		public function editlogin(){
			$db=D(MODULE_NAME);
			if ($db->create() === false) {
	            $this->error($db->getError());
	        }else {
	            $id = $db->save();
	            if ($id == true) {
	                $this->success('操作成功', U(MODULE_NAME . '/index'));
	            } else {
	                $this->error('操作失败', U(MODULE_NAME . '/index'));
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
			echo $newstr;
		}
		//更新医生信息
		public function upsave(){
			$r=$this->all_save();
			if($r){
				$h=D('Hospital');
				//判断所属医院有没有修改如果不相等就对医院医生数操作
				if($_POST['hid']!= $_POST['hid2']){
					//增加医生数
					$where['id'] = $_POST['hid'];
					$r=$h->where($where)->setInc('doctornum'); 
					//减少医生数
					$where2['id'] = $_POST['hid2'];
					$r2=$h->where($where2)->setDec('doctornum'); 
					if(!$r&&!$r2){
						Log::write("医院医生数量操作失败!",'ERR');
					}
				}
			}
		}
	}
 ?>