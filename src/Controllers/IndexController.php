<?php
/**
 * Created by PhpStorm.
 * User: Qitao
 * Date: 2017/7/4
 * Time: 17:58
 */

namespace Slim\Controllers;

use Doctrine\Common\Cache\MemcachedCache;
use Doctrine\ORM\EntityManager;
use Silex\Application;
use Slim\SlimPHP;

class IndexController
{
 
    public static function indexAction(SlimPHP $app,EntityManager $entityManager,MemcachedCache $cache)
    {

        
        return $app->getTwig()->render('index.html.twig', []);
    }

    public static function loginAction(SlimPHP $app)
    {

        return $app->getTwig()->render('index.html.twig', []);
    }
    public static function login_check(Application $app)
    {

        return true;
    }
}
