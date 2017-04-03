<?php

namespace Dau\Annotations\Decorators;

use Dau\Annotations\Decorator;

class HttpGet extends AbstractAssocArrayArguments
{
    public function getArguments(): array
    {
        return $_GET;
    }
}