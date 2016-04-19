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
<link rel="stylesheet" href="<?php echo CSS_PATH;?>v4/reset.css">
<link rel="stylesheet" href="<?php echo CSS_PATH;?>v4/common.css">

</head>

<body>
	<div class="page">
        <!-- 头部开始 -->
        <div class="header">
            <div class="w-1170 clearfix">
                <a href="<?php echo APP_PATH;?>" class="logo"></a>
                <dl class="info">
                    <dt><a href="mailto:tougao@pangxiekeji.com">投稿</a></dt>
                    <dd><a href="http://weibo.com/p/1006065606718419" target="_blank" class="weibo-icon">微博</a></dd>
                    <dd><a href="#" class="weixin-icon">微信</a></dd>
                </dl>
            </div>
            <div class="nav">
            <div class="w-1170 clearfix">
                <ul class="nav-list clearfix">
                    <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=b43f1459ac702900c8d44c91a5e796dd&action=category&catid=0&num=25&siteid=%24siteid&order=listorder+ASC\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'category')) {$data = $content_tag->category(array('catid'=>'0','siteid'=>$siteid,'order'=>'listorder ASC','limit'=>'25',));}?>
                        <li><a href="<?php echo APP_PATH;?>" <?php if($catid==0) { ?>class="index-active"<?php } ?>><s class="index-con"></s></a></li>
                        <?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
                            <?php if($r['catid']==13 or $r['catid']==14) { ?>
                                <li><a href="<?php echo $r['url'];?>" <?php if($catid==$r['catid']) { ?>class="index-active"<?php } ?>><?php echo $r['catname'];?>  <s class="hot-icon" style="z-index: 999;">hot</s></a></li>
                            <?php } else { ?>
                                <li><a href="<?php echo $r['url'];?>" <?php if($catid==$r['catid']) { ?>class="index-active"<?php } ?>><?php echo $r['catname'];?></a></li>
                            <?php } ?>
                        <?php $n++;}unset($n); ?>
                    <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?> 
                </ul>
                <form action="<?php echo APP_PATH;?>index.php?m=content&c=tag&a=lists"  method="GET" class="search">
                    <input type="hidden" name="m" value="content"/> 
                    <input type="hidden" name="c" value="tag"/> 
                    <input type="hidden" name="a" value="lists"/> 
                    <input type="text" name="tag" id="tag" class="keyword" style="margin-top: 0px;">
                    <input type="submit" class="search-icon">
                </form>
            </div>
        </div>
        </div>
<!-- 头部结束 -->