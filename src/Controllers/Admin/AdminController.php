<?php

namespace Slim\Controllers\Admin;


use Doctrine\Common\Cache\MemcachedCache;
use Doctrine\ORM\EntityManager;
use Silex\Application;
use Slim\SlimPHP;

/**
 * Created by PhpStorm.
 * User: Qitao
 * Date: 2017/9/7
 * Time: 17:40
 */
class AdminController
{

    public static function indexAction(SlimPHP $app, EntityManager $entityManager, MemcachedCache $cache)
    {

        print_r($app->getConfigKey('app.db'));
        $user = SlimPHP::app()->getUser();
        print_r($user);

        return $app['twig']->render('index.html.twig', []);
    }

}
