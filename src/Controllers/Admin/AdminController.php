<?php

namespace Slim\Controllers\Admin;

use Silex\Application;

/**
 * Created by PhpStorm.
 * User: Qitao
 * Date: 2017/9/7
 * Time: 17:40
 */
class AdminController
{

    public static function indexAction(Application $app)
    {

        return $app['twig']->render('index.html.twig', []);
    }

}
