<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template("content","header"); ?>
<link rel="stylesheet" href="<?php echo CSS_PATH;?>v4/about.css">

<div class="container clear">
    <ul class="company-title-list bottom-solid-line clear">
        <?php $n=1;if(is_array($arrchild_arr)) foreach($arrchild_arr AS $cid) { ?>
            <?php if($catid==$cid) { ?>
                <li><h1><?php echo $CATEGORYS[$cid]['catname'];?></h1></li>
            <?php } else { ?>
                <li><a href="<?php echo $CATEGORYS[$cid]['url'];?>"><?php echo $CATEGORYS[$cid]['catname'];?></a></li>
            <?php } ?>
        <?php $n++;}unset($n); ?> 
    </ul>
<div class="content about-content">
    <?php echo $content;?>
</div>
</div>


<?php include template("content","footer"); ?>


