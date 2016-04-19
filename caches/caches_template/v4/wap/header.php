<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta name="format-detection" content="telephone=no" />
    <title><?php if(isset($SEO['title']) && !empty($SEO['title'])) { ?><?php echo $SEO['title'];?><?php } ?><?php echo $SEO['site_title'];?></title>
    <meta name="keywords" content="<?php echo $SEO['keyword'];?>">
    <meta name="description" content="<?php echo $SEO['description'];?>"> 
    <script type="text/javascript" src="<?php echo JS_PATH;?>v4/jquery-1.9.1.min.js"></script>
    <link rel="stylesheet" href="<?php echo CSS_PATH;?>v4/wap/common.css">
</head>
<script>
    adaptation(750);
    //适配
    function adaptation(size){
        if(document.documentElement.clientWidth>size){
            document.documentElement.style.fontSize=size/26.66666666+'px';
        }else{
            document.documentElement.style.fontSize=document.documentElement.clientWidth/26.66666666+'px';
        }
    }
</script>
<body>
	<div class="wrapper">
		<!-- header -->
		<div class="header">
			<div class="h-logo">
				<img src="<?php echo IMG_PATH;?>logo.png">
			</div>
			<ul class="h-nav">
				<li <?php if(!$_GET['typdid'] && !$_GET['modelid']) { ?>class="active"<?php } ?>><a href="<?php echo APP_PATH;?>">首页</a></li>
				<li <?php if($_GET['typdid']==54) { ?>class="active"<?php } ?>><a href="<?php echo APP_PATH;?>news">快讯</a></li>
				<li <?php if($_GET['modelid']==11) { ?>class="active"<?php } ?>><a href="<?php echo APP_PATH;?>v/">视频</a></li>
				<li <?php if($_GET['typdid']==53) { ?>class="active"<?php } ?>><a href="<?php echo APP_PATH;?>ce/">评测</a></li>
			</ul>
		</div>
		<!-- header -->  