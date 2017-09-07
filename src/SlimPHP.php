<?php
/**
 * Created by PhpStorm.
 * User: Qitao
 * Date: 2017/8/31
 * Time: 15:58
 */

namespace Slim;

use Monolog\Logger;
use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Slim\Providers\RouterProvider;
use Slim\Providers\UserProvider;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Yaml\Yaml;

class SlimPHP extends Application
{

    use Application\SecurityTrait;
    public $config;

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
        $this->register(new SessionServiceProvider());
        $this->register(new SecurityServiceProvider(), [
            'security.firewalls' => [
                'admin' => [
                    'pattern' => '^/admin',
                    'http'    => true,
                    'users'   => new UserProvider(),
                ],
            ],
        ]);

        $this['twig'] = $this->extend('twig', function ($twig) {

            return $twig;
        });

        $this->formatConfig(Yaml::parse(file_get_contents($configPath . "/config.yml")));
        $this->config['config_path'] = $configPath;

        $this['debug']        = $this->getConfigKey('app.is_debug');
        $this['configPath']   = $configPath;
        $this['cachePath']    = $this->getConfigKey('app.dir.cache');
        $this['twig.path']    = [$this->getConfigKey('app.dir.template')];
        $this['twig.options'] = ['cache' => $this->getConfigKey('app.dir.cache') . '/twig'];

        ////add log
        //$logHander = new LogHander($this->getConfigKey('app.dir.log'));
        //$log       = new Logger('mlogging-logger');
        //$log->pushHandler($logHander);
        //$this['loger'] = $log;

        //add container
        $builder = new ContainerBuilder();
        foreach ($this->config as $k => &$v) {
            $builder->setParameter($k, $v);
        }

        $loader = new YamlFileLoader($builder, new FileLocator($configPath));
        $loader->load('services.yml');
        $builder->compile();
        $this['container'] = $builder;

        $this->register(new MonologServiceProvider(), [
            'monolog.logfile' => implode('/',
                                         [$this->getConfigKey('app.dir.log'), date('Ymd'), basename($_SERVER['SCRIPT_FILENAME'])]),
        ]);
    }

    public function getConfigKey($key)
    {

        return isset($this->config[$key]) ? $this->config[$key] : false;
    }

    public function formatConfig($configs, $prefix = 'app')
    {

        foreach ($configs as $k => $v) {

            $key                = implode('.', [$prefix, $k]);
            $this->config[$key] = $v;
            if (is_array($v)) {
                $this->formatConfig($v, $key);
            }
        }
    }

    public function getServiceId($id)
    {

        return $this['container']->get($id);
    }

    public function getParameter($id)
    {

        return $this['container']->getParameter($id);
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

    function __call($method, $params)
    {

        echo $method;
    }

    /**
     * @return Logger
     */
    public function log()
    {

        return $this['monolog'];
    }

    /**
     * @return Logger
     */
    public function getLoger()
    {

        return $this['loger'];
    }
}
