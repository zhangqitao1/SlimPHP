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
use Slim\Providers\ServiceProvider;
use Slim\Providers\UserProvider;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Yaml\Yaml;

class SlimPHP extends Application
{

    use Application\SecurityTrait;
    use Application\MonologTrait;
    public $config;

    public static function app()
    {

        static $inst = null;
        if ($inst == null) {
            $inst = new static;
        }

        return $inst;
    }

    public function init()
    {

        $this->register(new ServiceControllerServiceProvider());
        $this->register(new AssetServiceProvider());
        $this->register(new TwigServiceProvider());
        $this->register(new HttpFragmentServiceProvider());
        $this->register(new SessionServiceProvider());
        $this->register(new RouterProvider());

        $this['configPath'] = PROJECT_DIR . "/config";
        $this->formatConfig(Yaml::parse(file_get_contents($this['configPath'] . "/config.yml")));

        $this['debug']        = $this['app.is_debug'];
        $this['cachePath']    = $this['app.dir.cache'];
        $this['twig.path']    = [$this['app.dir.template']];
        $this['twig.options'] = ['cache' => $this['app.dir.cache'] . '/twig'];

        //add container
        $builder = new ContainerBuilder();
        foreach ($this->config as $k => &$v) {
            $builder->setParameter($k, $v);
        }

        $loader = new YamlFileLoader($builder, new FileLocator($this['configPath']));
        $loader->load('services.yml');
        $builder->compile();
        $this['container'] = $builder;

        // add logs
        $this->register(new MonologServiceProvider(), [
            'monolog.logfile' => implode('/', [
                $this['app.dir.log'],
                date('Ymd'),
                basename($_SERVER['SCRIPT_FILENAME']),
            ]),
        ]);
    }

    public function run(Request $request = null)
    {

        $this->register(new ServiceProvider($this));
        $this->register(new SecurityServiceProvider(), [
            'security.firewalls' => [
                'admin' => [
                    'pattern' => '^/admin',
                    //'http'    => true,
                    'form'    => ['login_path' => '/login', 'check_path' => '/admin/login_check'],
                    'logout'  => ['logout_path' => '/admin/logout', 'invalidate_session' => true],
                    'users'   => new UserProvider(),
                ],
            ],
        ]);
        $this->boot();

        if (null === $request) {
            $request = Request::createFromGlobals();
        }

        $response = $this->handle($request);
        $response->send();
        $this->terminate($request, $response);
    }

    public function formatConfig($configs, $prefix = 'app')
    {

        foreach ($configs as $k => $v) {

            $key                = implode('.', [$prefix, $k]);
            $this[$key]         = $v;
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

    /**
     * @return \Twig_Environment
     */
    public function getTwig()
    {

        return $this['twig'];
    }

    /**
     * @return Logger
     */
    public function getLoger()
    {

        return $this['monolog'];
    }

    /**
     * @return TokenInterface|null
     */
    public function getToken()
    {

        return $this['security.token_storage']->getToken();
    }

    /**
     * @return UserInterface | null
     */
    public function getUser()
    {

        $user  = null;
        $token = $this->getToken();
        if (null !== $token) {
            $user = $token->getUser();
        }

        return $user;
    }
}
