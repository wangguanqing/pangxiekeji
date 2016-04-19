<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<title>{if isset($SEO['title']) && !empty($SEO['title'])}{$SEO['title']}{/if}{$SEO['site_title']}</title>
<meta name="keywords" content="{$SEO['keyword']}">
<meta name="description" content="{$SEO['description']}">
<link href="{$CSS_PATH}reset.css" rel="stylesheet" type="text/css" />
<link href="{$CSS_PATH}default_blue.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{$JS_PATH}jquery.min.js"></script>
<script type="text/javascript" src="{$JS_PATH}jquery.sgallery.js"></script>
<script type="text/javascript" src="{$JS_PATH}search_common.js"></script>
</head>
<body>
<div class="body-top">
    <div class="content"> 
<script type="text/javascript">
$(function(){
	startmarquee('announ',22,1,500,3000);
})
</script>
           
    </div>
</div>
<div class="header">
	<div class="logo"><a href="{siteurl($siteid)}/"><img src="{$IMG_PATH}v9/logo.jpg" /></a></div>

    <div class="search">
    	<div class="tab" id="search">
			 
		</div>

        <div class="bd">
            <form action="{$APP_PATH}index.php" method="get" target="_blank">
				<input type="hidden" name="m" value="search"/>
				<input type="hidden" name="c" value="index"/>
				<input type="hidden" name="a" value="init"/>
				<input type="hidden" name="typeid" value="{$typeid}" id="typeid"/>
				<input type="hidden" name="siteid" value="{$siteid}" id="siteid"/>
                <input type="text" class="text" name="q" id="q"/><input type="submit" value="搜 索" class="button" />
            </form>
        </div>
    </div>

    <div class="banner"><script language="javascript" src="{$APP_PATH}index.php?m=poster&c=index&a=show_poster&id=1"></script></div>
    <div class="bk3"></div>
    <div class="nav-bar">
    	<map>
    	{pc M=content action="category" catid="0" num="25" siteid="$siteid" order="listorder ASC"}
        	<ul class="nav-site">
			<li><a href="{siteurl($siteid)}"><span>首页</span></a></li>
            {foreach from=$data item=r}
			<li class="line">|</li>
			<li><a href="{$r[url]}"><span>{$r[catname]}</span></a></li>
			{/foreach}
            </ul>
        {/pc}
		{runhook('glogal_menu')}
        </map>
    </div> 
	 
</div>
</div>