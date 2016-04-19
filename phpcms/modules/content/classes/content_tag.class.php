<?php
class content_tag {
	private $db;
	public function __construct() {
		$this->db = pc_base::load_model('content_model');
		$this->position = pc_base::load_model('position_data_model');
	}
	/**
	 * 初始化模型
	 * @param $catid
	 */
	public function set_modelid($catid) {
		static $CATS;
		$siteids = getcache('category_content','commons');
		if(!$siteids[$catid]) return false;
		$siteid = $siteids[$catid];
		if ($CATS[$siteid]) {
			$this->category = $CATS[$siteid];
		} else {
			$CATS[$siteid] = $this->category = getcache('category_content_'.$siteid,'commons');
		}
		if($this->category[$catid]['type']!=0) return false;
		$this->modelid = $this->category[$catid]['modelid'];
		$this->db->set_model($this->modelid);
		$this->tablename = $this->db->table_name;
		if(empty($this->category)) {
			return false;
		} else {
			return true;
		}
	}
	/**
	 * 分页统计
	 * @param $data
	 */
	public function count($data) {
		if($data['action'] == 'lists') {
			$catid = intval($data['catid']);
			if(!$this->set_modelid($catid)) return false;
			if(isset($data['where'])) {
				$sql = $data['where'];
			} else {
				if($this->category[$catid]['child']) {
					$catids_str = $this->category[$catid]['arrchildid'];
					$pos = strpos($catids_str,',')+1;
					$catids_str = substr($catids_str, $pos);
					$sql = "status=99 AND catid IN ($catids_str)";
				} else {
					$sql = "status=99 AND catid='$catid'";
				}
			}
			return $this->db->count($sql);
		}
	}
	
