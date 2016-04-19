<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template("content","header"); ?>    
<link rel="stylesheet" href="<?php echo CSS_PATH;?>v4/show.css">
<script type="text/javascript" src="<?php echo JS_PATH;?>v4/show_video.js"></script>

        <!-- 头部结束 -->
        <!-- con开始 -->
        <div class="con-out">
            <div class="video-con">
                <div class="w-780">
                    <!-- 这里是视频代码 -->
                    <?php if($platform=='qq') { ?>
                        <iframe frameborder="0" width="780" height="456" src="http://v.qq.com/iframe/player.html?vid=<?php echo $platform_vid;?>&tiny=1&auto=0" allowfullscreen></iframe>
                    <?php } elseif ($platform=='letv') { ?>
                    <object width="780" height="456"><param name="allowFullScreen" value="true"><param name="flashVars" value="id=<?php echo $platform_vid;?> " /><param name="movie" value="http://i7.imgs.letv.com/player/swfPlayer.swf?autoplay=0" /><embed src="http://i7.imgs.letv.com/player/swfPlayer.swf?autoplay=0" flashVars="id=<?php echo $platform_vid;?>" width="780" height="456" allowFullScreen="true" type="application/x-shockwave-flash" ></embed></object>

                    <?php } elseif ($platform=='youku') { ?>
                        <iframe frameborder="0" width="780" height="456" src="http://player.youku.com/embed/<?php echo $platform_vid;?>" allowfullscreen></iframe>
                    <?php } elseif ($platform=='tudou') { ?>
                        <iframe src="http://www.tudou.com/programs/view/html5embed.action?typpe=0&code=<?php echo $platform_vid;?>&lcode=&resourceId=0_06_05_99" allowtransparency="true" allowfullscreen="truue" allowfullscreenInteractive="true" scrolling="no" border="0" frameborder="0" width="780" height="456"></iframe>
                    <?php } ?>
                    

                </div>
            </div>
            <div class="show-con show-video-con clearfix">
                <div class="w-780">
                    <h1><?php echo $title;?></h1>
                    <h3 class="dec"><?php echo get_admin_name($username);?> <s></s> <?php echo $inputtime;?> <s></s> 原创</h3>
                    <div class="show-con-con">
                        
                        <div class="show-content J_content"><?php echo $content;?></div>
                        <a href="javascript:;" class="open J_open">展开详情 <span></span></a>
                    </div>
                    <div class="keyword"> 

                        <?php $n=1;if(is_array($keywords)) foreach($keywords AS $keyword) { ?>
                            <?php if(trim($keyword)!='') { ?>
                        <a href="<?php echo APP_PATH;?>index.php?m=content&c=tag&a=lists&tag=<?php echo urlencode($keyword);?>"><?php echo $keyword;?>
                            <?php } ?>
                        </a>    
                        <?php $n++;}unset($n); ?> 

                    </div>
                    <div class="share">
                         <!-- 分享占位 -->
<!-- JiaThis Button BEGIN  -->
<div class="jiathis_style_32x32">
    <a class="jiathis_button_qzone"></a>
    <a class="jiathis_button_tsina"></a>
    <a class="jiathis_button_tqq"></a>
    <a class="jiathis_button_weixin"></a>
    <a class="jiathis_button_renren"></a>
    <a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank"></a>
    <a class="jiathis_counter_style"></a>
</div>
<script type="text/javascript" src="http://v3.jiathis.com/code/jia.js" charset="utf-8"></script>
<!-- JiaThis Button END -->
                    </div>
                </div>
            </div>
            <div class="related">
                <div class="w-780">
                    <h2>热门视频</h2>
                    <div class="related-list clearfix">
                        <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=164de6b586eae96f899a881cc45db035&action=lists&catid=%24catid&modelid=11&order=id+DESC&thumb=1&num=8\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('catid'=>$catid,'modelid'=>'11','order'=>'id DESC','thumb'=>'1','limit'=>'8',));}?>
                            <?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
                                <dl>
                                <dt><a href="<?php echo $r['url'];?>"><img src="<?php echo $r['thumb'];?>" alt="<?php echo $r['title'];?>"><span>4.20</span></a></dt>
                                <dd><a href="<?php echo $r['url'];?>"><?php echo $r['title'];?></a></dd>
                                </dl>   
                            <?php $n++;}unset($n); ?>
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?> 
                        
                    </div>
                </div>
            </div>
            <div class="comment">
                <div class="w-780">
                    <h2>评论</h2>
                    <div class="comment-con">
 <!-- 评论列表占位 -->
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
            </div>
        </div>
        <!-- con结束 -->

        <!-- 底部开始 -->
<?php include template("content","footer"); ?>    
       