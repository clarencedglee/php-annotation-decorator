<?php

namespace Dau\Annotations\Decorators;

abstract class AbstractDecorator
{

    /**
     * The object being decorated
     */
    private $target;

    /**
     * The name of $target's method being decorated
     */
    private $methodname;

    /**
     * Calls the decorated method after processing arguments
     * with $this->onInvoke()
     */
    public function __construct($target, $methodName = 'invokeArgs')
    {
        $this->target = $target;
        $this->methodName = $methodName;
    }

    /**
     * Allows the manipulation of arguments before
     * calling the method being decorated
     *
     * @param array $args The arguments that the decorated method is being called with
     * @return array The altered argument to call the decorated method with
     */
    abstract protected function onInvoke(array $args): array;

    /**
     * Calls the decorated method after processing arguments
     * with $this->onInvoke()
     */
    final public function invokeArgs()
    {
        $decoratedArgs = $this->onInvoke(func_get_args());
        $func = [$this->target, $this->methodName];
        return call_user_func_array($func, $decoratedArgs);
    }

    /**
     * get a reflection of the original method
     */
    final public function getOriginalMethod(): \ReflectionMethod
    {
        if ($this->target instanceof AbstractDecorator) {
            return $this->target->getOriginalMethod();
        }
        return new \ReflectionMethod( $this->target, $this->methodName );
    }
}
