<?php

namespace tekintian\phpenv;

use Dotenv\Dotenv;
use Dotenv\Repository\Adapter\PutenvAdapter;
use Dotenv\Repository\RepositoryBuilder;
use PhpOption\Option;
use RuntimeException;

/**
 * php env 处理工具类封装
 * tekintian@gmail.com
 * http://dev.yunnan.ws
 */
class Env {
	/**
	 * Indicates if the putenv adapter is enabled.
	 *
	 * @var bool
	 */
	protected static $putenv = true;
	/**
	 * The environment repository instance.
	 *
	 * @var \Dotenv\Repository\RepositoryInterface|null
	 */
	protected static $repository;

	/**
	 * [$dotEnv description]
	 * @var \Dotenv\Dotenv
	 */
	protected static $dotEnv = null;
	/**
	 * env文件加载入口
	 *
	 * @param  string $env_path [env文件所在的路径]
	 * @param  string $env_file [evn文件名]
	 * @return [type]  Dotenv\Dotenv对象
	 */
	public static function load($env_path = __DIR__, $env_file = '.env') {
		if (static::$dotEnv === null) {
			static::$dotEnv = Dotenv::create(
				static::getRepository(),
				$env_path,
				$env_file
			)->safeLoad();
		}
		return static::$dotEnv;
	}
	/**
	 * Enable the putenv adapter.
	 *
	 * @return void
	 */
	public static function enablePutenv() {
		static::$putenv = true;
		static::$repository = null;
	}

	/**
	 * Disable the putenv adapter.
	 *
	 * @return void
	 */
	public static function disablePutenv() {
		static::$putenv = false;
		static::$repository = null;
	}

	/**
	 * Get the environment repository instance.
	 *
	 * @return \Dotenv\Repository\RepositoryInterface
	 */
	public static function getRepository() {
		if (static::$repository === null) {
			$builder = RepositoryBuilder::createWithDefaultAdapters();

			if (static::$putenv) {
				$builder = $builder->addAdapter(PutenvAdapter::class);
			}

			static::$repository = $builder->immutable()->make();
		}

		return static::$repository;
	}

	/**
	 * Get the value of an environment variable.
	 *
	 * @param  string  $key
	 * @param  mixed  $default
	 * @return mixed
	 */
	public static function get($key, $default = null) {
		return self::getOption($key)->getOrCall(fn() => $default instanceof Closure ? $default(...$args) : $default);
	}

	/**
	 * Get the value of a required environment variable.
	 *
	 * @param  string  $key
	 * @return mixed
	 *
	 * @throws \RuntimeException
	 */
	public static function getOrFail($key) {
		return self::getOption($key)->getOrThrow(new RuntimeException("Environment variable [$key] has no value."));
	}

	/**
	 * Get the possible option for this environment variable.
	 *
	 * @param  string  $key
	 * @return \PhpOption\Option|\PhpOption\Some
	 */
	protected static function getOption($key) {
		return Option::fromValue(static::getRepository()->get($key))
			->map(function ($value) {
				switch (strtolower($value)) {
				case 'true':
				case '(true)':
					return true;
				case 'false':
				case '(false)':
					return false;
				case 'empty':
				case '(empty)':
					return '';
				case 'null':
				case '(null)':
					return;
				}
				if (preg_match('/\A([\'"])(.*)\1\z/', $value, $matches)) {
					return $matches[2];
				}
				return $value;
			});
	}
}
