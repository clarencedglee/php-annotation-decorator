<?php

namespace Dau;

class AnnotationsDecorator
{

    private $target;

    function __construct($target)
    {
        $this->target = $target;
    }

    function __call($name, $args)
    {
        return call_user_func_array( array( $this->target, $name), $args );
    }
}
