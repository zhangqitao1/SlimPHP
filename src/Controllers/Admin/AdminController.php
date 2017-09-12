<?php

namespace Slim\Controllers\Admin;

use Doctrine\Common\Cache\MemcachedCache;
use Doctrine\ORM\EntityManager;
use Silex\Application;
use Slim\Entities\User;
use Slim\SlimPHP;
use Symfony\Component\HttpFoundation\Request;

/**
 * Created by PhpStorm.
 * User: Qitao
 * Date: 2017/9/7
 * Time: 17:40
 */
class AdminController
{

    public static function indexAction(SlimPHP $app, EntityManager $entityManager, MemcachedCache $cache, Request $request)
    {

        $user =new User('bbb','bbb');


        echo $app->encodePassword($user,123456);

        return $app['twig']->render('admin/index.twig', [
            'user' => $user,
        ]);
    }

}
