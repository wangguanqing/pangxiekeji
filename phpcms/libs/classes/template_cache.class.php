<?php
/**
 *  模板解析缓存
 */
final class template_cache {
	
	/**
	 * 编译模板
	 *
	 * @param $module	模块名称
	 * @param $template	模板文件名
	 * @param $istag	是否为标签模板
	 * @return unknown
	 * 简介：找到并读入模版文件，使用template_parse()函数进行标签替换，替换成原生的PHP代码，最后写入缓存文件中
	 */
	
	public function template_compile($module, $template, $style = 'default') {
		if(strpos($module, '/')=== false) {
		$tplfile = $_tpl = PC_PATH.'templates'.DIRECTORY_SEPARATOR.$style.DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.$template.'.html';
		} elseif (strpos($module, 'yp/') !== false) {
			//黄页模版处理
			$module = str_replace('/', DIRECTORY_SEPARATOR, $module);
			$tplfile = $_tpl = PC_PATH.'templates'.DIRECTORY_SEPARATOR.$style.DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.$template.'.html';
		} else {
			//其它模块
			$plugin = str_replace('plugin/', '', $module);
			$module = str_replace('/', DIRECTORY_SEPARATOR, $module);
			$tplfile = $_tpl = PC_PATH.'plugin'.DIRECTORY_SEPARATOR.$plugin.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$template.'.html';
		}
		if ($style != 'default' && !file_exists ( $tplfile )) {
			//如果样式不是默认，而且模版文件也不存在，则指定样式为default，并且模版文件去default下搜索
			$style = 'default';
			$tplfile = PC_PATH.'templates'.DIRECTORY_SEPARATOR.'default'.DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.$template.'.html';
		}
		if (! file_exists ( $tplfile )) {
			//如果模版文件还是没有找到，则返回模版文件不存在的提示 
			showmessage ( "templates".DIRECTORY_SEPARATOR.$style.DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.$template.".html is not exists!" );
		}
		$content = @file_get_contents ( $tplfile );

		$filepath = CACHE_PATH.'caches_template'.DIRECTORY_SEPARATOR.$style.DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR;
	    if(!is_dir($filepath)) {
	    	//创建缓存目录
			mkdir($filepath, 0777, true);
	    }
		$compiledtplfile = $filepath.$template.'.php';//指定缓存名称
		$content = $this->template_parse($content);//标签解析替换
		$strlen = file_put_contents ( $compiledtplfile, $content );//把替换后的内容写入缓存中
		chmod ( $compiledtplfile, 0777 );//修改缓存文件777 
		return $strlen;//返回写入的内容长度 
	}
	
	/**
	 * 更新模板缓存
	 *
	 * @param $tplfile	模板原文件路径
	 * @param $compiledtplfile	编译完成后，写入文件名
	 * @return $strlen 长度
	 */
	public function template_refresh($tplfile, $compiledtplfile) {
		$str = @file_get_contents ($tplfile);
		$str = $this->template_parse ($str);
		$strlen = file_put_contents ($compiledtplfile, $str );
		chmod ($compiledtplfile, 0777);
		return $strlen;
	}
	

