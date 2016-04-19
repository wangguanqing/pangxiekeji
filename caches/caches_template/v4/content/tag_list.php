<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template("content","header"); ?>
<link rel="stylesheet" href="<?php echo CSS_PATH;?>v4/list.css"> 
<link rel="stylesheet" href="<?php echo CSS_PATH;?>v4/pages.css"> 
        <!-- con开始 -->
        <div class="con-out">
            <div class="news">
                <div class="w-1170">
                    <div class="search-h clearfix">
                        <div class="l result">总共有 <?php echo $total;?> 条记录</div>
                        <div class="r">
                            <form action="#" class="search-list clearfix">
                                <input type="text" value="" class="keyword l"/>
                                <input type="submit" value="" class="sub l">
                            </form>
                        </div>
                    </div>
                    <div class="news-list clearfix">
                        <?php $n=1;if(is_array($datas)) foreach($datas AS $r) { ?>
                        <dl>
                            <dt><a href="<?php echo $r['url'];?>" target=_blank><img src="<?php echo $r['thumb'];?>" ></a></dt>
                            <dd class="title"><a href="<?php echo $r['url'];?>" target=_blank><?php echo $r['title'];?></a></dd>
                        </dl> 
                        <?php $n++;}unset($n); ?>

                    </div>
                    <div id="pages" class="text-c" style="text-align: center;"><?php echo $pages;?></div>
                </div>
            </div>
        </div>
        <!-- con结束 -->

<!-- 底部开始 -->
<?php include template("content","footer"); ?>
