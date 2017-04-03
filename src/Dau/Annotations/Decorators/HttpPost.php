<?php

namespace Dau\Annotations\Decorators;

use Dau\Annotations\Decorator;

class HttpPost extends Decorator
{
    public function onInvoke(array $args): array
    {
        return $args;
    }
}