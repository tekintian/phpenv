# PHP .ENV环境变量解析工具



php环境下 evn环境解析处理工具类库, 



## 使用方法： 

1. 安装类库

   ~~~sh
   # 加载env类库
   composer require  tekintian/phpenv
   
   # 本类库依赖 vlucas/phpdotenv 和 phpoption/phpoption 上面的命令执行后这2个依赖会自动加载
   ~~~

   

2. 加载env环境配置文件和使用示例

   ~~~php
   # 在你的项目的入口中增加
   require_once dirname(__DIR__) . '/vendor/autoload.php';
   
   use tekintian\phpenv\Env;
   # 加载环境变量配置文件 注意第一个参数为env环境配置文件的路径， 第二个参数为环境配置文件名mor  .env
   Env::load(__DIR__, '.env');
   
   # 使用自定义助手函数获取配置
   // $app_url = env("APP_URL", "");
   
   # 直接使用Env对象获取
   $app_url = Env::get("APP_URL");
   
   var_dump($app_url);
   
   ~~~
   
   
   
2. .env 环境配置文件参考示例

   ~~~env
   APP_NAME=Laravel
   APP_ENV=local
   APP_DEBUG=true
   APP_URL=http://localhost
   ~~~
   
   



## env 函数封装

~~~php
<?php

use tekintian\phpenv\Env;

if (!function_exists('env')) {
	/**
	 * Gets the value of an environment variable.
	 *
	 * @param  string  $key
	 * @param  mixed  $default
	 * @return mixed
	 */
	function env($key, $default = null) {
		return Env::get($key, $default);
	}
}
~~~





## 使用示例

注意使用前需要再程序的入口中加载 env环境配置文件一次

~~~php
<?php
// composer 自动加载
require_once dirname(__DIR__) . '/vendor/autoload.php';

use tekintian\phpenv\Env;

// 加载环境配置 第一参数为环境配置文件所在路径， 第二个参数为配置环境名称
Env::load(__DIR__, '.env');

// 使用助手函数获取环境配置
// $app_url = env("APP_URL", "");

// 直接使用Env对象获取配置
$app_url = Env::get("APP_URL", "http://localhost");

// 输出 http://localhost:8080
var_dump($app_url);

~~~



env函数使用示例：

~~~php
<?php

return [
    'name' => env('APP_NAME', 'MyApp'),
    'env' => env('APP_ENV', 'production'),
    'debug' => (bool) env('APP_DEBUG', false),
    'url' => env('APP_URL', 'http://localhost'),
];


~~~









