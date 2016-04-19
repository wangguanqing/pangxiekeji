<?php
// defined('IN_PHPCMS') or exit('No permission resources.'); 

/**
*  【游戏宝】 - 精选定时任务脚本 
*/ 

define('PHPCMS_PATH', substr(dirname(__FILE__),0,-12).DIRECTORY_SEPARATOR);
include PHPCMS_PATH.'phpcms/base.php'; 
$param = pc_base::load_sys_class('param');
ob_start(); 
$pangxie_db = pc_base::load_model('pangxie_model'); //老数据库
$content_db = pc_base::load_model('content_model'); 

//查出来数据
$page = 1;
$pagesize= 10;
$start = 0;

while($start>=0){
	$return_array = array();
	$return_array = $pangxie_db->listinfo('','id asc',$page,$pagesize);
	if(!empty($return_array)){
		foreach ($return_array as $key => $array) {
			//数据不为空，插入现有的视频表中
			$in_array = array();
			$in_array['title'] = str_cut($array['title'],70);
			$in_array['short_title'] = $array['short'];//短标题
			$in_array['keywords'] = str_cut($array['keywords'],30);
			$in_array['description'] = str_cut($array['description'],230);
			$in_array['thumb'] = "http://www.pangxiekeji.com".$array['image'];
			$in_array['content'] = $array['content'];
			$in_array['video_time'] = $array['duration'];//视频时长
			$in_array['play_url'] = $array['play_url'];//播放地址
			$in_array['inputtime'] = $array['create_time'];//发布时间
			$in_array['updatetime'] = $array['update_time'];//更新时间
			//算出platform platform_vid 
			$url_array = parse_url($array['play_url']);
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
			$in_array['catid'] = 21;
			$in_array['status'] = 99;
			$content_db->set_model(11);
			$id = $content_db->add_content($in_array,$isimport = 0);
		}
		echo "导完第".$page."页";
		$page = $page+1;
        $start = 0;

	}else{
		//结果为空，说明查询已经到最后
        echo '视频导入结束！！！';
        $start = -1;
        exit();
	}

}


 

?>










