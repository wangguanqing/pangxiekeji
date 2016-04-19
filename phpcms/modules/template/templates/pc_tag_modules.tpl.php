<?php
defined('IN_ADMIN') or exit('No permission resources.'); 
include $this->admin_tpl('header', 'admin');
?>
<script type="text/javascript">
<!-- 

function getLocalTime(tm){ 
    var tt=new Date(parseInt(tm) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " "); 
    tt = tt.replace('GMT+8','');
    return tt; 
}  

//搜索结果点击事件
function select_list(obj,title,url,thumb,id) {
  $('#insert_title').val(title);
  $('#insert_url').val(url);
  $('#insert_thumb').val(thumb);
  $('#insert_id').val(id);

}
$(document).ready(function(){
     // var page = $.("#search_page").val();

     var page = 1;
    $('#search').click(function(){
        // $("#search_table").html('');
        $("#search_table tr:gt(0)").remove();
        var page = 1;
        var q1 = $("#q").val();
        var q = $.trim(q1);
        $.ajax({   
            url:'<?php echo APP_PATH;?>api_v2.php?op=phpcmsv9&file=article&action=search&callback=jscallback', 
            dataType:'jsonp',  
            type:'get',   
            data:'modelid=1&page='+page+'&pagesize=5&q='+q,   
            async : false, //默认为true 异步   
            error:function(){   
               alert('error');   
            },   
            success:function(data){   
                var html = ''; 
                $.each(data, function(idx, obj) {
                  html = html + '<tr ><th width=\"80\">'+obj.id+'</th><td class=\"y-bg\"><a href=\"'+obj.url+'\" target=_blank>'+obj.title+'</a> - '+getLocalTime(obj.inputtime)+'&nbsp;&nbsp;<span onclick=\"select_list(this,\''+obj.title+'\',\''+obj.url+'\',\''+obj.thumb+'\','+obj.id+')\" ><font color=red style=\"cursor:pointer;\">点击选择</font><span></td></tr>';
                });
                $("#search_table").append(html);
                $("#q").val('');

            }
        });
    }); 

    //加载人工插入的文章
    $('#load_add_article').click(function(){
        $("#add_article_list tr:gt(0)").remove();//多次加载去除以前的记录，重新拉取
        var tagid = $("#tagid").val();
        $.ajax({   
            url:'<?php echo APP_PATH;?>api_v2.php?op=phpcmsv9&file=article&action=load_add_article&callback=jscallback', 
            dataType:'jsonp',  
            type:'get',   
            data:'tagid='+tagid,   
            async : false, //默认为true 异步   
            error:function(){   
               alert('error');   
            },   
            success:function(data){   
                var html = ''; 
                $.each(data, function(idx, obj) {
                  html = html + '<tr><th width=\"80\">'+obj.id+'</th><td class=\"y-bg\"><a target=_blank href=\"'+obj.url+'\" class=\"title\">'+obj.title+'</a>&nbsp;&nbsp;<span class=\"thumb\" eid=\"'+obj.thumb+'\"><img src=\"<?php echo APP_PATH;?>statics/images/icon/small_img.gif\"></span> &nbsp;<span class=\"url\" eid=\"'+obj.url+'\">链接</span> &nbsp;&nbsp;排序：<span class=\"listorder\" eid=\"'+obj.listorder+'\"><font color=red>'+obj.listorder+'</font></span>&nbsp;&nbsp;<span calss="do"><a class=\"article-edit\" eid=\"'+obj.id+'\">修改</a> | <a class=\"del-article\" id=\"359708\">删除</a></span></td></tr>';
                });
                $("#add_article_list").append(html);
            }
        });
    }); 

    //插入文章
    $('#add_article').click(function(){
        //tagid
        var tagid = $("#tagid").val();

        var contentid = $("#insert_id").val();
        var title = $('#insert_title').val();
        var url = $('#insert_url').val();
        var thumb = $('#insert_thumb').val();
        var position = $('#insert_position').val();
        var starttime = $('#online_start_time').val();
        var endtime = $('#online_end_time').val();
        $.ajax({   
            url:'<?php echo APP_PATH;?>api_v2.php?op=phpcmsv9&file=article&action=add_article&callback=jscallback', 
            dataType:'jsonp',  
            type:'get',   
            data:'contentid='+contentid+'&tagid='+tagid+'&title='+title+'&url='+url+'&thumb='+thumb+'&listorder='+position+'&starttime='+starttime+'&endtime='+endtime,   
            async : false, //默认为true 异步   
            error:function(){   
               alert('error');   
            },   
            success:function(data){   
                var html = ''; 
                alert('插入成功！');
                // $("#search_table").append(html);
            }
        });
    });





}); 

	$(function(){
		$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}});
		$("#cache").formValidator({onshow:"<?php echo L("enter_the_cache_input_will_not_be_cached")?>",onfocus:"<?php echo L("enter_the_cache_input_will_not_be_cached")?>",empty:true}).regexValidator({regexp:"num1",datatype:'enum',param:'i',onerror:"<?php echo L("cache_time_can_only_be_positive")?>"});
		$("#num").formValidator({onshow:"<?php echo L('input').L("num")?>",onfocus:"<?php echo L('input').L("num")?>",empty:true}).regexValidator({regexp:"num1",datatype:'enum',param:'i',onerror:"<?php echo L('that_shows_only_positive_numbers')?>"});
		$("#return").formValidator({onshow:"<?php echo L("please_enter_the_data_returned_value_by_default")?>：data。",onfocus:"<?php echo L("please_enter_the_data_returned_value_by_default")?>：data。",empty:true});
		show_action('<?php echo $_GET['action']?>');
    // 模型ID
    $("#modelid").formValidator({onshow:"请勿随便修改此数据！",onfocus:"请勿随便修改此数据！",empty:true});
    $("#tagid").formValidator({onshow:"请勿随便修改此数据！",onfocus:"请勿随便修改此数据！",empty:true});
    //tagid，模型ID，不能随意修改
    $("#modelid").attr("readonly",true)
    $("#tagid").attr("readonly",true)


	})
	
	function show_action(obj) {
		$('.pc_action_list').hide();
		$('#action_'+obj).show();
	}



  //修改插入的内容
  $(".article-edit").live("click",
        function(){ 
          id = $(this).attr('eid');
          title = $(this).parent().siblings('.title').html();
          thumb = $(this).parent().siblings('.thumb').attr('eid');
          url = $(this).parent().siblings('.url').attr('eid');
          listorder = $(this).parent().siblings('.listorder').attr('eid');
          $htmltitle ="<input type='text' class='input_content' align='center' width='200px' name='title' value='"+title+"'>";
          $htmlthumb = "<input type='text' align='center' name='thumb' value='"+thumb+"'>";
          $htmlurl = "<input type='text' align='center' name='url' value='"+url+"'>";
          $htmllistorder = "<input type='text' align='center' name='listorder' value='"+listorder+"'>";
          $cancle = "<a class='article-update'  id='"+id+"'>确定</a> | <a class='article-cancle' eid='"+id+"'>取消</a>";
          $(this).parent().html($cancle).siblings('.title').html($htmltitle).siblings('.thumb').html($htmlthumb).siblings('.url').html($htmlurl).siblings('.listorder').html($htmllistorder);
  })

