<?php
/**
 * Created by PhpStorm.
 * User: Qitao
 * Date: 2017/7/4
 * Time: 17:58
 */

namespace Slim\Controllers;
 
use Doctrine\ORM\EntityManager;
use Silex\Application;
use Slim\Entities\Game;
use Slim\SlimPHP;

class GameController
{

    public static function indexAction(SlimPHP $app,EntityManager $entityManager,$code)
    {

        echo $app['debug'];
        $game =  $entityManager->find(Game::class,$code);
        print_r($game);

        return $code;
    }

    public static function helloAction(SlimPHP $app)
    {

        return 'xx';
    }
}
