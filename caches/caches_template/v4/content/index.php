<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template("content","header"); ?>
<script type="text/javascript" src="<?php echo JS_PATH;?>v4/common.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>v4/swiper.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>v4/jquery.foucs.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>v4/index.js"></script>
<link rel="stylesheet" href="<?php echo CSS_PATH;?>v4/swiper.min.css">
<link rel="stylesheet" href="<?php echo CSS_PATH;?>v4/index.css">
        <!-- con开始 -->
        <div class="con-out">
            <!-- slide开始 -->
            <div class="slide" id="indexSlide">
                <div id="index_b_hero">
                    <div class="hero-wrap">
                        <ul class="heros clearfix">
                        <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=6acd2a52bce3f141b8abfbd81daaf58d&action=lists&modelid=1&tagid=index_1&grade=8&typeid=53%2C54%2C55%2C56%2C57%2C58&catid=9%2C10%2C11%2C12%2C13%2C14%2C22%2C16%2C17%2C18%2C19%2C21&order=id+DESC&thumb=1&thumbnum=1&num=5\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('modelid'=>'1','tagid'=>'index_1','grade'=>'8','typeid'=>'53,54,55,56,57,58','catid'=>'9,10,11,12,13,14,22,16,17,18,19,21','order'=>'id DESC','thumb'=>'1','thumbnum'=>'1','limit'=>'5',));}?>
                            <?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
                            <li class="hero">
                                <a href="<?php echo $r['url'];?>" target="_blank">
                                    <img src="<?php echo $r['thumb'];?>" class="thumb"/>
                                    <span><?php echo $r['title'];?></span>
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
            
            <div class="hot-list">
                <div class="w-1170">
                    <ul class="clearfix">
                        <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=079b4e8c41d7aac44c64675b5b30e9f1&action=lists&modelid=1&tagid=index_2&keywords=%E6%B4%BB%E5%8A%A8%2C%E5%B9%BF%E5%91%8A%2C%E8%A6%81%E9%97%BB&typeid=53%2C54%2C55%2C56%2C57%2C58&catid=9%2C10%2C11%2C12%2C13%2C14%2C22%2C16%2C17%2C18%2C19%2C21&order=id+DESC&thumb=1&thumbnum=2&num=4\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('modelid'=>'1','tagid'=>'index_2','keywords'=>'活动,广告,要闻','typeid'=>'53,54,55,56,57,58','catid'=>'9,10,11,12,13,14,22,16,17,18,19,21','order'=>'id DESC','thumb'=>'1','thumbnum'=>'2','limit'=>'4',));}?>
                            <?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
                            <li>
                            <a href="<?php echo $r['url'];?>"><img src="<?php echo $r['thumb'];?>" alt="<?php echo $r['title'];?>"><?php echo $r['title'];?></a>
                            </li> 
                            <?php $n++;}unset($n); ?>
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                    </ul>
                </div>
            </div>
            <div class="today-express bg-f4f4f4">
                <div class="w-1170">
                    <span class="line-icon"></span>
                    <span class="today-title">推荐产品</span>
                    <div class="today-con swiper-container">
                        <div class="today-list swiper-wrapper clearfix">
                            <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=4a76b9fad28a01cb9bc1ed3c38b4cf8e&action=lists&tagid=index_paokuan&modelid=12&catid=22&order=id+DESC&thumb=1&num=6\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('tagid'=>'index_paokuan','modelid'=>'12','catid'=>'22','order'=>'id DESC','thumb'=>'1','limit'=>'6',));}?>
                                <?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
                                    <dl class="swiper-slide">
                                        <a href="<?php echo $r['url'];?>">
                                            <dt><img src="<?php echo $r['thumb'];?>" alt="<?php echo $r['title'];?>"></dt>
                                            <dd><?php echo str_cut($r['title'],46,false);?></dd>
                                            <dd class="price">￥<?php echo $r['price'];?></dd>
                                        </a>
                                    </dl> 
                                <?php $n++;}unset($n); ?>
                            <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                        </div>
                        <a href="javascript:;" class="swiper-button-prev prev icon-today-a-left"></a>
                        <a href="javascript:;" class="swiper-button-next next icon-today-a-right "></a>
                    </div>
                    
                    <a href="#" class="more">更多</a>
                </div>
            </div>

            <div class="news bg-fff" style="background: #fff;">
                <div class="w-1170">
                    <h2>最新资讯</h2>
                    <div class="news-list clearfix">
                        <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=28b03efac06cf739234f4b484a3d035f&action=lists&tagid=index_new_zuixin&modelid=1&typeid=54&catid=9%2C10%2C11&order=id+DESC&thumb=1&num=6\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('tagid'=>'index_new_zuixin','modelid'=>'1','typeid'=>'54','catid'=>'9,10,11','order'=>'id DESC','thumb'=>'1','limit'=>'6',));}?>
                            <?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
                                <dl>
                                <dt><a href="<?php echo $r['url'];?>"><img src="<?php echo $r['thumb'];?>" alt=""></a></dt>
                                <dd class="title"><a href="<?php echo $r['url'];?>"><?php echo str_cut($r['title'],48);?></a></dd>
                                <dd><?php echo str_cut($r['description'],168);?></dd>
                                </dl> 
                            <?php $n++;}unset($n); ?>
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                    </div>
                    <a href="<?php echo APP_PATH;?>index.php?m=content&c=index&a=type_list&typeid=54&modelid=1" class="more">更多</a>
                </div>
            </div>

            
            <div class="hot-video bg-f4f4f4">
                <div class="w-1170">
                    <h2>热点视频</h2>
                    <div class="hot-video-list clearfix">
                        <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=f7686feb5b228acad7a9ca744f293cd9&action=lists&modelid=11&tagid=index_hot_video&grade=5&typeid=53&catid=16%2C17%2C18%2C19&order=id+DESC&thumb=1&thumbnum=1&num=3\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('modelid'=>'11','tagid'=>'index_hot_video','grade'=>'5','typeid'=>'53','catid'=>'16,17,18,19','order'=>'id DESC','thumb'=>'1','thumbnum'=>'1','limit'=>'3',));}?>
                            <?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
                                <?php if($n==1) { ?>
                                    <a href="<?php echo $r['url'];?>" class="video-list first-video-list"><img src="<?php echo $r['thumb'];?>" alt=""><span><?php echo str_cut($r['title'],90);?><s class="video-icon"></s></span></a>
                                <?php } else { ?>
                                    <a href="<?php echo $r['url'];?>" class="video-list"><img src="<?php echo $r['thumb'];?>" alt=""><span><?php echo str_cut($r['title'],52,'...');?><s class="video-icon"></s></span></a> 
                                <?php } ?>
                            <?php $n++;}unset($n); ?>
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>    

                        <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=a2da5457dd70fd43ee414c722012bdaf&action=lists&modelid=11&tagid=index_hot_video_2&grade=4&typeid=53%2C54%2C55%2C56%2C57%2C58&catid=16%2C17%2C18%2C19&order=id+DESC&thumb=1&num=3\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('modelid'=>'11','tagid'=>'index_hot_video_2','grade'=>'4','typeid'=>'53,54,55,56,57,58','catid'=>'16,17,18,19','order'=>'id DESC','thumb'=>'1','limit'=>'3',));}?>
                            <?php $n=1;if(is_array($data)) foreach($data AS $r) { ?> 
                                    <a href="<?php echo $r['url'];?>" class="video-list"><img src="<?php echo $r['thumb'];?>" alt=""><span><?php echo str_cut($r['title'],52,'...');?><s class="video-icon"></s></span></a> 
                            <?php $n++;}unset($n); ?>
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?> 
                        
                    </div> 
                    <a href="<?php echo $CATEGORYS['15']['url'];?>" class="more">更多</a>
                </div>
            </div>
            
            <div class="news-eval bg-fff">
                <div class="w-1170">
                    <h2>热门评测</h2>
                    <div class="news-eval-list clearfix">
                        <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=879819a50f57fd6deaadc71402071aa3&action=lists&modelid=1&tagid=index_hotpingche&typeid=53&catid=9%2C10%2C11%2C12%2C13%2C14%2C16%2C17%2C18%2C19%2C21&order=id+DESC&thumb=1&thumbnum=2&num=5\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('modelid'=>'1','tagid'=>'index_hotpingche','typeid'=>'53','catid'=>'9,10,11,12,13,14,16,17,18,19,21','order'=>'id DESC','thumb'=>'1','thumbnum'=>'2','limit'=>'5',));}?>
                            <?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
                                <?php if($n==1) { ?>
                                    <dl class="first-news-eval">
                                        <dt><a href="<?php echo $r['url'];?>"><img src="<?php echo $r['thumb'];?>" alt=""></a></dt>
                                        <dd class="title"><a href="<?php echo $r['url'];?>" target=_blank><?php echo $r['title'];?></a></dd>
                                        <dd><?php echo $r['description'];?></dd>
                                    </dl>
                                <?php } else { ?>
                                    <dl>
                                    <dt><a href="<?php echo $r['url'];?>"><img src="<?php echo $r['thumb'];?>" alt=""></a></dt>
                                    <dd class="title"><a href="<?php echo $r['url'];?>"><?php echo $r['title'];?></a></dd>
                                    </dl>
                                <?php } ?>
                             
                            <?php $n++;}unset($n); ?>
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?> 

                    </div>
                    <a href="<?php echo APP_PATH;?>index.php?m=content&c=index&a=type_list&typeid=53&modelid=1" class="more">更多</a>
                </div>
                
            </div> 
            <div class="the-latest">
                <div class="w-1170">
                    <h2>最新动态</h2>
                    <ul class="clearfix">
                        <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=ae173ae97c33e300ff90a4b01da17328&action=lists&tagid=index_new_news&typeid=54%2C57&catid=9%2C10%2C11%2C12%2C13%2C14&order=id+DESC&num=10\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('tagid'=>'index_new_news','typeid'=>'54,57','catid'=>'9,10,11,12,13,14','order'=>'id DESC','limit'=>'10',));}?>
                            <?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
                                <li><s class="block-icon"></s><a href="<?php echo $r['url'];?>" target=_blank><?php echo $r['title'];?></a></li> 
                            <?php $n++;}unset($n); ?>
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                    </ul>
                </div>
            </div>
        </div>
        <!-- con结束 -->


<!-- 底部开始 -->
<?php include template("content","footer"); ?>



