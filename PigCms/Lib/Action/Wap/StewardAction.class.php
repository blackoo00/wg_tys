<?php 
	class StewardAction extends WapAction{
		public function index(){
			$this->display();
		}
		public function info(){
			$db=D('Custom');
			if($_POST==NULL){
				$where['openid']=$this->wecha_id;
				$custom=$db->where($where)->find();
				$this->assign('custom',$custom);
				$this->display();
			}else{
				if ($db->create() === false) {
		            $this->error($db->getError());
		        } else {
		            $id = $db->save();
		            if ($id == true) {
		                $this->success('操作成功', U('Steward/info',array('token'=>$this->token,'wecha_id'=>$this->wecha_id)));
		            } else {
		                $this->error('数据未改动', U('Steward/info',array('token'=>$this->token,'wecha_id'=>$this->wecha_id)));
		            }
		        }
			}
		}
		//血糖记录
		public function bsuger(){
			if($_POST==NULL){
				// $t1=strtotime('today');
				// $t2=strtotime('today')+86400;
				// $where['openid']=$this->wecha_id;
				// $where['recordtime']=array('between',array($t1,$t2));
				// //胰岛素记录(当天)
				// $db=D('Insulin');
				// $insulin=$db->where($where)->find();
				// $this->assign('insulin',$insulin);
				// //口服药记录
				// $db=D('Medicine');
				// $medicine=$db->where($where)->find();
				// $this->assign('medicine',$medicine);
				//血糖记录
				$db=D('Bsuger');
				$where2['openid']=$this->wecha_id;
				$bsuger=$db->where($where2)->order('recordtime desc')->limit(7)->select();
				$this->assign('bsuger',$bsuger);
				$this->display();
			}else{//有上传信息
				/*$t1=strtotime('today');
				$t2=strtotime('today')+86400;*/
				$t1=strtotime($_POST['RecordTime']);
				// $t1=floor($t1/86400)*86400;
				$t1=strtotime(date('Y-m-d',$t1));
				$t2=$t1+86400;
				$where['openid']=$this->wecha_id;
				$where['recordtime']=array('between',array($t1,$t2));
				$db=D('Bsuger');
				$bsuger=$db->where($where)->find();
				if($bsuger){//更新
					$data[$_POST['TimeSlice']]=$_POST['Number'];
					$r=$db->where($where)->save($data);
					if($r||$r==0){
						$result=array(
							'res'=>'ok',
							'msg'=>'提交成功',
							'url'=>U('Steward/bsuger',array('token'=>$this->token,'wecha_id'=>$this->wecha_id)),
						);
						echo $this->JSON($result); 
					}else{
						$result=array(
							'res'=>'fail',
							'msg'=>'修改出错',
							'url'=>U('Steward/bsuger',array('token'=>$this->token,'wecha_id'=>$this->wecha_id)),
						);
						echo $this->JSON($result); 
					}
				}else{//添加
					$ccondition['openid']=$this->wecha_id;
					$custom=D('Custom')->where($ccondition)->find();
					$data=array(
					//'bloodsuger'=>$_POST['Number'],
					$_POST['TimeSlice']=>$_POST['Number'],
					'recordtime'=>date(strtotime($_POST['RecordTime'])),
					'cid'=>$custom['id'],
					//'timeslice'=>$_POST['TimeSlice'],
					//'note'=>$_POST['Remark'],
					'openid'=>$this->wecha_id,
					);
					$r=$db->add($data);
					if($r){
						$result=array(
							'res'=>'ok',
							'msg'=>'提交成功',
							'url'=>U('Steward/bsuger',array('token'=>$this->token,'wecha_id'=>$this->wecha_id)),
						);
						echo $this->JSON($result); 
					}else{
						$result=array(
							'res'=>'fail',
							'msg'=>'修改出错',
							'url'=>U('Steward/bsuger',array('token'=>$this->token,'wecha_id'=>$this->wecha_id)),
						);
						echo $this->JSON($result); 
					}
				}
			}
		}
		//Ajax加载更多血糖数据
		public function loadmorebsuger(){
			$trnums=$this->_get('trnums','intval');
			if($trnums%7!=0){
				echo "error";
				exit();
			}else{
				$condition['openid']=$this->wecha_id;
				$limit1=$trnums;
				$limit2=$trnums+7;
				$bsuger=D('Bsuger')->where($condition)->limit($limit1.",".$limit2)->select();
				foreach ($bsuger as $k => $v) {
					$str.="<tr>";
					$str.="<td class='xtjl'>".friendlyDate($v['recordtime'],md,false)."</td>";
					$str.="<td class='xtjl'>".$v['lctxs']."</td>";
					$str.="<td class='xtjl'>".$v['kf']."</td>";
					$str.="<td class='xtjl'>".$v['zchtxs']."</td>";
					$str.="<td class='xtjl'>".$v['acq']."</td>";
					$str.="<td class='xtjl'>".$v['achtxs']."</td>";
					$str.="<td class='xtjl'>".$v['wcq']."</td>";
					$str.="<td class='xtjl'>".$v['wchtxs']."</td>";
					$str.="<td class='xtjl'>".$v['sq']."</td>";
					$str.="</tr>";
					echo $str;
				}
			}
		}
		//显示血糖曲线
		// public function bsugercurve(){
		// 	$db=D('Bsuger');
		// 	$where['openid']=$this->wecha_id;
		// 	$bsuger=$db->where($where)->order('recordtime desc')->limit(7)->select();
		// 	$data=array();
		// 	foreach ($bsuger as $k => $v) {
		// 		$data['zcqkf'].=$v['kf']?"{x:".$v['recordtime']."000,y:".$v['kf']."},":NULL;
		// 		$data['zch2'].=$v['zchtxs']?"{x:".$v['recordtime']."000,y:".$v['zchtxs']."},":NULL;
		// 		$data['zwccq'].=$v['acq']?"{x:".$v['recordtime']."000,y:".$v['acq']."},":NULL;
		// 		$data['wcch2'].=$v['achtxs']?"{x:".$v['recordtime']."000,y:".$v['achtxs']."},":NULL;
		// 		$data['wch2'].=$v['wchtxs']?"{x:".$v['recordtime']."000,y:".$v['wchtxs']."},":NULL;
		// 		$data['sqlc3'].=$v['sq']?"{x:".$v['recordtime']."000,y:".$v['sq']."},":NULL;
		// 	}
		// 	$curve="[  
		// 			{ name: '空腹', data: [".$data['zcqkf']."] },
		// 			{ name: '早餐后2小时', data: [".$data['zch2']."] },
		// 			{ name: '午餐前', data: [".$data['zwccq']."] },
		// 			{ name: '午餐后2小时', data: [".$data['wcch2']."] },
		// 			{ name: '晚餐餐前', data: [".$data['wccq']."] },
		// 			{ name: '晚餐后2小时', data: [".$data['wch2']."] },
		// 			{ name: '睡前', data: [".$data['sqlc3']."] },
		// 			{ name: '凌晨3点', data: [".$data['lctxs']."] },
		// 		   ]";
		// 	echo $curve;
		// } 
		//json的中文ASC的转码
		 public function JSON($array) {
		     $this->arrayRecursive($array, 'urlencode', true);
		     $json = json_encode($array);
		     return urldecode($json);
		 }
		 public function arrayRecursive(&$array, $function, $apply_to_keys_also = false)
		 {
		     static $recursive_counter = 0;
		     if (++$recursive_counter > 1000) {
		         die('possible deep recursion attack');
		     }
		     foreach ($array as $key => $value) {
		         if (is_array($value)) {
		             arrayRecursive($array[$key], $function, $apply_to_keys_also);
		         } else {
		             $array[$key] = $function($value);
		         }
		  
		         if ($apply_to_keys_also && is_string($key)) {
		             $new_key = $function($key);
		             if ($new_key != $key) {
		                 $array[$new_key] = $array[$key];
		                 unset($array[$key]);
		             }
		         }
		     }
			
		     $recursive_counter--;
			
		 }
		//重要指标
		public function bprotein(){
			if($_POST==NULL){
				$db=D('Bprotein');
				$info=$db->where(array('openid'=>$this->wecha_id))->find();
				if($info){
					$this->assign('info',$info);
				}
				$this->display();
			}else{
				$db=D('Bprotein');
				$_POST['openid'] = $this->wecha_id;
				if($_POST['id']){
					if ($db->create() === false) {
			            $this->error($db->getError());
			        }
			        $id= $db->save();
			        if ($id == true) {
		                $this->success('操作成功', U('Steward/bprotein',array('token'=>$this->token,'wecha_id'=>$this->wecha_id)));
		            } else {
		                $this->error('数据未改动', U('Steward/bprotein',array('token'=>$this->token,'wecha_id'=>$this->wecha_id)));
		            }
				}else{
					//添加
					$ccondition['openid']=$this->wecha_id;
					$custom=D('Custom')->where($ccondition)->find();
					$db=D('Bprotein');
					if ($db->create() === false) {
			            $this->error($db->getError());
			        }
			        $db->cid=$custom['id'];
			        $id= $db->add();
			        if ($id == true) {
		                $this->success('操作成功', U('Steward/bprotein',array('token'=>$this->token,'wecha_id'=>$this->wecha_id)));
		            } else {
		                $this->error('操作失败', U('Steward/bprotein',array('token'=>$this->token,'wecha_id'=>$this->wecha_id)));
		            }
				}
				// $data=array(
				// 	'numerical'=>$_POST['Number'],
				// 	'recordtime'=>date(strtotime($_POST['RecordTime']))*1000,
				// 	'note'=>$_POST['Remark'],
				// 	'openid'=>$this->wecha_id,
				// );
				// $r=$db->add($data);
				// if($r){
				// 	$result=array(
				// 		'res'=>'ok',
				// 		'msg'=>'提交成功',
				// 		'url'=>U('Steward/bprotein',array('token'=>$this->token)),
				// 	);
				// 	echo $this->JSON($result); 
				// }else{
				// 	$result=array(
				// 		'res'=>'fail',
				// 		'msg'=>'修改出错',
				// 	);
				// 	echo $this->JSON($result); 
				// }
			}
		}
		//糖化血红蛋白曲线
		public function bproteincurve(){
			$db=D('Bprotein');
			$where['openid']=$this->wecha_id;
			$bprotein=$db->where($where)->order('recordtime desc')->limit(7)->select();
			//此处时间戳多一个月在timeform.js修改
			foreach ($bprotein as $k => $v) {
				$curve.="{x:".$v['recordtime'].",y:".$v['numerical']."},";
			}
			echo "[".$curve."]";
		}
		//化验数据
		public function laboratory(){
			// if($_POST==NULL){
			// 	$this->display();
			// }else{
			// 	$db=D('Laboratory');
			// 	$data=array(
			// 		'triglycerides'=>$_POST['GYSZNo'],
			// 		'cholesterol'=>$_POST['ZDGCNo'],
			// 		'serumcreatinine'=>$_POST['XJGNo'],
			// 		'blooduricacid'=>$_POST['XNSNo'],
			// 		'ualbumin'=>$_POST['NWLBDBNo'],
			// 		'recordtime'=>date(strtotime($_POST['RecordTime']))*1000,
			// 		'note'=>$_POST['Remark'],
			// 		'openid'=>$this->wecha_id,
			// 	);
			// 	$r=$db->add($data);
			// 	if($r){
			// 		$result=array(
			// 			'res'=>'ok',
			// 			'msg'=>'提交成功',
			// 			'url'=>U('Steward/laboratory',array('token'=>$this->token)),
			// 		);
			// 		echo $this->JSON($result); 
			// 	}else{
			// 		$result=array(
			// 			'res'=>'fail',
			// 			'msg'=>'修改出错',
			// 		);
			// 		echo $this->JSON($result); 
			// 	}
			// }

			$db=D('Laboratory');
			$where['openid']=$this->wecha_id;
			$info=$db->where($where)->select();
			$this->assign('info',$info);
			$this->display();
		}
		//AJAX上传化验数据图片
		
		public function laboratorypic(){
			import("@.ORG.UploadFile");
			$config = array(
					'savePath'      =>  'uploads/laboratory/', //保存路径
					'thumb'             =>  true,
					'thumbMaxWidth'     =>  '800',// 缩略图最大宽度
					'thumbMaxHeight'    =>  '800',// 缩略图最大高度
					'thumbPath'         =>  'uploads/laboratory/',// 缩略图保存路径
					'thumbRemoveOrigin' =>  true,// 是否移除原图
			);
			//上传图片
			$upload=new UploadFile($config);
			$z=$upload->uploadOne($_FILES['pic']);
			if($z){
				$pic=$z['0']['savepath']."thumb_".$z['0']['savename'];
				$ccondition['openid']=$this->wecha_id;
				$custom=D('Custom')->where($ccondition)->find();
				$data['cid']=$custom['id'];
				$data['pic']=$pic;
				$data['openid']=$this->wecha_id;
				$data['recordtime']=time();
				$db=D('Laboratory');
				$id=$db->add($data);
				if($id){
					echo json_encode("ok");
				}
			}else{
				echo json_encode($z);
			}
		}
		//删除验证图片
		public function dellaboratorypic(){
			$db=D('Laboratory');
			$where['id']=$this->_get('id','intval');
			$id=$db->where($where)->delete();
			if($id){
				echo "1";
			}
		}

		//显示化验数据曲线
		// public function laboratorycurve(){
		// 	$db=D('Laboratory');
		// 	$where['openid']=$this->wecha_id;
		// 	$bsuger=$db->where($where)->limit(7)->select();
		// 	$data=array();
		// 	foreach ($bsuger as $k => $v) {
		// 		$data['gysz'].="{x:".$v['recordtime'].",y:".$v['triglycerides']."},";
		// 		$data['zdgc'].="{x:".$v['recordtime'].",y:".$v['cholesterol']."},";
		// 		$data['xjg'].="{x:".$v['recordtime'].",y:".$v['serumcreatinine']."},";
		// 		$data['xns'].="{x:".$v['recordtime'].",y:".$v['blooduricacid']."},";
		// 		$data['nwl'].="{x:".$v['recordtime'].",y:".$v['ualbumin']."},";
		// 	}
		// 	$curve="[  
		// 			{ name: '甘油三酯', data: [".$data['gysz']."] },
		// 			{ name: '总胆固醇', data: [".$data['zdgc']."] },
		// 			{ name: '血肌酐', data: [".$data['xjg']."] },
		// 			{ name: '血尿酸', data: [".$data['xns']."] },
		// 			{ name: '尿微量白蛋白', data: [".$data['nwl']."] },
		// 		   ]";
		// 	echo $curve;
		// }
		// //用药记录
		// public function medicine(){
		// 	$db=D('Medicine');
		// 	$where['openid']=$this->openid;
		// 	$medicine=$db->where($where)->select();
		// 	$this->assign('medicine',$medicine);
		// 	$this->display();
		// }
		// //修改用药记录
		// public function mupdate(){
		// 	$db = D('Medicine');
		// 	if($_POST==NULL){
		// 		$id=$this->_get('id','intval');
		// 		if($id){
		// 			$where['id']=$id;
		// 			$medicine=$db->where($where)->find();
		// 			$this->assign('medicine',$medicine);
		// 			$this->display();
		// 		}
		// 	}else{
	 //            $data=array();
	 //            $data['id']=$_POST['mid'];
		// 		$data['oralmedicine']=$_POST['Name'];
		// 		$data['starttime']=$_POST['StartTime'];
		// 		$data['endtime']=$_POST['EndTime'];
		// 		$data['note']=$_POST['Remark'];
	 //            $r = $db->save($data);
	 //            if($r){
		// 			$result=array(
		// 				'res'=>'ok',
		// 				'msg'=>'修改成功',
		// 				'url'=>U('Steward/medicine',array('token'=>$this->token)),
		// 			);
		// 			echo $this->JSON($result); 
		// 		}else{
		// 			$result=array(
		// 				'res'=>'fail',
		// 				'msg'=>'修改出错',
		// 			);
		// 			echo $this->JSON($result); 
		// 		}
		// 	}
		// }
		// //添加用药记录
		// public function minsert(){
		// 	if($_POST==NULL){
		// 		$this->display();
		// 	}else{
		// 		$db = D('Medicine');
		// 		$data=array();
		// 		$data['oralmedicine']=$_POST['Name'];
		// 		$data['starttime']=$_POST['StartTime'];
		// 		$data['endtime']=$_POST['EndTime'];
		// 		$data['note']=$_POST['Remark'];
		// 		$data['openid']=$this->wecha_id;
	 //            $r = $db->add($data);
	 //            if($r){
		// 			$result=array(
		// 				'res'=>'ok',
		// 				'msg'=>'提交成功',
		// 				'url'=>U('Steward/medicine',array('token'=>$this->token)),
		// 			);
		// 			echo $this->JSON($result); 
		// 		}else{
		// 			$result=array(
		// 				'res'=>'fail',
		// 				'msg'=>'修改出错',
		// 			);
		// 			echo $this->JSON($result); 
		// 		}
		//添加用药记录
		public function minsert(){
			$data=explode(',', $this->_get('medicine'));
			$t1=strtotime('today');
			$t2=strtotime('today')+86400;
			$where['openid']=$this->wecha_id;
			$where['recordtime']=array('between',array($t1,$t2));
			$db=D('Medicine');
			$medicine=$db->where($where)->find();
			if($medicine){
				$medicine[$data['0']]=$data['1'];
				$r=$db->where($where)->save($medicine);
				if($r){
					echo "OK";
				}else{
					echo "error";
				}
			}else{
				$medicine[$data['0']]=$data['1'];
				$medicine['openid']=$this->wecha_id;
				$medicine['recordtime']=time();
				$r=$db->add($medicine);
				if($r){
					echo "OK";
				}else{
					echo "error";
				}
			}
		}   
		// 	}
		// }
		// //胰岛素记录
		// public function insulin(){
		// 	// show_bug(get_defined_constants());
		// 	// exit();
		// 	$db=D('Insulin');
		// 	$where['openid']=$this->openid;
		// 	$insulin=$db->where($where)->select();
		// 	$this->assign('insulin',$insulin);
		// 	$this->display();
		// }
		// //添加胰岛素记录
		// public function iinsert(){
		// 	if($_POST==NULL){
		// 		$this->display();
		// 	}else{
		// 		$db = D('Insulin');
		// 		$data=array();
		// 		$data['oralmedicine']=$_POST['Name'];
		// 		$data['starttime']=$_POST['StartTime'];
		// 		$data['endtime']=$_POST['EndTime'];
		// 		$data['note']=$_POST['Remark'];
		// 		$data['openid']=$this->wecha_id;
	 //            $r = $db->add($data);
	 //            if($r){
		// 			$result=array(
		// 				'res'=>'ok',
		// 				'msg'=>'提交成功',
		// 				'url'=>U('Steward/insulin',array('token'=>$this->token)),
		// 			);
		// 			echo $this->JSON($result); 
		// 		}else{
		// 			$result=array(
		// 				'res'=>'fail',
		// 				'msg'=>'修改出错',
		// 			);
		// 			echo $this->JSON($result); 
		// 		}
		        
		// 	}
		// }
		//添加胰岛素记录
		public function iinsert(){
			$data=explode(',', $this->_get('medicine'));
			$t1=strtotime('today');
			$t2=strtotime('today')+86400;
			$where['openid']=$this->wecha_id;
			$where['recordtime']=array('between',array($t1,$t2));
			$db=D('Insulin');
			$insulin=$db->where($where)->find();
			if($insulin){
				$insulin[$data['0']]=$data['1'];
				$r=$db->where($where)->save($insulin);
				if($r){
					echo "OK";
				}else{
					echo "error";
				}
			}else{
				$insulin[$data['0']]=$data['1'];
				$insulin['openid']=$this->wecha_id;
				$insulin['recordtime']=time();
				$r=$db->add($insulin);
				if($r){
					echo "OK";
				}else{
					echo "error";
				}
			}
		}
		// //修改胰岛素记录
		// public function iupdate(){
		// 	$db = D('Insulin');
		// 	if($_POST==NULL){
		// 		$id=$this->_get('id','intval');
		// 		if($id){
		// 			$where['id']=$id;
		// 			$insulin=$db->where($where)->find();
		// 			$this->assign('insulin',$insulin);
		// 			$this->display();
		// 		}
		// 	}else{
	 //            $data=array();
	 //            $data['id']=$_POST['iid'];
		// 		$data['oralmedicine']=$_POST['Name'];
		// 		$data['starttime']=$_POST['StartTime'];
		// 		$data['endtime']=$_POST['EndTime'];
		// 		$data['note']=$_POST['Remark'];
	 //            $r = $db->save($data);
	 //            if($r){
		// 			$result=array(
		// 				'res'=>'ok',
		// 				'msg'=>'修改成功',
		// 				'url'=>U('Steward/insulin',array('token'=>$this->token)),
		// 			);
		// 			echo $this->JSON($result); 
		// 		}else{
		// 			$result=array(
		// 				'res'=>'fail',
		// 				'msg'=>'修改出错',
		// 			);
		// 			echo $this->JSON($result); 
		// 		}
		// 	}
		// }
		//显示大图
		public function showbigpic(){
			$id=$this->_get('id');
			$src=$this->_get('src');
			$this->assign('src',$src);
			$this->assign('id',$id);
			$this->display();
		}
	}
 ?>