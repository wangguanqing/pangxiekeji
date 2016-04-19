<?php

/**
*   定时文章发布，5分钟更新一次文章的状态
*   王官庆 3.4 
*   v9_dingshi 表
*/ 

define('PHPCMS_PATH', substr(dirname(__FILE__),0,-12).DIRECTORY_SEPARATOR);
include PHPCMS_PATH.'phpcms/base.php'; 
$param = pc_base::load_sys_class('param');
ob_start(); 
$dingshi_db = pc_base::load_model('dingshi_model'); //老数据库
$content_db = pc_base::load_model('content_model'); 

//查出来数据
$page = 1;
$pagesize= 20;
$start = 0;

while($start>=0){
	$return_array = array();
	$sql = " status!=99";
	$return_array = $dingshi_db->listinfo($sql,'id desc',$page,$pagesize);
	if(!empty($return_array)){
		foreach ($return_array as $key => $array) {
			//到时间开启文章的status值为99 
			//取文章真实的发布时间
			$content_db->set_model($array['modelid']);
			$art_array = $content_db->get_one(array("id"=>$array['contentid']));

			if($art_array['inputtime']< SYS_TIME){ //定时时间小于当前时间，可以开放了 
				$content_db->update(array("status"=>99),array("id"=>$array['contentid']));
				$dingshi_db->update(array("status"=>99),array("id"=>$array['id']));
			}

		}
		$page = $page+1;
        $start = 0;

	}else{
		//结果为空，说明查询已经到最后
        echo '定时发布更新成功！！！';
        $start = -1;
        exit();
	}

}


 

?>










