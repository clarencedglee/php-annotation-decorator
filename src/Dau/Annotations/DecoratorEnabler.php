<?php

namespace Dau\Annotations;

/**
 * Takes an object and wraps its methods
 * with decorators declared in each methods'
 * annotations.
 *
 * Annotations are applied in top down order
 *
 * Example:
 *
 * Given a method declaration:
 *
 * @Anno1
 * @Anno2
 * function MyMethod () {
 * }
 *
 * Calling MyMethod with first invoke @Anno1
 * Then @Anno2
 * And Finally MyMethod
 */
class DecoratorEnabler
{

    private $target;
    private $methods = [];

    function __construct($target, $readerType='Phalcon\Annotations\Adapter\Memory')
    {
        $reader = new $readerType();
        $reflector = $reader->get($target);
        $methods = $reflector->getMethodsAnnotations();

        foreach ($methods as $methodName => $methodAnnotations) {
            $lastDecorator = null;
            $revesedAnnotations = array_reverse($methodAnnotations->getAnnotations());
            foreach ($revesedAnnotations as $annotation) {
                if( $annotation->getName() !== 'decorate' ) {
                    continue;
                }

                $className = $annotation->getArgument(0);
                if (! class_exists($className)) {
                    continue;
                }

                if (! $lastDecorator) {
                    $lastDecorator = new $className($target, $methodName);
                    continue;
                }

                $lastDecorator = new $className($lastDecorator);
            }
            $this->methods[$methodName] = $lastDecorator;
        }
        $this->target = $target;
    }

    function __call($name, $args)
    { 
        if (! isset( $this->methods[$name])) {
            return call_user_func_array([$this->target, $name], $args);
        }
        return call_user_func_array([$this->methods[$name], 'invokeArgs'], $args);
    }
}
