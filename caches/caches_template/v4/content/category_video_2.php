<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template("content","header"); ?>     

<!-- <link rel="stylesheet" href="<?php echo CSS_PATH;?>v4/swiper.min.css"> -->
<!-- <script type="text/javascript" src="<?php echo JS_PATH;?>v4/swiper.min.js"></script> -->

<link rel="stylesheet" href="<?php echo CSS_PATH;?>v4/index_video.css">
<script type="text/javascript" src="<?php echo JS_PATH;?>v4/jquery.foucs.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>v4/index_video.js"></script> 
 


        <!-- 头部结束 -->
        <!-- con开始 -->
        <div class="con-out">
            <!-- slide开始 -->
            <div class="slide" id="indexSlide"> 
                <div id="index_b_hero">
                    <div class="hero-wrap">
                        <ul class="heros clearfix"> 
                            <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=fff41558183d28a682ef128bb5944e44&action=lists&modelid=11&tagid=category_video_1&typeid=53%2C54&catid=16%2C17%2C18%2C19%2C21&order=id+DESC&thumb=1&thumbnum=1&num=10\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('modelid'=>'11','tagid'=>'category_video_1','typeid'=>'53,54','catid'=>'16,17,18,19,21','order'=>'id DESC','thumb'=>'1','thumbnum'=>'1','limit'=>'10',));}?>
                            <?php $n=1;if(is_array($data)) foreach($data AS $r) { ?> 
                                <li class="hero">
                                    <a href="<?php echo $r['url'];?>" target="_blank">
                                        <div class="bg-gra"></div>
                                        <img src="<?php echo $r['thumb'];?>" class="thumb"  />
                                         <span class="title"><?php echo $r['title'];?></span>
                                    </a>
                                </li> 
                            <?php $n++;}unset($n); ?>
                            <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?> 

                        </ul>
                    </div>
                </div>
                <div class="helper">
                    <a href="javascript:;" class="prev icon-arrow-a-left"></a>
                    <a href="javascript:;" class="next icon-arrow-a-right"></a>
                </div>
            </div>
            <!-- slide结束 -->


            <!-- slide开始 -->
