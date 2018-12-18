<?php

$script = '/app_dev.php';


$path = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

if ($path !== '/' && file_exists($_SERVER['DOCUMENT_ROOT'] . $path)) {
	return false;
}

$_SERVER['SCRIPT_NAME'] = $script;
require_once $_SERVER['DOCUMENT_ROOT'] . $script;
