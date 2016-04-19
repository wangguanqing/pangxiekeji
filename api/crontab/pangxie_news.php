<?php
// defined('IN_PHPCMS') or exit('No permission resources.'); 

/**
*  【游戏宝】 - 精选定时任务脚本 
*/ 

define('PHPCMS_PATH', substr(dirname(__FILE__),0,-12).DIRECTORY_SEPARATOR);
include PHPCMS_PATH.'phpcms/base.php'; 
$param = pc_base::load_sys_class('param');
ob_start(); 
$pangxie_db = pc_base::load_model('pangxie_news_model'); //老数据库
$content_db = pc_base::load_model('content_model'); 

//查出来数据
$page = 1;
$pagesize= 20;
$start = 0;

$cat_array = array("1"=>9,"2"=>10,"3"=>11,"4"=>12,"5"=>10,"6"=>12);

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
			$in_array['inputtime'] = $array['create_time'];//发布时间
			$in_array['updatetime'] = $array['update_time'];//更新时间
			//对应的CATID 
			$cid = $array['cid'];
			$in_array['catid'] = $cat_array[$cid];
			$in_array['status'] = 99;
			$content_db->set_model(1);
			$id = $content_db->add_content($in_array,$isimport = 0);
		}
		// echo "导完第".$page."页";
		$page = $page+1;
        $start = 0;

	}else{
		//结果为空，说明查询已经到最后
        echo '文章导入结束！！！';
        $start = -1;
        exit();
	}

}


 

?>










