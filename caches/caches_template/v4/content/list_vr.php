<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template("content","header"); ?>
<link rel="stylesheet" href="<?php echo CSS_PATH;?>v4/channel.css">
<link rel="stylesheet" href="<?php echo CSS_PATH;?>v4/list.css">

<script language="javascript" type="text/javascript">
function showSubNav(id){
document.getElementById(id).style.display='block';
}
function hideSubNav(id){
document.getElementById(id).style.display='none';
}

$(document).ready(function(){
     var page = 2;
     var pagesize = 9;

    $('#more').click(function(){
        $.ajax({   
            url:'<?php echo APP_PATH;?>api_v2.php?op=phpcmsv9&file=article&action=load_more&callback=jscallback', 
            dataType:'jsonp',  
            type:'get',   
            data:'page='+page+'&pagesize='+pagesize+'&catid=<?php echo $catid;?>&modelid=1',   
            async : false, //默认为true 异步   
            error:function(){   
               alert('error');   
            },   
            success:function(data){   
                var html = '';
                $.each(data, function(idx, obj) {
                    html = html + '<dl><dt><a href="'+obj.url+'"><img src="'+obj.thumb+'" alt=""></a></dt><dd class="title"><a href="'+obj.url+'">'+obj.title+'</a></dd></dl> '; 
                });
                page = page +1;
               $(".news-list").append(html);
            }
        });
    }); 
});

</script>

        <!-- 头部结束 -->
        <!-- con开始 -->
        <div class="con-out">
            <div class="news">
                <div class="w-1170">
                    <div class="pingce">
                        <h2><?php echo $catname;?></h2>
                    </div>
                    <div class="hot-video-list clearfix">
                        <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=a1a82cde27263a14ac98134601ca6fbc&action=lists&modelid=1&tagid=list_vr_1&grade=5&typeid=53&catid=13&order=id+DESC&thumb=1&num=1\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('modelid'=>'1','tagid'=>'list_vr_1','grade'=>'5','typeid'=>'53','catid'=>'13','order'=>'id DESC','thumb'=>'1','limit'=>'1',));}?>
                            <?php $n=1;if(is_array($data)) foreach($data AS $r) { ?> 
                                <a href="<?php echo $r['url'];?>" class="video-list first-video-list">
                                    <img src="<?php echo $r['thumb'];?>" alt=""><span ><?php echo $r['title'];?></span><div class="bg-gra"></div>
                                </a> 
                            <?php $n++;}unset($n); ?>
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>

                        <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=3620319d63680408af0f1ea4899bbdcc&action=lists&modelid=1&tagid=list_vr_2&grade=4&typeid=53%2C54%2C57%2C58&catid=13&order=id+DESC&thumb=1&num=2\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('modelid'=>'1','tagid'=>'list_vr_2','grade'=>'4','typeid'=>'53,54,57,58','catid'=>'13','order'=>'id DESC','thumb'=>'1','limit'=>'2',));}?>
                            <?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
                                <a href="<?php echo $r['url'];?>" class="video-list">
                                    <img src="<?php echo $r['thumb'];?>" alt=""><span><?php echo $r['title'];?></span><div class="bg-gra"></div>
                                </a> 
                            <?php $n++;}unset($n); ?>
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>

                    </div>
                    <div class="channel-list"><a href="javascript:;" class="active">最新资讯</a>
                        <span class="line-icon"></span><a href="<?php echo APP_PATH;?>index.php?m=content&c=index&a=type_list&typeid=53&modelid=<?php echo $modelid;?>&catid=<?php echo $catid;?>">评测</a>
                        <span class="line-icon"></span><a href="<?php echo APP_PATH;?>index.php?m=content&c=index&a=type_list&typeid=59&modelid=<?php echo $modelid;?>&catid=<?php echo $catid;?>">视频</a>
                    </div>
                    <div class="news-list clearfix">
                        <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=dda44c1a8604a36eb8a4a96d758f874a&action=lists&catid=13&order=id+DESC&thumb=1&num=9\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('catid'=>'13','order'=>'id DESC','thumb'=>'1','limit'=>'9',));}?>
                            <?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
                                <dl>
                                <dt><a href="<?php echo $r['url'];?>"><img src="<?php echo $r['thumb'];?>" alt=""></a></dt>
                                <dd class="title"><a href="<?php echo $r['url'];?>"><?php echo $r['title'];?></a></dd>
                                </dl> 
                            <?php $n++;}unset($n); ?>
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?> 
                    </div>
                    <a href="javascript:;" class="more" class="load-more" id="more">更多</a>
                </div>
            </div>

        </div>
        <!-- con结束 -->

        <!-- 底部开始 -->
<?php include template("content","footer"); ?>


