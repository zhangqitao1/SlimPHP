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
use Symfony\Component\HttpFoundation\Request;

class IndexController
{
 
    public static function indexAction(SlimPHP $app,EntityManager $entityManager,MemcachedCache $cache)
    {
        return $app->redirect('/admin');
    }

    public static function loginAction(SlimPHP $app,Request  $request)
    {

        return $app['twig']->render('admin/login.twig', [
            'error'         => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username'),
        ]);

    } 
}