<!--             <div class="slide">
                <div class="swiper-container swiper1">
                    <div class="swiper-wrapper">
                        <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=fff41558183d28a682ef128bb5944e44&action=lists&modelid=11&tagid=category_video_1&typeid=53%2C54&catid=16%2C17%2C18%2C19%2C21&order=id+DESC&thumb=1&thumbnum=1&num=10\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('modelid'=>'11','tagid'=>'category_video_1','typeid'=>'53,54','catid'=>'16,17,18,19,21','order'=>'id DESC','thumb'=>'1','thumbnum'=>'1','limit'=>'10',));}?>
                            <?php $n=1;if(is_array($data)) foreach($data AS $r) { ?> 
                            <div class="swiper-slide">
                                <a href="<?php echo $r['url'];?>">
                                    <div class="bg-gra"></div>

                                    <img src="<?php echo $r['thumb'];?>" alt="<?php echo $r['title'];?>" width="556" height="313"><span class="tag">尝鲜</span><span class="title"><?php echo str_cut($r['title'],60,false);?></span>
                                </a>
                            </div> 
                            <?php $n++;}unset($n); ?>
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?> 
                    </div>
                    <div class="swiper-button-next"><s class="slide-r-icon"></s></div>
                    <div class="swiper-button-prev"><s class="slide-l-icon"></s></div>
                </div>
            </div> -->
            <!-- slide结束 -->
            <div class="column">
                <div class="w-1170">
                    <h2 class="clearfix"><span class="title">栏目</span><p class="column-nav">
                        <a href="javascript:;" class="active">海外视频鲜知道</a>
                        <a href="javascript:;">尝鲜调查图</a>
                        <a href="javascript:;">科技碎碎念</a>
                        <a href="javascript:;">螃蟹八分熟</a>
                        <a href="javascript:;">其它</a>
                    </p></h2>
                    <div class="column-box">
                        <div class="column-list show clearfix">
                            <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=e41b400fb90f57220ab863851b0d838c&action=lists&tagid=category_video_2&modelid=11&catid=16&order=id+DESC&thumb=1&num=6\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('tagid'=>'category_video_2','modelid'=>'11','catid'=>'16','order'=>'id DESC','thumb'=>'1','limit'=>'6',));}?>
                            <?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
                                <dl>
                                <dt><a href="<?php echo $r['url'];?>"><img src="<?php echo $r['thumb'];?>" alt="<?php echo $r['title'];?>"><s class="video-big-icon"></s></a></dt>
                                <dd><a href="<?php echo $r['url'];?>"><?php echo $r['title'];?></a></dd>
                                </dl>  
                            <?php $n++;}unset($n); ?>
                            <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                            <div style="margin-right: 30px;"><p class="prev-next clearfix"><a href="<?php echo APP_PATH;?>index.php?m=content&c=index&a=lists&catid=16" class="more next r">更多</a></p></div>
                        </div>
                        <div class="column-list hide clearfix">
                            <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=719c313d1385993fecc505b1af69ad39&action=lists&tagid=category_video_3&modelid=11&catid=17&order=id+DESC&thumb=1&num=6\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('tagid'=>'category_video_3','modelid'=>'11','catid'=>'17','order'=>'id DESC','thumb'=>'1','limit'=>'6',));}?>
                            <?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
                                <dl>
                                <dt><a href="<?php echo $r['url'];?>"><img src="<?php echo $r['thumb'];?>" alt="<?php echo $r['title'];?>"><s class="video-big-icon"></s></a></dt>
                                <dd><a href="<?php echo $r['url'];?>"><?php echo $r['title'];?></a></dd>
                                </dl>  
                            <?php $n++;}unset($n); ?>
                            <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                            <div style="margin-right: 30px;"><p class="prev-next clearfix"><a href="<?php echo APP_PATH;?>index.php?m=content&c=index&a=lists&catid=17" class="more next r">更多</a></p></div>

                        </div>
                        <div class="column-list hide clearfix">
                            <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=904dad08ef58c869a567430ece227960&action=lists&tagid=category_video_4&modelid=11&catid=18&order=id+DESC&thumb=1&num=6\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('tagid'=>'category_video_4','modelid'=>'11','catid'=>'18','order'=>'id DESC','thumb'=>'1','limit'=>'6',));}?>
                            <?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
                                <dl>
                                <dt><a href="<?php echo $r['url'];?>"><img src="<?php echo $r['thumb'];?>" alt="<?php echo $r['title'];?>"><s class="video-big-icon"></s></a></dt>
                                <dd><a href="<?php echo $r['url'];?>"><?php echo $r['title'];?></a></dd>
                                </dl>  
                            <?php $n++;}unset($n); ?>
                            <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                            <div style="margin-right: 30px;"><p class="prev-next clearfix"><a href="<?php echo APP_PATH;?>index.php?m=content&c=index&a=lists&catid=18" class="more next r">更多</a></p></div>

                        </div>
                        <div class="column-list hide clearfix">
                            <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=c5310ffe6c9055f0b963026aaaeba811&action=lists&tagid=category_video_5&modelid=11&catid=19&order=id+DESC&thumb=1&num=6\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('tagid'=>'category_video_5','modelid'=>'11','catid'=>'19','order'=>'id DESC','thumb'=>'1','limit'=>'6',));}?>
                            <?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
                                <dl>
                                <dt><a href="<?php echo $r['url'];?>"><img src="<?php echo $r['thumb'];?>" alt="<?php echo $r['title'];?>"><s class="video-big-icon"></s></a></dt>
                                <dd><a href="<?php echo $r['url'];?>"><?php echo $r['title'];?></a></dd>
                                </dl>  
                            <?php $n++;}unset($n); ?>
                            <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                            <div style="margin-right: 30px;"><p class="prev-next clearfix"><a href="<?php echo APP_PATH;?>index.php?m=content&c=index&a=lists&catid=19" class="more next r">更多</a></p></div>

                        </div>
                        <div class="column-list hide clearfix">
                            <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=b3af68d26cf8983cf026ed7fadbd27a2&action=lists&tagid=category_video_6&modelid=11&catid=21&order=id+DESC&thumb=1&num=6\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('tagid'=>'category_video_6','modelid'=>'11','catid'=>'21','order'=>'id DESC','thumb'=>'1','limit'=>'6',));}?>
                            <?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
                                <dl>
                                <dt><a href="<?php echo $r['url'];?>"><img src="<?php echo $r['thumb'];?>" alt="<?php echo $r['title'];?>"><s class="video-big-icon"></s></a></dt>
                                <dd><a href="<?php echo $r['url'];?>"><?php echo $r['title'];?></a></dd>
                                </dl>  
                            <?php $n++;}unset($n); ?>
                            <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                            <div style="margin-right: 30px;"><p class="prev-next clearfix"><a href="<?php echo APP_PATH;?>index.php?m=content&c=index&a=lists&catid=21" class="more next r">更多</a></p></div>

                        </div>
                    </div>
                </div>
            </div> 
        </div>
        <!-- con结束 -->

        <!-- 底部开始 --> 
<?php include template("content","footer"); ?>    
