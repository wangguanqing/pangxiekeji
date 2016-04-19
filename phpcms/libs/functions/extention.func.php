<?php


//获取指定栏目的URL 
function get_catid_url($catid){
	$catid = intval($catid);
	$category_arr = getcache('category_content_1','commons');
	$CAT = $category_arr[$catid];
	if($CAT && !empty($CAT)){
		return $CAT['url'];
	}else{
		return '';		
	}
}








/**
 *  extention.func.php 用户自定义函数库
 *
 * @copyright			(C) 2005-2010 PHPCMS
 * @license				http://www.phpcms.cn/license/
 * @lastmodify			2010-10-27
 */

/**
 * 返回经addslashes处理过的字符串或数组
 * @param $string 需要处理的字符串或数组
 * @return mixed
 */
function get_admin_name($username){
	$admin_db = pc_base::load_model('admin_model');
	$memberinfo = $admin_db->get_one(array('username'=>$username));
	if($memberinfo){
		return $memberinfo['realname'];
	}else{
		return '螃蟹科技2';
	}
}


/**
 * 返回经addslashes处理过的字符串或数组
 * @param $string 需要处理的字符串或数组
 * @return mixed
 */
function get_typename($typeid){
	$type_db = pc_base::load_model('type_model');
	$type_array = $type_db->get_one(array('typeid'=>$typeid));
	if($type_array){
		return $type_array['name'];
	}
}


/**
 * 文章发布写入定时发布表中，定时脚本专门跑这个表（不用跑news表全表时间）
 * @param $modelid 数据模型
 * @param $id 文章ID
 * @param $inputtime 定时的时间
 * @return mixed
 */
function insert_dingshi($modelid,$catid,$id,$inputtime){
	$modelid = intval($modelid);
	$id = intval($id);
	$inputtime = intval($inputtime);
	$array = array();
	$array['contentid'] = $id;
	$array['modelid'] = $modelid;
	$array['catid'] = $catid;
	$array['inputtime'] = $inputtime;
	$array['status'] = 1;

	$dingshi_db = pc_base::load_model('dingshi_model');
	$dingshi_db->insert($array); 
}

/**
 * 返回经addslashes处理过的字符串或数组
 * @param $string 需要处理的字符串或数组
 * @return mixed
 */
function get_videoinfo_by_playurl($play_url){
	$play_url = trim($play_url);
	if($play_url==''){
		return array();exit;
	}
	$url_array = parse_url($play_url);
	if(strpos($url_array['host'],'letv')){
		$in_array['platform'] = 'letv';
		$arr = explode("/", $url_array['path']);
		$num_arr = count($arr);
		$num = $num_arr-1;
		$in_array['platform_vid'] = str_ireplace(".html",'',$arr[$num]);
	}
	if(strpos($url_array['host'],'qq')){
		$in_array['platform'] = 'qq';
		$arr = explode("/", $url_array['path']);
		$num_arr = count($arr);
		$num = $num_arr-1;
		$in_array['platform_vid'] = str_ireplace(".html",'',$arr[$num]);
	}
	if(strpos($url_array['host'],'youku')){
		$in_array['platform'] = 'youku';
		$arr = explode("/", $url_array['path']);
		$num_arr = count($arr);
		$num = $num_arr-1;
		$vid = str_ireplace(".html",'',$arr[$num]);
		$vid = str_ireplace("id_",'',$vid);
		$in_array['platform_vid'] = $vid;
	}
	if(strpos($url_array['host'],'tudou')){
		$in_array['platform'] = 'tudou';
		$arr = explode("/", $url_array['path']);
		$num_arr = count($arr);
		$num = $num_arr-2;
		$in_array['platform_vid'] = $arr[$num];
	} 
	return $in_array;
}


/**
 * 判断用户访问是否使用移动设备
 * date： 2014-01-04
 */
function isMobile(){ 
    require_once(dirname(__FILE__) . '/../../mobiledetect/Mobile_Detect.php');
    $detect = new Mobile_Detect;
    return $detect->isMobile();
}




 
?>