	/**
	 * 列表页标签
	 * @param $data
	 * 更新说明：
	 * 1. 增加keywords 限制条件
	 */
	public function lists($data) {
		// $catid = intval($data['catid']);
		$catid = trim($data['catid']);
		$keywords = safe_replace(trim($data['keywords'])); //新加keywords限制 
		$tagid = safe_replace(trim($data['tagid'])); //标签位置名：tagid，以便人工指定插入位置使用 
		$typeid = safe_replace($data['typeid']); //类型ID ，赛选文章所用
		$grade = intval($data['grade']); // 评分 
		if($data['modelid']){
			// if(!$this->db->set_model($data['modelid'])) return false;
			$this->modelid = $data['modelid'];
			$this->db->set_model($this->modelid);
			$this->tablename = $this->db->table_name;
		}else{
			//没有单独配置modelid，统一默认为news 
			if(!$this->set_modelid(9)) return false;
		}

		if(isset($data['where'])) {
			$sql = $data['where'];
		} else {
			$thumb = intval($data['thumb']) ? " AND thumb != ''" : '';
			if(strpos($catid,',')){//多栏目取数据
				$sql = "`status`=99 AND `catid` IN (".$catid.")".$thumb;
			}else{
				//只有一个catid，则判断是否有子栏目
				if($this->category[$catid]['child']) {
					$catids_str = $this->category[$catid]['arrchildid'];
					$pos = strpos($catids_str,',')+1;
					$catids_str = substr($catids_str, $pos);
					$sql = "status=99 AND catid IN ($catids_str)".$thumb;
				}else{
					$sql = "`status`=99 AND `catid`='$catid'".$thumb;
				}
			}
			// if($this->category[$catid]['child']) {
			// 	$catids_str = $this->category[$catid]['arrchildid'];
			// 	$pos = strpos($catids_str,',')+1;
			// 	$catids_str = substr($catids_str, $pos);
			// 	$sql = "status=99 AND catid IN ($catids_str)".$thumb;
			// } else {
			// 	$sql = "status=99 AND catid='$catid'".$thumb;
			// }
			//处理keywords 
			if($keywords!=''){
				if(strpos($keywords,',')){
					$keywords_array = explode(',', $keywords);
					$i = 1;
					foreach ($keywords_array as $key => $value) {
							# code...
							if($i==1){
								$sql .= " AND `keywords` like '%".$value."%'";
							}else{
								$sql .=  " or `keywords` like '%".$value."%'";
							}
							$i++;
						}	
				}else{
					$sql .=  " AND `keywords` like '%".$keywords."%'";
				}
			}
			//处理type 类别的限制条件 (多个type采用or,使用大括号包)
			if($typeid!=''){
				if(strpos($typeid,',')){
					$type_array = explode(',', $typeid);
					$typenum = count($type_array);
					$n = 1; 
					foreach ($type_array as $tk => $tv) {
						# code...
						if($n==1){
							$sql .= " AND (`typeid` =".$tv;
						}elseif($n==($typenum)){
							$sql .=  " or `typeid` =".$tv.")";
						}else{
							$sql .=  " or `typeid` =".$tv;
						}
						$n++;
					}
				}else{
					$sql .=  " AND `typeid`  = ".$typeid;
				}
			}
			//过滤评分
			if(isset($grade) && $grade>0) {
				$sql .=  " AND `grade`  = ".$grade;
			}
		}
		$order = $data['order'];

		$return = $this->db->select($sql, '*', $data['limit'], $order, '', '');


		if($tagid){
			//如果tagid存在，则调取插入的数据，并合并数组
			$add_article_db = pc_base::load_model('add_article_model');
	        $sql = array("tagid"=>$tagid,"status"=>99);//属于tagid 并且处于开放状态的文章
	        $insert_data = $add_article_db->select($sql, '*',10,'listorder asc', '', 'listorder');
	        
	        //对插入的数据进行缩略图重新索引
        	$new_insert = array();
        	if($data['thumbnum']){
				$thumb_str = "thumb_".$data['thumbnum'];
				if(!empty($insert_data)){
		        	foreach ($insert_data as $key => $value) {
		        		# code...
		        		$new_insert[$value['listorder']] = $value;
		        		$new_insert[$value['listorder']][$thumb_str] = $value['thumb'];
		        	}
	        	}
        	}else{
        		$new_insert = $insert_data;
        	}  

	        if(!empty($return)){//原数组不为空，进行新老合并
	        	if(!empty($new_insert)){
	        		foreach ($new_insert as $k => $v) { 
	        			# code...
		        		array_splice($return,$k-1,0,array($v));
	        		}
	        	}
		        // array_splice($return,1,0,$new_insert);
	        }else{//如果原数据为空，则用插入的数组直接替换老数据。
	        	$return = $new_insert;
	        }
		} 


		$return = array_slice($return,0,$data['limit']);

		//调用副表的数据
		if (isset($data['moreinfo']) && intval($data['moreinfo']) == 1) {
			$ids = array();
			foreach ($return as $v) {
				if (isset($v['id']) && !empty($v['id'])) {
					$ids[] = $v['id'];
				} else {
					continue;
				}
			}
			if (!empty($ids)) {
				$this->db->table_name = $this->db->table_name.'_data';
				$ids = implode('\',\'', $ids);
				$r = $this->db->select("`id` IN ('$ids')", '*', '', '', '', 'id');
				if (!empty($r)) {
					foreach ($r as $k=>$v) {
						if (isset($return[$k])) $return[$k] = array_merge($v, $return[$k]);
					}
				}
			}
		}
		return $return;
	}

