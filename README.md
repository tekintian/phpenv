# PHP .ENV环境变量解析工具



php环境下 evn环境解析处理工具类库, 



## 使用方法： 

### Composer 方式

1. Composer安装类库

   ~~~sh
   # 加载env类库
   composer require  tekintian/phpenv
   
   # 本类库依赖 vlucas/phpdotenv 和 phpoption/phpoption 上面的命令执行后这2个依赖会自动加载
   ~~~

   

2. 加载env环境配置文件和使用示例

   注意 当前的入口文件位于 public 下，

   ~~~php
   # 在你的项目的入口中增加
   require_once dirname(__DIR__) . '/vendor/autoload.php';
   # 定义项目根目录
   define('ROOT_PATH', dirname(__DIR__));
   
   use tekintian\phpenv\Env;
   # 如果你的.env文件不在项目根路径中，则需要手动执行Env::load加载
   # 加载环境变量配置文件 注意第一个参数为env环境配置文件的路径， 第二个参数为环境配置文件名mor  .env
   #Env::load(dirname(__DIR__), '.env');
   
   # 使用自定义助手函数获取配置
   // $app_url = env("APP_URL", "");
   
   # 直接使用Env对象获取
   $app_url = Env::get("APP_URL");
   
   var_dump($app_url);
   
   ~~~

   

3. .env 环境配置文件参考示例

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



## 演示

- 目录结构

~~~txt
├── composer.json
├── composer.lock
├── helper 帮助目录
│   └── helper.php
├── public 公共目录
│   └── index.php  入口文件
└── vendor 供应商目录
    ├── autoload.php
    ├── composer
    ├── graham-campbell
    ├── phpoption
    ├── symfony
    ├── tekintian
    └── vlucas
~~~



- public/index.php 入口文件

~~~php
<?php
  
// composer自动加载
require_once dirname(__DIR__) . '/vendor/autoload.php';
# 定义项目根目录
define('ROOT_PATH', dirname(__DIR__));

// 加载helper函数
require_once dirname(__DIR__) . '/helper/helper.php';
  
use tekintian\phpenv\Env;
  
// 加载.env配置文件
#Env::load(dirname(__DIR__), '.env');
  
// 使用助手函数获取环境配置
// $app_url = env("APP_URL", "");

// 直接使用Env对象获取配置
$app_url = Env::get("APP_URL", "未知");
  
echo sprintf("Env环境变量<br>APP_URL=%s <br>APP_NAME=%s", $app_url, env('APP_NAME'));

~~~



helper/helper.php 文件

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



- 运行演示

~~~sh
# 进入项目根目录执行 
php -S localhost:8080 -t public/

# 访问测试地址 看到输出 http://localhost 即表示成功
http://localhost:8080/index.php

#输出：
Env环境变量
APP_URL=http://localhost
APP_NAME=MyApp
~~~





env函数在配置文件中的使用示例：

~~~php
<?php

return [
    'name' => env('APP_NAME', 'MyApp'),
    'env' => env('APP_ENV', 'production'),
    'debug' => (bool) env('APP_DEBUG', false),
    'url' => env('APP_URL', 'http://localhost'),
];


~~~









