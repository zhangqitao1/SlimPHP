<?php
/**
 * Created by PhpStorm.
 * User: Qitao
 * Date: 2017/9/8
 * Time: 14:14
 */

namespace Slim\Providers;

use Slim\SlimPHP;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class ArgumentValueResolver implements ArgumentValueResolverInterface
{

    private $app;

    public function __construct(SlimPHP $app)
    {

        $this->app = $app;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(Request $request, ArgumentMetadata $argument)
    {

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {

        foreach ($this->app['resolver_auto_injections'] as $ob) {
            if ($argument->getType() == get_class($ob)) {
                yield $ob;
            }
        }
    }
}
