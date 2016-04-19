<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template("content","header"); ?>
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
            url:'<?php echo APP_PATH;?>api_v2.php?op=phpcmsv9&file=article&action=load_type_more&callback=jscallback', 
            dataType:'jsonp',  
            type:'get',   
            data:'page='+page+'&pagesize='+pagesize+'&catid=<?php echo $_GET['catid'];?>&modelid=<?php echo $_GET['modelid'];?>&typeid=<?php echo $_GET['typeid'];?>&type=<?php echo $_GET['type'];?>',   
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
<link rel="stylesheet" href="<?php echo CSS_PATH;?>v4/list.css">
<style type="text/css"> 
.category-list{
   -webkit-transition:all 0.5s ease;
   -moz-transition:all 0.5s ease;
   -o-transition:all 0.5s ease;
   -ms-transition:all 0.5s ease;
   transition:all 0.5s ease;
}
</style>

        <!-- 头部结束 -->
        <!-- con开始 -->
        <div class="con-out">
            <div class="news">
                <div class="w-1170">
                    <div class="pingce">
                        <h2><?php echo $type_array['0']['name'];?></h2>
                        <div class="pingce-list">
                            <ul class="clearfix">
                                <li class="light"><a href="javascript:;">排序:</a></li>
                                <li><a href="<?php echo APP_PATH;?>index.php?m=content&c=index&a=type_list&typeid=<?php echo $typeid;?>&modelid=<?php echo $modelid;?>&type=hot">最热</a></li>
                                <li><a href="<?php echo APP_PATH;?>index.php?m=content&c=index&a=type_list&typeid=<?php echo $typeid;?>&modelid=<?php echo $modelid;?>">最新</a></li>
                                <li class="category active" onmouseover="showSubNav('category-list');" onmouseout="hideSubNav('category-list');">
                                    <a href="javascript:;">分类<s class="tri-icon"></s></a>
                                    <div class="category-list" id="category-list">
                                        <a href="<?php echo APP_PATH;?>index.php?m=content&c=index&a=type_list&typeid=<?php echo $typeid;?>&modelid=11">视频</a>
                                        <a href="<?php echo APP_PATH;?>index.php?m=content&c=index&a=type_list&typeid=<?php echo $typeid;?>&modelid=1">文章</a>
                                    </div>
                                </li>                         
                            </ul>
                        </div>
                    </div>
                    <div class="news-list clearfix">

                        <?php $n=1;if(is_array($return)) foreach($return AS $r) { ?>
                        <dl>
                        <dt><a href="<?php echo $r['url'];?>"><img src="<?php echo $r['thumb'];?>" alt=""></a></dt>
                        <dd class="title"><a href="<?php echo $r['url'];?>"><?php echo $r['title'];?></a></dd>
                        </dl> 
                        <?php $n++;}unset($n); ?> 
 
                    </div>
                    <a href="javascript:;" class="more" class="load-more" id="more">更多</a>
                </div>
            </div>
        </div>
        <!-- con结束 -->

        <!-- 底部开始 -->
<?php include template("content","footer"); ?>
