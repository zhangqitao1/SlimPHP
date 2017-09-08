<?php
/**
 * Created by PhpStorm.
 * User: Qitao
 * Date: 2017/8/31
 * Time: 15:39
 */

use Slim\SlimPHP;

if (!defined('PROJECT_DIR')) {
    define('PROJECT_DIR', __DIR__);
}
require_once __DIR__ . "/vendor/autoload.php";

$app = SlimPHP::app();
$app->init();

return $app;