	public function lists_bak($data) {
		$catid = intval($data['catid']);
		$keywords = safe_replace(trim($data['keywords'])); //新加keywords限制 
		$typeid = safe_replace($data['typeid']); //新加type 
		if(!$this->set_modelid($catid)) return false;
		if(isset($data['where'])) {
			$sql = $data['where'];
		} else {
			$thumb = intval($data['thumb']) ? " AND thumb != ''" : '';
			if($this->category[$catid]['child']) {
				$catids_str = $this->category[$catid]['arrchildid'];
				$pos = strpos($catids_str,',')+1;
				$catids_str = substr($catids_str, $pos);
				$sql = "status=99 AND catid IN ($catids_str)".$thumb;
			} else {
				$sql = "status=99 AND catid='$catid'".$thumb;
			}
			//处理keywords 
			if($keywords!=''){
				if(strpos($keywords,',')){
					$keywords_array = explode(',', $keywords);
					$i = 1;
					foreach ($keywords_array as $key => $value) {
							# code...
							if($i==1){
								$sql .= " AND `keywords` like '%".$value."%'";
							}else{
								$sql .=  " or `keywords` like '%".$value."%'";
							}
							$i++;
						}	
				}else{
					$sql .=  " AND `keywords` like '%".$keywords."%'";
				}
			}
			//处理type 限定 
			if($typeid!=''){
				if(strpos($typeid,',')){
					$type_array = explode(',', $typeid);
					$n = 1; 
					foreach ($type_array as $tk => $tv) {
						# code...
						if($n==1){
							$sql .= " AND `typeid` =".$tv;
						}else{
							$sql .=  " or `typeid` =".$tv;
						}
						$n++;
					}
				}else{
					$sql .=  " AND `typeid`  = ".$typeid;
				}
			}

		}
		$order = $data['order'];

		$return = $this->db->select($sql, '*', $data['limit'], $order, '', 'id');
						
		//调用副表的数据
		if (isset($data['moreinfo']) && intval($data['moreinfo']) == 1) {
			$ids = array();
			foreach ($return as $v) {
				if (isset($v['id']) && !empty($v['id'])) {
					$ids[] = $v['id'];
				} else {
					continue;
				}
			}
			if (!empty($ids)) {
				$this->db->table_name = $this->db->table_name.'_data';
				$ids = implode('\',\'', $ids);
				$r = $this->db->select("`id` IN ('$ids')", '*', '', '', '', 'id');
				if (!empty($r)) {
					foreach ($r as $k=>$v) {
						if (isset($return[$k])) $return[$k] = array_merge($v, $return[$k]);
					}
				}
			}
		}
		return $return;
	}
	
	/**
	 * 相关文章标签
	 * @param $data
	 */
	public function relation($data) {
		$catid = intval($data['catid']);
		$modelid = intval($data['modelid']);
		if(!$this->set_modelid($catid) && $modelid) {
			$this->db->set_model($modelid);
			$this->tablename = $this->db->table_name;
		} elseif(!$this->set_modelid($catid)) {
			return false;
		}
		$order = $data['order'];
		$sql = "`status`=99";
		$limit = $data['id'] ? $data['limit']+1 : $data['limit'];
		if($data['relation']) {
			$relations = explode('|',trim($data['relation'],'|'));
			$relations = array_diff($relations, array(null));
			$relations = implode(',',$relations);
			$sql = " `id` IN ($relations)";
			$key_array = $this->db->select($sql, '*', $limit, $order,'','id');
		} elseif($data['keywords']) {
			$keywords = str_replace(array('%',"'"), '',$data['keywords']);
			$keywords_arr = explode(' ',$keywords);
			$key_array = array();
			$number = 0;
			$i =1;
			$sql .= " AND catid='$catid'";
			foreach ($keywords_arr as $_k) {
				$sql2 = $sql." AND `keywords` LIKE '%$_k%'".(isset($data['id']) && intval($data['id']) ? " AND `id` != '".abs(intval($data['id']))."'" : '');
				$r = $this->db->select($sql2, '*', $limit, '','','id');
				$number += count($r);
				foreach ($r as $id=>$v) {
					if($i<= $data['limit'] && !in_array($id, $key_array)) $key_array[$id] = $v;
					$i++;
				}
				if($data['limit']<$number) break;
			}
		}
		if($data['id']) unset($key_array[$data['id']]);
		return $key_array;
	}
	
