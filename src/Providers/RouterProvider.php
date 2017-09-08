<?php

namespace Slim\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\ControllerCollection;
use Silex\Api\EventListenerProviderInterface;
use Silex\Provider\Routing\RedirectableUrlMatcher;
use Silex\Provider\Routing\LazyRequestMatcher;
use Slim\SlimPHP;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Routing\Router;

/**
 * Created by PhpStorm.
 * User: Qitao
 * Date: 2017/7/7
 * Time: 18:34
 */
class RouterProvider implements ServiceProviderInterface, EventListenerProviderInterface
{

    public function register(Container $app)
    {

        $app['route_class'] = 'Silex\\Route';

        $app['route_factory'] = $app->factory(function ($app) {

            return new $app['route_class']();
        });

        $app['routes_factory'] = $app->factory(function ($app) {

            $requestContext = $app['request_context'];
            $locator        = new FileLocator([$app['configPath']]);
            $loader         = new YamlFileLoader($locator);
            $router         = new Router(
                $loader,
                'routes.yml',
                ['cache_dir' => $app['app.dir.cache']],
                $requestContext
            );
            return $router->getRouteCollection();
        });

        $app['routes']        = function ($app) {

            return $app['routes_factory'];
        };
        $app['url_generator'] = function ($app) {

            return new UrlGenerator($app['routes'], $app['request_context']);
        };

        $app['request_matcher'] = function ($app) {

            return new RedirectableUrlMatcher($app['routes'], $app['request_context']);
        };

        $app['request_context'] = function ($app) {

            $context = new RequestContext();

            $context->setHttpPort(isset($app['request.http_port']) ? $app['request.http_port'] : 80);
            $context->setHttpsPort(isset($app['request.https_port']) ? $app['request.https_port'] : 443);

            return $context;
        };

        $app['controllers'] = function ($app) {

            return $app['controllers_factory'];
        };

        $controllers_factory        = function () use ($app, &$controllers_factory) {

            return new ControllerCollection($app['route_factory'], $app['routes_factory'], $controllers_factory);
        };
        $app['controllers_factory'] = $app->factory($controllers_factory);

        $app['routing.listener'] = function ($app) {

            $urlMatcher = new LazyRequestMatcher(function () use ($app) {

                return $app['request_matcher'];
            });

            return new RouterListener($urlMatcher, $app['request_stack'], $app['request_context'], $app['logger']);
        };
    }

    public function subscribe(Container $app, EventDispatcherInterface $dispatcher)
    {

        $dispatcher->addSubscriber($app['routing.listener']);
    }
}
