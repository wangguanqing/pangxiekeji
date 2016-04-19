<?php /* Smarty version Smarty-3.1.18, created on 2015-11-05 15:09:44
         compiled from "/Users/cgf/wwwroot/phpcmsv9/phpcms/templates/v4/content/show.tpl" */ ?>
<?php /*%%SmartyHeaderCode:672986424563b00b873a6e8-20722063%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fd975eb3e4adf0c879655b42d629c03610131d21' => 
    array (
      0 => '/Users/cgf/wwwroot/phpcmsv9/phpcms/templates/v4/content/show.tpl',
      1 => 1446634384,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '672986424563b00b873a6e8-20722063',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'data' => 0,
    'val' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_563b00b87fae57_57865187',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_563b00b87fae57_57865187')) {function content_563b00b87fae57_57865187($_smarty_tpl) {?>
<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&action=lists&catid=6&num=5&order=inputtime+DESC\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('catid'=>'6','order'=>'inputtime DESC','limit'=>'5',));$_smarty_tpl->assign('data',$data);}?>
	<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
	<a href=""><?php echo $_smarty_tpl->tpl_vars['val']->value['title'];?>
</a><br>
	<?php } ?>
<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>


<?php }} ?>