	/**
	 * 排行榜标签
	 * @param $data
	 */
	public function hits($data) {
		$catid = intval($data['catid']);
		if(!$this->set_modelid($catid)) return false;

		$this->hits_db = pc_base::load_model('hits_model');
		$sql = $desc = $ids = '';
		$array = $ids_array = array();
		$order = $data['order'];
		$hitsid = 'c-'.$this->modelid.'-%';
		$sql = "hitsid LIKE '$hitsid'";
		if(isset($data['day'])) {
			$updatetime = SYS_TIME-intval($data['day'])*86400;
			$sql .= " AND updatetime>'$updatetime'";
		}
		if($this->category[$catid]['child']) {
			$catids_str = $this->category[$catid]['arrchildid'];
			$pos = strpos($catids_str,',')+1;
			$catids_str = substr($catids_str, $pos);
			$sql .= " AND catid IN ($catids_str)";
		} else {
			$sql .= " AND catid='$catid'";
		}
		$hits = array();
		$result = $this->hits_db->select($sql, '*', $data['limit'], $order);
		foreach ($result as $r) {
			$pos = strpos($r['hitsid'],'-',2) + 1;
			$ids_array[] = $id = substr($r['hitsid'],$pos);
			$hits[$id] = $r;
		}
		$ids = implode(',', $ids_array);
		if($ids) {
			$sql = "status=99 AND id IN ($ids)";
		} else {
			$sql = '';
		}
		$this->db->table_name = $this->tablename;
		$result = $this->db->select($sql, '*', $data['limit'],'','','id');
		foreach ($ids_array as $id) {
			if($result[$id]['title']!='') {
				$array[$id] = $result[$id];
				$array[$id] = array_merge($array[$id], $hits[$id]);
			}
		}
		return $array;
	}
	/**
	 * 栏目标签
	 * @param $data
	 */
	public function category($data) {
		$data['catid'] = intval($data['catid']);
		$array = array();
		$siteid = $data['siteid'] && intval($data['siteid']) ? intval($data['siteid']) : get_siteid();
		$categorys = getcache('category_content_'.$siteid,'commons');
		$site = siteinfo($siteid);
		$i = 1;
		foreach ($categorys as $catid=>$cat) {
			if($i>$data['limit']) break;
			if((!$cat['ismenu']) || $siteid && $cat['siteid']!=$siteid) continue;
			if (strpos($cat['url'], '://') === false) {
				$cat['url'] = substr($site['domain'],0,-1).$cat['url'];
			}
			if($cat['parentid']==$data['catid']) {
				$array[$catid] = $cat;
				$i++;
			}
		}
		return $array;
	}
	