// 提交插入文章的修改
$(document).on("click",".article-update",function(){
    var r=confirm("确定要修改？");
    if (r==true){
        id = $(this).attr("id");
        title = $(this).parent().siblings('.title').children().attr('value');
        thumb = $(this).parent().siblings('.thumb').children().attr('value');
        url = $(this).parent().siblings('.url').children().attr('value');
        listorder = $(this).parent().siblings('.listorder').children().attr('value');
        $.ajax({
              url: "?m=content&c=content&a=chang_add_article&pc_hash=<?php echo $_SESSION['pc_hash'];?>",
              async : false,
              data :{
                  id:id,
                  title : title,
                  thumb:thumb,
                  url:url,
                  listorder:listorder,
              },
              type:"post",
              success: function( data  ){
                  alert("修改成功！");
              }        
          });
          // location.reload(true);   
    }else{
       // location.reload(true); 
    }
  })



  $(".article-cancle").live("click",
        function(){ 
          id = $(this).attr('eid');
          content = $(this).parent().siblings('.content').children().attr('value');
          digg = $(this).parent().siblings('.digg').children().attr('value');
          down = $(this).parent().siblings('.down').children().attr('value');
          $cancle = "<a class='article-edit' eid='"+id+"'>修改</a> | <a class='del-article'  id='<?php echo $value['id'] ?>'>删除</a>";
          $(this).parent().html($cancle).siblings('.content').html(content).siblings('.digg').html(digg).siblings('.down').html(down);
  })



