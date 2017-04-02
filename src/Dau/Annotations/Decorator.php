<?php

namespace Dau\Annotations;

abstract class Decorator {

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
    public function __construct($target, $methodname = 'invokeArgs')
    {
        $this->target = $target;
        $this->methodname = $methodname;
    }    

    /**
     * Allows the manipulation of arguments before
     * calling the method being decorated
     * 
     * @param array $args The arguments that the decorated method is being called with
     * @return array The altered argument to call the decorated method with
     */
    abstract function onInvoke(array $args): array;

    /**
     * Calls the decorated method after processing arguments
     * with $this->onInvoke()
     */
    final public function invokeArgs()
    {
        $decoratedargs = $this->onInvoke(func_get_args());
        $func = [$this->target, $this->methodname];
        return call_user_func_array($func, $decoratedargs);
    } 
}