	/**
	 * 解析模板
	 *
	 * @param $str	模板内容
	 * @return ture
	 */
	public function template_parse($str) {
		$str = preg_replace ( "/\{template\s+(.+)\}/", "<?php include template(\\1); ?>", $str );
		$str = preg_replace ( "/\{include\s+(.+)\}/", "<?php include \\1; ?>", $str );
		$str = preg_replace ( "/\{php\s+(.+)\}/", "<?php \\1?>", $str );
		$str = preg_replace ( "/\{if\s+(.+?)\}/", "<?php if(\\1) { ?>", $str );
		$str = preg_replace ( "/\{else\}/", "<?php } else { ?>", $str );
		$str = preg_replace ( "/\{elseif\s+(.+?)\}/", "<?php } elseif (\\1) { ?>", $str );
		$str = preg_replace ( "/\{\/if\}/", "<?php } ?>", $str );
		//for 循环
		$str = preg_replace("/\{for\s+(.+?)\}/","<?php for(\\1) { ?>",$str);
		$str = preg_replace("/\{\/for\}/","<?php } ?>",$str);
		//++ --
		$str = preg_replace("/\{\+\+(.+?)\}/","<?php ++\\1; ?>",$str);
		$str = preg_replace("/\{\-\-(.+?)\}/","<?php ++\\1; ?>",$str);
		$str = preg_replace("/\{(.+?)\+\+\}/","<?php \\1++; ?>",$str);
		$str = preg_replace("/\{(.+?)\-\-\}/","<?php \\1--; ?>",$str);
		$str = preg_replace ( "/\{loop\s+(\S+)\s+(\S+)\}/", "<?php \$n=1;if(is_array(\\1)) foreach(\\1 AS \\2) { ?>", $str );
		$str = preg_replace ( "/\{loop\s+(\S+)\s+(\S+)\s+(\S+)\}/", "<?php \$n=1; if(is_array(\\1)) foreach(\\1 AS \\2 => \\3) { ?>", $str );
		$str = preg_replace ( "/\{\/loop\}/", "<?php \$n++;}unset(\$n); ?>", $str );
		$str = preg_replace ( "/\{([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff:]*\(([^{}]*)\))\}/", "<?php echo \\1;?>", $str );
		$str = preg_replace ( "/\{\\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff:]*\(([^{}]*)\))\}/", "<?php echo \\1;?>", $str );
		$str = preg_replace ( "/\{(\\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\}/", "<?php echo \\1;?>", $str );
		$str = preg_replace("/\{(\\$[a-zA-Z0-9_\[\]\'\"\$\x7f-\xff]+)\}/es", "\$this->addquote('<?php echo \\1;?>')",$str);
		$str = preg_replace ( "/\{([A-Z_\x7f-\xff][A-Z0-9_\x7f-\xff]*)\}/s", "<?php echo \\1;?>", $str );
		//对PC标签进行替换 \s+ 1个或者多个空格； ([^}]+): 匹配不包括}号的所有字符；\}: 
		$str = preg_replace("/\{pc:(\w+)\s+([^}]+)\}/ie", "self::pc_tag('$1','$2', '$0')", $str);
		//对pc标签结尾进行替换，
		$str = preg_replace("/\{\/pc\}/ie", "self::end_pc_tag()", $str);
		$str = "<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?>" . $str;
		return $str;
	}

	/**
	 * 转义 // 为 /
	 *
	 * @param $var	转义的字符
	 * @return 转义后的字符
	 */
	public function addquote($var) {
		return str_replace ( "\\\"", "\"", preg_replace ( "/\[([a-zA-Z0-9_\-\.\x7f-\xff]+)\]/s", "['\\1']", $var ) );
	}
	
	/**
	 * 解析PC标签
	 * @param string $op 操作方式
	 * @param string $data 参数
	 * @param string $html 匹配到的所有的HTML代码
	 */
	public static function pc_tag($op, $data, $html) {
		//获取所有PC标签里的参数
		preg_match_all("/([a-z]+)\=[\"]?([^\"]+)[\"]?/i", stripslashes($data), $matches, PREG_SET_ORDER);
		//本数组中的，将不作为查询参数进行传递；
		$arr = array('action','num','cache','page', 'pagesize', 'urlrule', 'return', 'start');
		//返回的格式 
		$tools = array('json', 'xml', 'block', 'get');
		$datas = array();
		$tag_id = md5(stripslashes($html));
		//可视化条件
		$str_datas = 'op='.$op.'&tag_md5='.$tag_id;
		foreach ($matches as $v) {
			$str_datas .= $str_datas ? "&$v[1]=".($op == 'block' && strpos($v[2], '$') === 0 ? $v[2] : urlencode($v[2])) : "$v[1]=".(strpos($v[2], '$') === 0 ? $v[2] : urlencode($v[2]));
			if(in_array($v[1], $arr)) {
				//生成非查询参数，以供下面生成的PHP代码引用
				$$v[1] = $v[2];
				continue;
			}
			//整合查询需要传递的参数数组，以供pc_tag 中action 用；
			$datas[$v[1]] = $v[2];
		}
		$str = '';
		$num = isset($num) && intval($num) ? intval($num) : 20;
		$cache = isset($cache) && intval($cache) ? intval($cache) : 0;
		$return = isset($return) && trim($return) ? trim($return) : 'data';
		if (!isset($urlrule)) $urlrule = '';
		if (!empty($cache) && !isset($page)) {
			$str .= '$tag_cache_name = md5(implode(\'&\','.self::arr_to_html($datas).').\''.$tag_id.'\');if(!$'.$return.' = tpl_cache($tag_cache_name,'.$cache.')){';
		}
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
						$num = isset($num) && intval($num) > 0 ? intval($num) : 20;
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
							$sql = 'SELECT COUNT(*) as count FROM ('.$datas['sql'].') T';
							$str .= '$r = $get_db->sql_query("'.$sql.'");$s = $get_db->fetch_next();$pages=pages($s[\'count\'], $page, $pagesize, $urlrule);';
						}
						
						
						$str .= '$r = $get_db->sql_query("'.$datas['sql'].' LIMIT '.$limit.'");while(($s = $get_db->fetch_next()) != false) {$a[] = $s;}$'.$return.' = $a;unset($a);';
					break;
					
