<?php
/**
 * trojan.php for trojan.
 * @author SamWu
 * @date 2018/1/11 17:07
 * @copyright boyaa.com
 */

define('IS_GPC', get_magic_quotes_gpc());

function gpc($key=null, $def='')
{
	static $req = array();
	if (empty($req)) {
		foreach (array('_'.'GE'.'T', '_'.'PO'.'ST') as $_req) {
			global $$_req;
			foreach ($$_req as $_key => $_value) {
				if ($_key{0} != '_') {
					if (IS_GPC) {
						$_value = s_array($_value);
					}
					$req[$_key] = $_value;
				}
			}
		}
	}
	return $key ? (isset($req[$key]) ? $req[$key] : $def) : $req;
}

// 去掉转义字符
function s_array(&$array) {
	if (is_array($array)) {
		foreach ($array as $k => $v) {
			$array[$k] = s_array($v);
		}
	} else if (is_string($array)) {
		$array = stripslashes($array);
	}
	return $array;
}

// 调试函数
function p($a) {
	echo '<pre>';
	print_r($a);
	echo '</pre>';
}

// 获取权限
function getChmod($filepath){
	return substr(base_convert(@fileperms($filepath),10,8),-4);
}

p(gpc());
