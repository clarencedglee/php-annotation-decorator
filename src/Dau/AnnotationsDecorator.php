<?php

namespace Dau;

use Phalcon\Annotations\Adapter\Memory as MemoryAdapter;

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
class AnnotationsDecorator
{

    private $target;
    private $methods = [];

    function __construct($target)
    {
        $reader = new MemoryAdapter();
        $reflector = $reader->get($target);
        $methods = $reflector->getMethodsAnnotations();

        foreach ($methods as $methodName => $methodAnnotations) {
            $lastDecorator = null;
            $revesedAnnotations = array_reverse($methodAnnotations->getAnnotations());
            foreach ($revesedAnnotations as $annotation) {
                $name = '\\' . $annotation->getName();
                if (! class_exists($name)) {
                    continue;
                }

                if (! $lastDecorator) {
                    $lastDecorator = new $name($target, $methodName);
                    continue;
                }

                $lastDecorator = new $name($lastDecorator);
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
