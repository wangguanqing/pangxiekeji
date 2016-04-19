<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template("content","header"); ?>
<link rel="stylesheet" href="<?php echo CSS_PATH;?>v4/show.css">

<script type="text/javascript" src="<?php echo JS_PATH;?>v4/common.js"></script> 
        <!-- con开始 -->
        <div class="con-out">
            <div class="show-con show-pingce">
                <div class="w-780">
                    <div class="show-title" style="background:#8c8585 url(<?php echo $thumb;?>) no-repeat center center;width:778px;height:517px;">
                        <div class="info-pos">
                            <h1><?php echo $title;?></h1>
                            <h3 class="dec"><?php echo get_admin_name($username);?>  <s></s> <?php echo $inputtime;?> <s></s> 原创</h3>
                        </div>
                    </div>
                    <div class="show-con-con">
                        <?php echo $content;?>
                    </div>
                    <div class="keyword">
                    <?php $n=1;if(is_array($keywords)) foreach($keywords AS $keyword) { ?>
                        <a href="<?php echo APP_PATH;?>index.php?m=content&c=tag&a=lists&tag=<?php echo urlencode($keyword);?>"><?php echo $keyword;?>
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
            <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=59d3146c936b0bbb61d83c4d89437c20&action=relation&relation=%24relation&id=%24id&catid=%24catid&num=5&keywords=%24rs%5Bkeywords%5D\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'relation')) {$data = $content_tag->relation(array('relation'=>$relation,'id'=>$id,'catid'=>$catid,'keywords'=>$rs[keywords],'limit'=>'5',));}?>
            <?php if($data) { ?>
            <div class="related">
                <div class="w-780">
                    <h2>相关资讯</h2>
                    <div class="related-list clearfix">
                        
                                <?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
                                    <dl>
                                        <dt><a href="<?php echo $r['url'];?>"><img src="<?php echo $r['thumb'];?>" alt=""></a></dt>
                                        <dd><a href="<?php echo $r['url'];?>"><?php echo $r['title'];?></a></dd>
                                    </dl>
                                <?php $n++;}unset($n); ?>
                            
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?> 
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