//-->
</script>
<div class="pad-10">
<form action="?m=template&c=file&a=edit_pc_tag&style=<?php echo $this->style?>&dir=<?php echo $dir?>&file=<?php echo urlencode($file)?>&op=<?php echo $op?>&tag_md5=<?php echo $_GET['tag_md5']?>" method="post" id="myform">
<fieldset>
	<legend>模块配置</legend>
<table width="100%"  class="table_form">
	  <tr>
    <th width="80"><?php echo L("module")?>：</th>
    <td class="y-bg"><?php echo $op?></td>
  </tr>
    <tr>
    <th width="80">操作：</th>
    <td class="y-bg"> 
      <?php 
        if(isset($html['action']) && is_array($html['action'])) {
    	    foreach($html['action'] as $key=>$value) {
    				$checked = $_GET['action']==$key ? 'checked' : '';
    				echo '<label><input type="radio" name="action" onclick="location.href=\'?'.creat_url($key).'\'" '.$checked.' value="'.$key.'"> '.$value."</label>";
    			}
        }
      ?>
  </td>
  </tr>
  
  <?php 
  if(isset($html[$_GET['action']]) && is_array($html[$_GET['action']])):
  foreach($html[$_GET['action']] as $k=>$v): 
  ?>
  <tr>
    <th width="80"><?php echo $v['name']?>：</th>
    <td class="y-bg"><?php echo creat_form($k,$v,$_GET[$k], $op)?></td>
  </tr>
  <?php if(isset($v['ajax']['name'])  && !empty($v['ajax']['name'])) {?>
  	  <tr>
  	  	<th width="80"><?php echo $v['ajax']['name']?>：<?php if(isset($_GET[$v['ajax']['id']]) && !empty($_GET[$v['ajax']['id']])) echo '<script type="text/javascript">$.get(\'?m=template&c=file&a=public_ajax_get\', { html: \''.$_GET[$k].'\', id:\''.$v['ajax']['id'].'\', value:\''.$_GET[$v['ajax']['id']].'\', action: \''.$v['ajax']['action'].'\', op: \''.$op.'\', style: \'default\'}, function(data) {$(\'#'.$k.'_td\').html(data)});</script>'?></th>
  	  	<td class="y-bg"><input type="text" size="20" value="<?php echo $_GET[$v['ajax']['id']]?>" id="<?php echo $v['ajax']['id']?>" name="<?php echo $v['ajax']['id']?>" class="input-text"><span id="<?php echo $k?>_td"></span></td>
  	 </tr>
  <?php }?>
  <?php endforeach;endif;?>
  
</table>
</fieldset>

<div class="bk15"></div>
<fieldset>
	<legend>公共配置</legend>
		<table width="100%"  class="table_form">
	  <tr>
    <th width="80"><?php echo L("public_allowpageing")?>：</th>
    <td class="y-bg"><input type="radio" name="page" value="$page"<?php if (isset($_GET['page'])) {echo ' checked';}?> /> <?php echo L("yes")?>  <input type="radio" name="page" value=""<?php if (!isset($_GET['page'])) {echo ' checked';}?> /> <?php echo L("no")?></td>
  </tr>
    <tr>
    <th width="80"><?php echo L("num")?>：</th>
    <td class="y-bg"><input type="text" name="num" id="num" size="30" value="<?php echo $_GET['num']?>" /></td>
  </tr>
   <tr>
    <th width="80"><?php echo L("check")?>：</th>
    <td class="y-bg"><input type="text" name="return" id="return" size="30" value="<?php echo $_GET['return']?>" /> </td>
  </tr>
   <tr>
    <th width="80"><?php echo L("buffer_time")?>：</th>
    <td class="y-bg"><input type="text" name="cache" id="cache" size="30" value="<?php echo $_GET['cache']?>" /> </td>
  </tr>
