<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>v4/wap/wap_flow.css">
      <meta http-equiv="Cache-Control" content="max-age=900">
        <link type="text/css" rel="stylesheet" href="<?php echo CSS_PATH;?>v4/wap/TTDefaultCSS.css">
        <meta charset="utf-8">
        <meta content="initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0" name="viewport">
        <meta content="telephone=no" name="format-detection">
        <meta name="filetype" content="0">
        <meta name="publishedtype" content="1">
        <meta name="pagetype" content="1">
        <meta name="catalogs" content="toutiao_1138561">
        <title><?php echo $title;?></title>
    <style>html{_background-image:url(about:blank);_background-attachment:fixed}</style>
</head>
    <body youdao="bind">
    <div id="TouTiaoBar" style="background:#fff">
        <a class="logo" id="logo" href="http://www.pangxiekeji.com/">
            <img onerror="TouTiao.hideBar()" src="http://pic0.mofang.com/2015/1209/20151209022505165.png">
        </a>
    </div>
    <header>
      <h1><?php echo $title;?></h1>
      <div class="subtitle">
      <a id="source" href="http://www.pangxiekeji.com/">螃蟹科技</a>  
       <time><?php echo $inputtime;?></time>
      </div>
    </header>
    <article>
         
         <?php echo $content;?>

    </article>
    <div style="display: none"> 
    <!-- End 统计 Javascript -->  
    </div>
    <script src="<?php echo JS_PATH;?>v4/TTDefaultJS.js"></script> 

</body>
</html>






