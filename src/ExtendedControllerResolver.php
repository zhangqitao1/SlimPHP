<?php
/**
 * Created by PhpStorm.
 * User: Qitao
 * Date: 2017/9/8
 * Time: 11:45
 */

namespace Slim;

use Psr\Log\LoggerInterface;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;

class ExtendedControllerResolver extends ControllerResolver
{

    protected $mappingParameters = [];

    public function __construct(LoggerInterface $logger, $autoParameters)
    {

        parent::__construct($logger);

        foreach ($autoParameters as $parameter) {
            if (!is_object($parameter)) {
                throw new \InvalidArgumentException("Auto parameter should be an object.");
            }
            $this->mappingParameters[get_class($parameter)] = $parameter;
        }
    }

    protected function doGetArguments(Request $request, $controller, array $parameters)
    {

        /** @var \ReflectionParameter $param */
        foreach ($parameters as $param) {
            if ($param->getClass()) {
                $classname = $param->getClass()->getName();

                $found = array_key_exists($classname, $this->mappingParameters) ?
                    $this->mappingParameters[$classname] :
                    null;
                if (!$found) {
                    foreach ($this->mappingParameters as $value) {
                        if ($value instanceof $classname) {
                            $found = $value;
                            break;
                        }
                    }
                }

                if ($found) {
                    $request->attributes->set($param->getName(), $found);
                }
            }
        }

        return parent::doGetArguments($request, $controller, $parameters);
    }

}
