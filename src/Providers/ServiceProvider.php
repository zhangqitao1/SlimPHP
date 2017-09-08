<?php
/**
 * Created by PhpStorm.
 * User: Qitao
 * Date: 2017/9/8
 * Time: 14:08
 */

namespace Slim\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Slim\Database\Database;
use Slim\SlimPHP;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\HttpKernel;

class ServiceProvider implements ServiceProviderInterface
{

    private $app;

    public function __construct(SlimPHP $app)
    {

        $this->app = $app;
    }

    public function register(Container $app)
    {

        $app['resolver_auto_injections'] = function () {

            return [
                $this->app,
                Database::getEntityManager(),
                Database::getMemcache(),
            ];
        };

        $app['argument_value_resolvers'] = function () {

            $argResolver = [
                new ArgumentValueResolver($this->app),
            ];
            return array_merge($argResolver, ArgumentResolver::getDefaultArgumentValueResolvers());
        };

        $app['kernel'] = function ($app) {

            return new HttpKernel($app['dispatcher'], $app['resolver'], $app['request_stack'],
                                  $app['argument_resolver']);
        };
    }
}