</table>
</fieldset>
<input type="submit" class="dialog" id="dosubmit" name="dosubmit" value="<?php echo L('submit')?>" />
</div>
</form>

<div class="pad-10">
<!-- 手动插入结果 -->
<!-- <div class="bk15"></div>
<fieldset>
  <legend>实时数据</legend>
    <table width="100%"  class="table_form">
    <tr>
    <th width="80">加载数据：</th>
    <td class="y-bg">
      <input type="button" class="button" value="加 载" onclick="">
    </td>
  </tr>
    <tr>
    <th width="80">2：</th>
    <td class="y-bg"><input type="text" name="num" id="num" size="30" value="3" /></td>
    </tr>
     
</table>
</fieldset> -->
<!-- 手动插入结束 -->

<div class="bk15"></div>
<fieldset>
  <legend>实时数据</legend>
    <table width="100%"  class="table_form" id="article_list" name="article_list">
    <tr>
    <th width="80">加载数据：</th>
    <td class="y-bg">
      <input type="button" class="button" value="加 载" id="load_article" name="load_article">
    </td>
    </tr>
    <tr>      
</table>
</fieldset>


<!-- 手动插入结果 -->
<div class="bk15"></div>
<fieldset>
  <legend>手动插入记录</legend>
    <table width="100%"  class="table_form" id="add_article_list" name="add_article_list">
    <tr>
    <th width="80">加载数据：</th>
    <td class="y-bg">
      <input type="button" class="button" value="加 载" id="load_add_article" name="load_add_article">
    </td>
    </tr>
    <tr>

    
     
</table>
</fieldset>
<!-- 手动插入结束 -->

<div class="bk15"></div>
<fieldset>
  <legend>修改要插入的数据</legend>
    <table width="100%"  class="table_form">
    <tr>
    <th width="80">位置：</th>
    <td class="y-bg">

      <select name="insert_position" id="insert_position">
        <?php 
          for ($i=0; $i < $_GET['num']; $i++) { 
            # code...
            if($i==0){
              echo '<option value="1" selected="">1</option>';
            }else{
              echo '<option value="'.($i+1).'">'.($i+1).'</option>';
            }
          }
        ?> 
      </select>

    </td>
  </tr>
  <tr>
    <th width="80">文章ID：</th>
    <td class="y-bg"><input type="text" name="insert_id" id="insert_id" size="20" value="" /></td>
  </tr>
    <tr>
    <th width="80">标题：</th>
    <td class="y-bg"><input type="text" name="insert_title" id="insert_title" size="40" value="" /></td>
  </tr>
   <tr>
    <th width="80">链接：</th>
    <td class="y-bg"><input type="text" name="insert_url" id="insert_url" size="50" value="" /> </td>
  </tr>
   <tr>
    <th width="80">图片：</th>
    <td class="y-bg">
      <?php echo form::images('insert_thumb', 'insert_thumb', '', 'content_thumb');?>

    </td>
  </tr>
   <tr>
    <th width="80">上线时间：</th>
    <td class="y-bg">
      <?php echo form::date('online_start_time','',1)?>
      下线时间：
      <?php echo form::date('online_end_time','',1)?>
    </td>
  </tr>
   <tr>
    <th width="80"></th>
    <td class="y-bg"> 
      <input type="button" class="button" value="确定插入" id="add_article" name="add_article">
    </td>
  </tr>

</table>
</fieldset>


<!-- 手动插入 -->
<div class="bk15"></div>
<fieldset>
  <legend>文章搜索</legend> 
    <table width="100%"  class="table_form" id="search_table" name="search_table">
      <tr>
      <th width="80">搜索：</th>
      <td class="y-bg">
        <input type="text" name="q" id="q" size="20" value="" />
        <input type="button" class="button" value="搜索" id="search" name="search"></td>
      </tr> 
    </table>
</fieldset>
<!-- 手动插入结束 -->
</div>

</body>
</html>