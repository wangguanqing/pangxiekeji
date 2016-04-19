<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template("wap","header"); ?>
<link rel="stylesheet" href="<?php echo CSS_PATH;?>v4/wap/show.css">

		<div class="main">
			<div class="main-con">
                <h1><?php echo $title;?></h1> 
                <span class="autor"><?php echo $inputtime;?></span>
                <div class="arc-con">
                    <?php echo $content;?>
                </div>
                <div class="keywrod"><span>关键词: </span> 
                     <?php $n=1;if(is_array($keywords)) foreach($keywords AS $keyword) { ?>
                            <?php if(trim($keyword)!='') { ?>
                        <a href="<?php echo APP_PATH;?>index.php?m=content&c=tag&a=lists&tag=<?php echo urlencode($keyword);?>"><?php echo $keyword;?>
                            <?php } ?> 
                    <?php $n++;}unset($n); ?> 
                </div>
                <div class="share"> 

                </div>      
            </div>
            <div class="comment">
                <h2>网友评论</h2>
                <div class="ds-thread" data-thread-key="content-news-<?php echo $id;?>" data-title="<?php echo $title;?>" data-url="<?php echo $url;?>"></div>

                <script type="text/javascript">
                    var duoshuoQuery = {short_name:"pangxiekeji"};
                    (function() {
                        var ds = document.createElement('script');
                        ds.type = 'text/javascript';ds.async = true;
                        ds.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') + '//static.duoshuo.com/embed.js';
                        ds.charset = 'UTF-8';
                        (document.getElementsByTagName('head')[0]
                                || document.getElementsByTagName('body')[0]).appendChild(ds);
                    })();
                </script>
            </div>
		</div>

<!-- footer -->
<?php include template("wap","footer"); ?>
		