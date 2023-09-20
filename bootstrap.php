<?php

/*
 * This file is part of the phpenv package.
 *
 * tekintian@gmail.com
 * http://dev.tekin.cn
 */
use tekintian\phpenv\Env as TEnv;
# make sure the ROOT_PATH is defined
if (!defined('ROOT_PATH')) {
	define('ROOT_PATH', dirname(__DIR__, 3));
}
//导入env函数
if (!function_exists('env')) {
	/**
	 * 环境变量获取助手函数
	 * 本函数兼容 laravel里面的env函数，同时比laravel里面的env函数功能更强，支持数据过滤和类型转换
	 *
	 * @author tekintian@gmail.com
	 * @param  [type] $key     [description]
	 * @param  [type] $default [description]
	 * @param  string $type    数据类型 默认 str 字符串（不进行数据过滤），其他的键根据使用filter_var对数据进行过滤和验证
	 *                         其他支持的数据类型 int 整型，float, bool, url ,ip, regexp, email, domain and string
	 * @return [type]          [description]
	 */
	function env($key, $default = null, $type = 'str') {
		return TEnv::get($key, $default, $type);
	}
}
