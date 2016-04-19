<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template("wap","header"); ?>
<link rel="stylesheet" href="<?php echo CSS_PATH;?>v4/wap/index.css">
<script> 
function getLocalTime(tm){ 
    var tt=new Date(parseInt(tm) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " "); 
    tt = tt.replace('GMT+8','');
    return tt; 
}  

$(document).ready(function(){
     var page = 2;
     var pagesize = 9;
    $('#more').click(function(){
        $.ajax({   
            url:'<?php echo APP_PATH;?>api_v2.php?op=phpcmsv9&file=article&action=load_type_more&callback=jscallback', 
            dataType:'jsonp',  
            type:'get',   
            data:'page='+page+'&pagesize='+pagesize+'&modelid=<?php echo $_GET['modelid'];?>&typeid=<?php echo $_GET['typeid'];?>&type=new',   
            async : false, //默认为true 异步   
            error:function(){   
               alert('error');   
            },   
            success:function(data){   
                var html = '';
                $.each(data, function(idx, obj) {
                    html = html + '<dl><dt><a href="'+obj.url+'"><img src="'+obj.thumb+'"></a></dt><dd class="m-title"><a href="'+obj.url+'">'+obj.title+'</a></dd><dd class="m-date">'+getLocalTime(obj.inputtime)+'</dd></dl>';
                });
                page = page +1;
               $("#type_list").append(html);
            }
        });
    }); 
});

</script>

<!-- header -->

		<div class="main">
			<div class="m-box m-list">
				<h2><?php echo $type_array['0']['name'];?></h2>
				<div class="m-box-spec m-list-con" id="type_list">
                    <?php $n=1;if(is_array($return)) foreach($return AS $r) { ?>
						<dl>
							<dt>
								<a href="<?php echo $r['url'];?>"><img src="<?php echo $r['thumb'];?>"></a>
							</dt>
							<dd class="m-title">
								<a href="<?php echo $r['url'];?>"><?php echo $r['title'];?></a>
							</dd>
							<dd class="m-date"><?php echo date("Y-m-d H:i",$r['inputtime']);?></dd>
						</dl> 
					<?php $n++;}unset($n); ?>
				</div>
				<span class="m-list-more" id="more">更多</span>
			</div> 
		</div>

<!-- footer -->
<?php include template("wap","footer"); ?>
		 