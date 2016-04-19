<?php


if (!function_exists('arr_to_html')) {

    function arr_to_html($data) {
        if (is_array($data)) {
            $str = 'array(';
            foreach ($data as $key=>$val) {
                if (is_array($val)) {
                    $str .= "'$key'=>".arr_to_html($val).",";
                } else {
                    if (strpos($val, '$')===0) {
                        $str .= "'$key'=>$val,";
                    } else {
                        $str .= "'$key'=>'".new_addslashes($val)."',";
                    }
                }
            }
            return $str.')';
        }
        return false;
    }

}
/* 
 停用了pc:block标记
 pc:content action=nav_list ... -> pc M=content action=nav_list ...
 停用了phpcms的缓存处理
 pc:json     -> pc A=json
 pc:xml      -> pc A=xml
 pc:get      -> pc A=get
 pc:block    -> XXXXXX
 pc:<module> -> pc M=<module>
*/

// 非MFE测试，走正常的程序处理
 if(!MFE_SMART_DEBUG){
    //此函数主要为，解析pc标签，并把解析结果写回smarty缓存文件对应的标签位置；
    //此编译函数有两个参数：标记参数字符串——基本上是从函数名字直到结束位置的所有内容，另一个参数是Smarty对象。该函数将返回嵌入到被编译模板中的PHP代码。
    function smarty_compiler_pc($arrParams, $smarty){
        //去除参数值中的单引号
        foreach ($arrParams as $_key => $_value) {
            $arrParams[$_key] = str_replace("'","",$_value);
        }
        $op = $arrParams["M"];//模块名
        if(!$op){
            $op = $arrParams["A"];
        }
        unset($arrParams["M"]);
        unset($arrParams["A"]); 

        // 不作为查询条件的参数列表（这些变量只用于生成PHP代码使用，并不传给tag action,因为没有意义）
        $arr = array('action','num','cache','page', 'pagesize', 'urlrule', 'return', 'start');
 
        $tools = array('json', 'xml' ,'get');
        $datas = array(); 
        $str_datas = 'op='.$op; 
        //生成后台在线编辑模版，用的tag管理标签data值 
        foreach ($arrParams as $_key => $_value) {

            if(strpos($_value, '$') === 0){ 
                $_value = '".'.$_value.'."';
            }else{
                $_value = urlencode($_value);
            }
            if($str_datas){
                $str_datas .= "&".$_key."=".$_value;
            }else{
                $str_datas .= $_key."=".$_value;
            }
        }

        foreach ($arrParams as $_key => $_value) {
            if(in_array($_key, $arr)) {
                //参数在非查询条件列表数组中，则生成变量供下面php代码使用
                $$_key = $_value;
                continue;
            }
            //组合一新数组，只保留可以作为参数，传递给tag action；
            $datas[$_key] = $_value;
        }

        $str = ''; 
        $return = isset($return) && trim($return) ? trim($return) : 'data';
        if (!isset($urlrule)) $urlrule = ''; 

        // 如果是特殊操作
        if (in_array($op,$tools)) {
            switch ($op) {
                case 'json':
                    if (isset($datas['url']) && !empty($datas['url'])) {
                        $str .= '$json = @file_get_contents(\''.$datas['url'].'\');';
                        $str .= '$'.$return.' = json_decode($json, true);';
                    }
                    break;

                case 'xml':
                    $str .= '$xml = pc_base::load_sys_class(\'xml\');';
                    $str .= '$xml_data = @file_get_contents(\''.$datas['url'].'\');';
                    $str .= '$'.$return.' = $xml->xml_unserialize($xml_data);';
                    break;

                case 'get':
                    $str .= 'pc_base::load_sys_class("get_model", "model", 0);';
                    if ($datas['dbsource']) {
                        $dbsource = getcache('dbsource', 'commons');
                        if (isset($dbsource[$datas['dbsource']])) {
                            $str .= '$get_db = new get_model('.var_export($dbsource,true).', \''.$datas['dbsource'].'\');';
                        } else {
                            return false;
                        }
                    } else {
                        $str .= '$get_db = new get_model();';
                    }
                    if (isset($start) && intval($start)) {
                        $limit = intval($start).','.$num;
                    } else {
                        $limit = $num;
                    }
                    if (isset($page)) {
                        $str .= '$pagesize = '.$num.';';
                        $str .= '$page = intval('.$page.') ? intval('.$page.') : 1;if($page<=0){$page=1;}';
                        $str .= '$offset = ($page - 1) * $pagesize;';
                        $limit = '$offset,$pagesize';
                        if ($sql = preg_replace('/select([^from].*)from/i', "SELECT COUNT(*) as count FROM ", $datas['sql'])) {
                            $str .= '$r = $get_db->sql_query("'.$sql.'");$s = $get_db->fetch_next();$pages=pages($s[\'count\'], $page, $pagesize, $urlrule);';
                        }
                    }
                    $str .= '$r = $get_db->sql_query("'.$datas['sql'].' LIMIT '.$limit.'");while(($s = $get_db->fetch_next()) != false) {$a[] = $s;}$'.$return.' = $a;unset($a);';
                    break; 
            }
        } else {
            if (!isset($action) || empty($action)) return false;
            if (module_exists($op) && file_exists(PC_PATH.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.$op.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.$op.'_tag.class.php')) {
                $str .= '$'.$op.'_tag = pc_base::load_app_class("'.$op.'_tag", "'.$op.'");if (method_exists($'.$op.'_tag, \''.$action.'\')) {'; 
                $datas['limit'] = $num;
                if (isset($page)) {
                    $str .= '$pagesize = '.$num.';';
                    $str .= '$page = intval('.$page.') ? intval('.$page.') : 1;if($page<=0){$page=1;}';
                    $str .= '$offset = ($page - 1) * $pagesize;';
                    $datas['limit'] = '$offset.",".$pagesize';
                    $datas['action'] = $action;
                    $str .= '$'.$op.'_total = $'.$op.'_tag->count('.arr_to_html($datas).');';
                    $str .= '$pages = pages($'.$op.'_total, $page, $pagesize, $urlrule);';
                }
                $str .= '$'.$return.' = $'.$op.'_tag->'.$action.'('.arr_to_html($datas).');';
                $str .= '$_smarty_tpl->assign(\''.$return.'\',$'.$return.');}';
            }
        } 
        return "<"."?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo \"<div class=\\\"admin_piao\\\" pc_action=\\\"".$op."\\\" data=\\\"".$str_datas."\\\"><a href=\\\"javascript:void(0)\\\" class=\\\"admin_piao_edit\\\">".($op=='block' ? L('block_add') : L('edit'))."</a>\";}".$str."?".">";
    }

    function smarty_compiler_pcclose(){
        return '<?php if(defined(\'IN_ADMIN\') && !defined(\'HTML\')) {echo \'</div>\';}?>';
    }
}else{
    // 如果在MFE的测试环境，输出空处理，这样与数据模型完全隔离
    function smarty_compiler_pc($P,  $smarty){
        return "<!--PC section[".$P['M']."] START -->";
    }
    function smarty_compiler_pcclose($P,  $smarty){
        return "<!--PC section[".$P['M']."] COMPLETE -->";
    }
}
