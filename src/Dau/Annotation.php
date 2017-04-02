<?php

namespace Dau;

class Annotation {

    private $target;
    private $methodname;

    function __construct($target, $methodname = 'invokeArgs')
    {
        $this->target = $target;
        $this->methodname = $methodname;
    }    

    function onInvoke($args)
    {
        return $args;
    }

    function invokeArgs()
    {
        $decoratedargs = $this->onInvoke(func_get_args());
        $func = [$this->target, $this->methodname];
        return call_user_func_array($func, $decoratedargs);
    } 
}