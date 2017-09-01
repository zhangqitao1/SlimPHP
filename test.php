<?php
/**
 * Created by PhpStorm.
 * User: Qitao
 * Date: 2017/8/31
 * Time: 15:41
 */

use Slim\Database\Database;
use Slim\Entities\Game;

$app = require_once __DIR__ . "/bootstrap.php";

$em = Database::getEntityManager();

//$game = new Game();
//$game->setCode('xx');
//$game->setGameId(1);
//
//$em->persist($game);
//$em->flush();

$games = $em->getRepository(Game::class)->findAll();
print_r($games);
echo 'x';

