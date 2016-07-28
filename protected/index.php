<?php

namespace BNT;

$protected = rtrim(str_replace('\\', '/', __DIR__), '/') . '/';
$includes  = $protected . '/BNT/includes/';
$templates = $protected . '/BNT/view/';
$public    = dirname($protected) . '/htdocs/';


define('__PROTECTED__', $protected);
define('__INCLUDES__',  $includes);
define('__TEMPLATES__', $templates);
define('__PUBLIC__',    $public);


function autoload($class_name) {
  $class_file = __PROTECTED__ . str_replace('\\', '/', $class_name) . '.php';
  if (is_file($class_file)) {
    include_once $class_file;
  }
  return;
}

spl_autoload_register(__NAMESPACE__ . '\autoload');


include_once __PROTECTED__ . 'config/config.php';
include_once __INCLUDES__ . 'global_includes.php';

use BNT;

session_start();

$player = new model\Player();

if (!$player->checkLogin()) {
  new controller\Login();
  exit;
}

switch (!empty($_GET['action']) ? $_GET['action'] : 'index') {
  default:
    new controller\Index();
    break;
}
