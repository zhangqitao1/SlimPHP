<?php
/**
 * Created by PhpStorm.
 * User: Qitao
 * Date: 2017/9/1
 * Time: 12:14
 */
use Doctrine\ORM\Tools\Console\ConsoleRunner; 
use Slim\Database\Database;

require_once __DIR__ . "/../bootstrap.php";

return ConsoleRunner::createHelperSet(Database::getEntityManager());
