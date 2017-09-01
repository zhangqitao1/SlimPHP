<?php
/**
 * Created by PhpStorm.
 * User: Qitao
 * Date: 2017/7/4
 * Time: 17:58
 */

namespace Slim\Controllers;
 
use Silex\Application;
use Slim\Database\Database;
use Slim\Entities\Game; 

class GameController
{

    /**
     * @param \Silex\Application $app
     * @return mixed
     */
    public static function indexAction(Application $app,$code)
    {

        $entityManager= Database::getEntityManager();
        $game =  $entityManager->find(Game::class,$code);
        print_r($game);

        return $code;
    }

    public static function helloAction(Application $app)
    {

        return 'xx';
    }
}
