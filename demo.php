<?php

require_once __DIR__ . '/vendor/autoload.php';

// use tekintian\phpenv\Env;

// Env::load(__DIR__, '.env');

// $app_url = env("APP_URL", "");
$app_url = env("APP_URL", "http://localhost"); // http://localhost:8080

var_dump($app_url);
