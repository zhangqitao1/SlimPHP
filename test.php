<?php
/**
 * Created by PhpStorm.
 * User: Qitao
 * Date: 2017/8/31
 * Time: 15:41
 */

use Slim\Database\Database;
use Slim\Entities\Game;
use Slim\SlimPHP; 

/** @var SlimPHP $app */
$app = require_once __DIR__ . "/bootstrap.php";
 
 
//$app->log()->addDebug('x');


//$em = Database::getEntityManager();
//$games = $em->getRepository(Game::class)->findAll();
//
//print_r($games);

$a = SlimPHP::app();
$a->getServiceId('memcached');