				case 'block':
					$str .= '$block_tag = pc_base::load_app_class(\'block_tag\', \'block\');';
					$str .= 'echo $block_tag->pc_tag('.self::arr_to_html($datas).');';
					break;
			}
		} else {
			//没有action，直接返回错误 
			if (!isset($action) || empty($action)) return false;
			if (module_exists($op) && file_exists(PC_PATH.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.$op.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.$op.'_tag.class.php')) {
				//模块存在，并且model_tag.class.php 文件也存在，组合生成纯php代码，以便最后替换为页面中的pc标签；
				//加载当前模块的tag.class ；
				$str .= '$'.$op.'_tag = pc_base::load_app_class("'.$op.'_tag", "'.$op.'");if (method_exists($'.$op.'_tag, \''.$action.'\')) {';	
				if (isset($start) && intval($start)) {
					$datas['limit'] = intval($start).','.$num;
				} else {
					$datas['limit'] = $num;
				}
				if (isset($page)) {
					//有分页变量
					$str .= '$pagesize = '.$num.';';
					$str .= '$page = intval('.$page.') ? intval('.$page.') : 1;if($page<=0){$page=1;}';
					$str .= '$offset = ($page - 1) * $pagesize;';
					$datas['limit'] = '$offset.",".$pagesize';
					$datas['action'] = $action;
					$str .= '$'.$op.'_total = $'.$op.'_tag->count('.self::arr_to_html($datas).');';
					$str .= '$pages = pages($'.$op.'_total, $page, $pagesize, $urlrule);';
				}
				$str .= '$'.$return.' = $'.$op.'_tag->'.$action.'('.self::arr_to_html($datas).');';
				$str .= '}';
			} 
		}
		if (!empty($cache) && !isset($page)) {
			$str .= 'if(!empty($'.$return.')){setcache($tag_cache_name, $'.$return.', \'tpl_data\');}';
			$str .= '}';
		}
		return "<"."?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo \"<div class=\\\"admin_piao\\\" pc_action=\\\"".$op."\\\" data=\\\"".$str_datas."\\\"><a href=\\\"javascript:void(0)\\\" class=\\\"admin_piao_edit\\\">".($op=='block' ? L('block_add') : L('edit'))."</a>\";}".$str."?".">";
		
	}
	
	/**
	 * PC标签结束
	 * 说明：主要替换为对pc开始标签处理时生成的DIV进行闭合
	 */
	static private function end_pc_tag() {
		return '<?php if(defined(\'IN_ADMIN\') && !defined(\'HTML\')) {echo \'</div>\';}?>';
	}
	
	/**
	 * 转换数据为HTML代码
	 * @param array $data 数组
	 */
	private static function arr_to_html($data) {
		if (is_array($data)) {
			$str = 'array(';
			foreach ($data as $key=>$val) {
				if (is_array($val)) {
					$str .= "'$key'=>".self::arr_to_html($val).",";
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
?>