	/**
	 * 推荐位
	 * @param $data
	 */
	public function position($data) {
		$sql = '';
		$array = array();
		$posid = intval($data['posid']);
		$order = $data['order'];
		$thumb = (empty($data['thumb']) || intval($data['thumb']) == 0) ? 0 : 1;
		$siteid = $GLOBALS['siteid'] ? intval($GLOBALS['siteid']) : 1;
		$catid = (empty($data['catid']) || $data['catid'] == 0) ? '' : intval($data['catid']);
		if($catid) {
			$siteids = getcache('category_content','commons');
			if(!$siteids[$catid]) return false;
			$siteid = $siteids[$catid];
			$this->category = getcache('category_content_'.$siteid,'commons');
		}
		if($catid && $this->category[$catid]['child']) {
			$catids_str = $this->category[$catid]['arrchildid'];
			$pos = strpos($catids_str,',')+1;
			$catids_str = substr($catids_str, $pos);
			$sql = "`catid` IN ($catids_str) AND ";
		}  elseif($catid && !$this->category[$catid]['child']) {
				$sql = "`catid` = '$catid' AND ";
		}
		if($thumb) $sql .= "`thumb` = '1' AND ";
		if(isset($data['where'])) $sql .= $data['where'].' AND ';
		if(isset($data['expiration']) && $data['expiration']==1) $sql .= '(`expiration` >= \''.SYS_TIME.'\' OR `expiration` = \'0\' ) AND ';
		$sql .= "`posid` = '$posid' AND `siteid` = '".$siteid."'";
		$pos_arr = $this->position->select($sql, '*', $data['limit'],$order);
		if(!empty($pos_arr)) {
			foreach ($pos_arr as $info) {
				$key = $info['catid'].'-'.$info['id'];
				$array[$key] = string2array($info['data']);
				$array[$key]['url'] = go($info['catid'],$info['id']);
				$array[$key]['id'] = $info['id'];
				$array[$key]['catid'] = $info['catid'];
				$array[$key]['listorder'] = $info['listorder'];
			}
		}
		return $array;
	}
	/**
	 * 可视化标签
	 */
	public function pc_tag() {
		$positionlist = getcache('position','commons');
		$sites = pc_base::load_app_class('sites','admin');
		$sitelist = $sites->pc_tag_list();
		
		foreach ($positionlist as $_v) if($_v['siteid'] == get_siteid() || $_v['siteid'] == 0) $poslist[$_v['posid']] = $_v['name'];
		$type_array =array();
		$type_array = array('53'=>'评测','54'=>'资讯','55'=>'观点','56'=>'专访','57'=>'厂商稿','58'=>'专题');
		$catid_array = array('9'=>'智能穿戴','10'=>'生活健康','11'=>'智能手机','12'=>'出行智玩','22'=>'推荐产品','24'=>'IT业界','16'=>'海外视频鲜知道','17'=>'尝鲜调查团','18'=>'科技碎碎念','19'=>'螃蟹八分熟','21'=>'视频其它');
		return array(
			'action'=>array('lists'=>L('list','', 'content'),'position'=>L('position','', 'content'), 'category'=>L('subcat', '', 'content'), 'relation'=>L('related_articles', '', 'content'), 'hits'=>L('top', '', 'content')),
			'lists'=>array(
				// 'catid'=>array('name'=>L('catid', '', 'content'),'htmltype'=>'input_select_category','data'=>array('type'=>0),'validator'=>array('min'=>1)),
				//增加必须包含关键字限制
				'modelid'=>array('name'=>'模型ID','htmltype'=>'input'),
				'tagid'=>array('name'=>'tag标识','htmltype'=>'input'),
				'grade'=>array('name'=>'评分','htmltype'=>'input'),
				'keywords'=>array('name'=>'关键字','htmltype'=>'input'),
				'typeid'=>array('name'=>'标签','htmltype'=>'checkbox','data'=>$type_array),
				'catid'=>array('name'=>'栏目','htmltype'=>'checkbox','data'=>$catid_array),

				'order'=>array('name'=>L('sort', '', 'content'), 'htmltype'=>'select','data'=>array('id DESC'=>L('id_desc', '', 'content'), 'updatetime DESC'=>L('updatetime_desc', '', 'content'), 'listorder ASC'=>L('listorder_asc', '', 'content'))),
				'thumb'=>array('name'=>L('thumb', '', 'content'), 'htmltype'=>'radio','data'=>array('0'=>L('all_list', '', 'content'), '1'=>L('thumb_list', '', 'content'))),
				'thumbnum'=>array('name'=>"选择缩略图", 'htmltype'=>'radio','data'=>array('1'=>"图1", '2'=>'图2','3'=>"图3")),
				'moreinfo'=>array('name'=>L('moreinfo', '', 'content'), 'htmltype'=>'radio', 'data'=>array('1'=>L('yes'), '0'=>L('no')))
			),
			'position'=>array(
				'posid'=>array('name'=>L('posid', '', 'content'),'htmltype'=>'input_select','data'=>$poslist,'validator'=>array('min'=>1)),
				'catid'=>array('name'=>L('catid', '', 'content'),'htmltype'=>'input_select_category','data'=>array('type'=>0),'validator'=>array('min'=>0)),
				'thumb'=>array('name'=>L('thumb', '', 'content'), 'htmltype'=>'radio','data'=>array('0'=>L('all_list', '', 'content'), '1'=>L('thumb_list', '', 'content'))),			
				'order'=>array('name'=>L('sort', '', 'content'), 'htmltype'=>'select','data'=>array('listorder DESC'=>L('listorder_desc', '', 'content'),'listorder ASC'=>L('listorder_asc', '', 'content'),'id DESC'=>L('id_desc', '', 'content'))),
			),
			'category'=>array(
				'siteid'=>array('name'=>L('siteid'), 'htmltype'=>'input_select', 'data'=>$sitelist),
				'catid'=>array('name'=>L('catid', '', 'content'), 'htmltype'=>'input_select_category', 'data'=>array('type'=>0))
			),
			'relation'=>array(
				'catid'=>array('name'=>L('catid', '', 'content'), 'htmltype'=>'input_select_category', 'data'=>array('type'=>0), 'validator'=>array('min'=>1)),
				'order'=>array('name'=>L('sort', '', 'content'), 'htmltype'=>'select','data'=>array('id DESC'=>L('id_desc', '', 'content'), 'updatetime DESC'=>L('updatetime_desc', '', 'content'), 'listorder ASC'=>L('listorder_asc', '', 'content'))),
				'relation'=>array('name'=>L('relevant_articles_id', '', 'content'), 'htmltype'=>'input'),
				'keywords'=>array('name'=>L('key_word', '', 'content'), 'htmltype'=>'input')
			),
			'hits'=>array(
				'catid'=>array('name'=>L('catid', '', 'content'), 'htmltype'=>'input_select_category', 'data'=>array('type'=>0), 'validator'=>array('min'=>1)),
				'day'=>array('name'=>L('day_select', '', 'content'), 'htmltype'=>'input', 'data'=>array('type'=>0)),
			),
				
		);
	}
}