<?php
/**
 * Created by PhpStorm.
 * User: Qitao
 * Date: 2017/8/31
 * Time: 15:58
 */

namespace Slim;

use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Slim\Providers\RouterProvider;
use Symfony\Component\Yaml\Yaml;

class SlimPHP extends Application
{

    public static function app()
    {

        static $inst = null;
        if ($inst == null) {
            $inst = new static;
        }

        return $inst;
    }

    public function init($configPath)
    {

        $this->register(new ServiceControllerServiceProvider());
        $this->register(new AssetServiceProvider());
        $this->register(new TwigServiceProvider());
        $this->register(new RouterProvider());
        $this->register(new HttpFragmentServiceProvider());

        $this['twig']         = $this->extend('twig', function ($twig) {

            // add custom globals, filters, tags, ...

            return $twig;
        });
        $this['configPath']   = $configPath;
        $config               = Yaml::parse(file_get_contents($configPath . "/config.yml"));
        $this['debug']        = isset($config['is_debug']) ?: false;
        $this['cachePath']    = $config['dir']['cache'];
        $this['dataPath']     = $config['dir']['data'];
        $this['config']       = $config;
        $this['twig.path']    = [__DIR__ . '/../templates'];
        $this['twig.options'] = ['cache' => $config['dir']['cache'] . '/twig'];
    }

    public function getConsoleApplication()
    {

        $console = new \Symfony\Component\Console\Application('SlimPHP', 'v0.1');
        return $console;
    }

    public function isDebug()
    {

        return $this->$this['debug'];
    }

}
