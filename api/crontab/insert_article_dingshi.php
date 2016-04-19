<?php

/**
*   处理插入的文章，定时文章状态
*   王官庆 3.8
*   v9_add_article 表
*/ 

define('PHPCMS_PATH', substr(dirname(__FILE__),0,-12).DIRECTORY_SEPARATOR);
include PHPCMS_PATH.'phpcms/base.php'; 
$param = pc_base::load_sys_class('param');
ob_start(); 
$add_article_db = pc_base::load_model('add_article_model'); //老数据库
$content_db = pc_base::load_model('content_model'); 

//查出来数据
$page = 1;
$pagesize= 20;
$start = 0;

while($start>=0){
	$return_array = array();
	// $sql = " status!=99";
	$sql = "";
	$return_array = $add_article_db->listinfo($sql,'id desc',$page,$pagesize);
	if(!empty($return_array)){
		foreach ($return_array as $key => $array) {
			//对所有插入的文章进行状态更新，正常的看是否要下线，不正常的看是否要上线
			if($array['status']==99){
				//结束时间小于现在时间，下线
				if($array['endtime']< SYS_TIME){
					$add_article_db->update(array("status"=>1),array("id"=>$array['id']));
				}
			}else{
				if( ($array['starttime']< SYS_TIME) && ($array['endtime']>SYS_TIME)){ //定时时间小于当前时间，可以开放了 
					$add_article_db->update(array("status"=>99),array("id"=>$array['id']));
				}
			}

		}
		$page = $page+1;
        $start = 0;

	}else{
		//结果为空，说明查询已经到最后
        echo '人工插入文章，上下线操作更新成功！！！';
        $start = -1;
        exit();
	}

}


 

?>










