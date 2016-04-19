<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?>
        <!-- 底部开始 -->
        <div class="footer">
            <div class="w-1170 clearfix">
                <div class="info">
                    <div class="logo-text-icon"></div>
                    <ul class="clearfix">
                        <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=ee8ff0ff5571da1489b61625a9bf2a1a&action=category&catid=1&num=15&siteid=1&order=listorder+ASC\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'category')) {$data = $content_tag->category(array('catid'=>'1','siteid'=>'1','order'=>'listorder ASC','limit'=>'15',));}?> 
                        <?php $n=1;if(is_array($data)) foreach($data AS $r) { ?>
                            <li><a href="<?php echo $r['url'];?>"><?php echo $r['catname'];?></a></li>
                        <?php $n++;}unset($n); ?>  
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                    </ul>
                    <p class="record">© 2016 PANGXIEKEJI.COM 螃蟹科技 京ICP备15036583号-1</p>
                </div>
                <div class="links">
                    <p>友情链接:</p>
                    <div class="links-list">
                        <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"link\" data=\"op=link&tag_md5=45032e147fac2d96222647fc61cb57e7&action=lists&typeid=0&siteid=1&linktype=0&order=desc&num=6&return=dat\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$link_tag = pc_base::load_app_class("link_tag", "link");if (method_exists($link_tag, 'lists')) {$dat = $link_tag->lists(array('typeid'=>'0','siteid'=>'1','linktype'=>'0','order'=>'desc','limit'=>'6',));}?>
                            <?php $n=1;if(is_array($dat)) foreach($dat AS $v) { ?>
                             <a href="<?php echo $v['url'];?>" target="_blank"><?php echo $v['name'];?></a>
                            <?php $n++;}unset($n); ?>
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?> 
                    </div>
                </div>
                <div class="follow">
                    <p>关注我们</p>
                    <div class="follow-list">
                        <a href="#" class="weixin-big-icon">微信<div class="<!-- weixin-f-code -->"></div></a>
                        <a href="http://weibo.com/p/1006065606718419" class="weibo-big-icon">微博</a>
                        <a href="mailto:tougao@pangxiekeji.com" class="mail-icon">站内信</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- 底部结束 -->
        <!-- 回到顶部start -->
        <div class="r-menu">
            <a href="javscript:;" class="follow"><div class="code"></div></a>
            <a href="javascript:;" class="go-top"></a>
        </div>
        <!-- 回到顶部end -->
        
    </div>
</body>
</html>