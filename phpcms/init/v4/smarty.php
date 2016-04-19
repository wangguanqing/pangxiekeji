<?php

/* 请定义模板目录宏 MFE_SMARTY_TEMPLATES!! */

// MFE_LOCAL : 本地调试服务器
// MFE_TEMPLATES_BASE :smarty 模板路径


if(!defined('MFE_LOCAL') && !defined('MFE_SMARTY_TEMPLATES')){
    throw new Exception("MFE_SMARTY_TEMPLATES not defined");
    exit();
}

// 插件目录
defined("MFE_BASE_PATH") || DEFINE('MFE_BASE_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);
// 模板目录 mfe工具 v4 fis本地调试使用 /templates/v4/
defined("MFE_LOCAL") || DEFINE('MFE_SMARTY_TEMPLATES', MFE_BASE_PATH."templates".DIRECTORY_SEPARATOR."v4".DIRECTORY_SEPARATOR);
// 是否启启用模板调试
defined("MFE_SMERT_DEBUG") || define("MFE_SMART_DEBUG",0);

require_once (MFE_BASE_PATH."smarty".DIRECTORY_SEPARATOR."Smarty.class.php");
$smarty = new Smarty();
$smarty->setConfigDir(MFE_BASE_PATH."config");
$smarty->setCacheDir(MFE_BASE_PATH."cache");
$smarty->setCompileDir(MFE_BASE_PATH."templates_c");
$smarty->addPluginsDir(MFE_BASE_PATH."plugin");
$smarty->setLeftDelimiter("{");
$smarty->setRightDelimiter("}");

$smarty->setTemplateDir(MFE_SMARTY_TEMPLATES);
$smarty->addConfigDir(MFE_SMARTY_TEMPLATES."fis_config");
$smarty->php_handling = SMARTY_PHP_ALLOW ;
$smarty->debugging_ctrl = 'URL';

function test_data($params,&$smarty) {
    $c1 = $params['c1'];
    $c2 = $params['c2'];
    $c3 = $params['c3'];
    $data_name = $params['return'] ? $params['return'] : 'data';
    $r = array();
    if (isset($c3)) {
        for ($i = 0; $i < $c3; $i++) {
            $r[$i] = @test_data(array(
                "c1"=>$c1,
                "c2"=>$c2
            ));
        }
    }else if(isset($c2)) {
        for ($i = 0; $i < $c2; $i++) {
            $r[$i] = @test_data(array(
                "c1"=>$c1
            ));
        }
    }else{
        for ($i = 0; $i < $c1; $i++) {
            $r[$i] = array(
                'id'=>'12321',
                'catid'=>'1223',
                'url'=>'http://www.test.mofang.com',
                'name'=>'测试名称',
                'tag'=>'标签',
                'title'=>'测试标题测试标题测试标题测试标题',
                'shortname'=>'测试短标题',
                'inputtime'=>time(),
                'icon'=>'http://sts0.mofang.com/statics/v4/content/img/jiajia_logo_3d70052.png',
                'score'=>'9.5',
                'tags'=>array('标签1','标签2','标签3','标签4','标签5','标签6'),
                'thumb'=>'http://sts0.mofang.com/statics/v4/sear/img/default_pic_cd3a56f.jpg',
                'outhorname'=>'devteam',
                'description'=>'测试描述...',
                'keywords'=>'关键字1,关键字2,关键字3',
            );
        }
    }
    if (isset($smarty)) {
        $smarty->assign($data_name,$r);
        return "";
    }else{
        return $r;
    }
}
$smarty->registerPlugin('function','test_data', test_data);

