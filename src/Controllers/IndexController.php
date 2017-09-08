<?php
/**
 * Created by PhpStorm.
 * User: Qitao
 * Date: 2017/7/4
 * Time: 17:58
 */

namespace Slim\Controllers;

use Silex\Application;
use Slim\SlimPHP;

class IndexController
{

    /**
     * @param \Silex\Application $app
     * @return mixed
     */
    public static function indexAction(Application $app)
    {

        
        return $app['twig']->render('index.html.twig', []);
    }

    public static function loginAction(Application $app)
    {

        return $app['twig']->render('index.html.twig', []);
    }
    public static function login_check(Application $app)
    {

        return true;
    }
}
