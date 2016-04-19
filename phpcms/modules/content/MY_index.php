<?php 
defined('IN_PHPCMS') or exit('No permission resources.');
class MY_index extends index {
	public function __construct() { 
		parent :: __construct();
	} 

	public function smarty(){
		//需求：去掉[url][/url]之间内容
		// $content = "今天是2013年01月02号[url=http:/./tech.42xiu.com]复制链接[/url]是新年的第二天。";
		// echo preg_replace("/\[url.*\[\/url\]/", "", $content); //结果：今天是2013年01月02号是新年的第二天。
		// exit();
// 		<!-- {$i=33} 
// {if $i==33}
// {$i+1}
// {/if}
// {foreach from=$seo item=foo}
// <li>{$foo}</li><br>
// {/foreach}  -->
        require(PC_PATH."init/smarty.php");
		$smarty = use_v4();
		$SEO['title'] = '这是标题';
		$SEO['description'] = '简介';
		$SEO['content'] = '这是内容';
		$smarty->assign('seo',$SEO);
		$smarty->assign($SEO);
		$smarty->assign('name','wangguanqing');
		$smarty->display('content/show.tpl');
	}
}
?>
