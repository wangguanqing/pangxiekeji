<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template("content","header"); ?>
<link rel="stylesheet" href="<?php echo CSS_PATH;?>v4/recommend.css">
<script type="text/javascript" src="../statics/js/swiper.min.js"></script>
<script type="text/javascript" src="../statics/js/recommend.js"></script>        

        <!-- 头部结束 -->
        <!-- con开始 -->
        <div class="con-out">
            <div class="rec-con">
                <div class="rec-hot bg-fff">
                  <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=2c86b1f50262cd5b6f8782a74711e98d&action=lists&modelid=12&tagid=list_boakuan_1&grade=5&catid=22&order=id+DESC&thumb=1&num=1\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('modelid'=>'12','tagid'=>'list_boakuan_1','grade'=>'5','catid'=>'22','order'=>'id DESC','thumb'=>'1','limit'=>'1',));}?>
                            <?php $n=1;if(is_array($data)) foreach($data AS $r) { ?> 
                            
                    <div class="w-1170 clearfix">
                        <div class="rec-l l">
                            <div class="rec-hot-slide">
                                <div class="slide">
                                    <img src="<?php echo $r['thumb'];?>">
                                </div>
                            </div>
                            <dl>
                                <dt><?php echo $title;?></dt>
                                <dd><?php echo str_cut($r['description'],160);?></dd>
                                <dd class="link"><a href="<?php echo $r['url'];?>">阅读更多</a></dd>
                            </dl>
                        </div>
                        <div class="rec-r r">
                           <h2><p><span>今</span><span>日</span><span>爆</span><span>款</span></p></h2> 
                           <dl>
                               <dt><?php echo $short_title;?></dt>
                               <dd><a href="<?php echo $r['url'];?>"><span class="price">￥<?php echo $r['price'];?></span><span>立即购买>></span></a></dd>
                           </dl>
                           <div class="rec-hot-video">
                                                    <!-- 这里是视频代码 -->
                    <?php if($r['platform']=='qq') { ?>
                        <iframe frameborder="0" width="534" height="300" src="http://v.qq.com/iframe/player.html?vid=<?php echo $r['platform_vid'];?>&tiny=1&auto=0" allowfullscreen></iframe>
                    <?php } elseif ($r['platform']=='letv') { ?>
                    <object width="534" height="300"><param name="allowFullScreen" value="true"><param name="flashVars" value="id=<?php echo $r['platform_vid'];?> " /><param name="movie" value="http://i7.imgs.letv.com/player/swfPlayer.swf?autoplay=0" /><embed src="http://i7.imgs.letv.com/player/swfPlayer.swf?autoplay=0" flashVars="id=<?php echo $r['platform_vid'];?>" width="780" height="430" allowFullScreen="true" type="application/x-shockwave-flash" ></embed></object>

                    <?php } elseif ($r['platform']=='youku') { ?>
                        <iframe frameborder="0" width="534" height="300" src="http://player.youku.com/embed/<?php echo $r['platform_vid'];?>" allowfullscreen></iframe>
                    <?php } elseif ($r['platform']=='tudou') { ?>
                        <iframe src="http://www.tudou.com/programs/view/html5embed.action?typpe=0&code=<?php echo $r['platform_vid'];?>&lcode=&resourceId=0_06_05_99" allowtransparency="true" allowfullscreen="truue" allowfullscreenInteractive="true" scrolling="no" border="0" frameborder="0" width="534" height="300"></iframe>
                    <?php } ?>
                           </div>
                        </div> 
                    </div>

                    <?php $n++;}unset($n); ?>
                  <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>






                </div>
                <div class="rec-list bg-f4f4f4">
                    <div class="w-962">
                        <div class="rec-line-icon"></div>
                        <h2>往期推荐</h2>
                        <div class="rec-list-con clearfix">
                            <div class="rec-list-line">
                            </div>

                            <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=c83abf42b041a561bb01dd1641353734&action=lists&catid=22&modelid=12&order=id+DESC&thumb=1&num=4\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('catid'=>'22','modelid'=>'12','order'=>'id DESC','thumb'=>'1','limit'=>'4',));}?>
                            <?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
                                <div class="<?php if($n%2==0) { ?>rec-list-odd<?php } else { ?>rec-list-even<?php } ?> clearfix">
                                   <dl class="rec-list-text">
                                       <dt><img src="<?php echo $r['thumb'];?>" alt=""></dt>
                                       <dd class="title"><?php echo $r['title'];?></dd>
                                       <dd class="info"><?php echo $r['description'];?></dd>
                                       <dd class="link"><a href="<?php echo $r['url'];?>">阅读更多</a></dd>
                                   </dl>
                                   <dl class="rec-list-video">
                                       <dt><?php echo $r['short_title'];?></dt>
                                       <dd class="rec-list-video-con">
                                        
                                        <!-- 这里是视频代码 -->
                    <?php if($r['platform']=='qq') { ?>
                        <iframe frameborder="0" width="450" height="260" src="http://v.qq.com/iframe/player.html?vid=<?php echo $r['platform_vid'];?>&tiny=1&auto=0" allowfullscreen></iframe>
                    <?php } elseif ($r['platform']=='letv') { ?>
                    <object width="780" height="430"><param name="allowFullScreen" value="true"><param name="flashVars" value="id=<?php echo $r['platform_vid'];?> " /><param name="movie" value="http://i7.imgs.letv.com/player/swfPlayer.swf?autoplay=0" /><embed src="http://i7.imgs.letv.com/player/swfPlayer.swf?autoplay=0" flashVars="id=<?php echo $r['platform_vid'];?>" width="780" height="430" allowFullScreen="true" type="application/x-shockwave-flash" ></embed></object>

                    <?php } elseif ($r['platform']=='youku') { ?>
                        <iframe frameborder="0" width="780" height="430" src="http://player.youku.com/embed/<?php echo $r['platform_vid'];?>" allowfullscreen></iframe>
                    <?php } elseif ($r['platform']=='tudou') { ?>
                        <iframe src="http://www.tudou.com/programs/view/html5embed.action?typpe=0&code=<?php echo $r['platform_vid'];?>&lcode=&resourceId=0_06_05_99" allowtransparency="true" allowfullscreen="truue" allowfullscreenInteractive="true" scrolling="no" border="0" frameborder="0" width="780" height="430"></iframe>
                    <?php } ?>

                                       </dd>
                                       <dd class="info"><a href="<?php echo $r['url'];?>"><span class="price">￥<?php echo $r['price'];?></span><span>立即购买>></span></a></dd>
                                   </dl>
                                   <div class="circular"></div>
                                </div>
                            <?php $n++;}unset($n); ?>
                            <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>

                            
                        </div>
                        <a href="javascript:;" class="more">查看更多</a>
                    </div>
                </div>
            </div>

        </div>
        <!-- con结束 -->
<?php include template("content","footer"); ?>
