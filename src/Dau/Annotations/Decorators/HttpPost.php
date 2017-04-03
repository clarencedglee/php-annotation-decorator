<?php

namespace Dau\Annotations\Decorators;

use Dau\Annotations\Decorator;

class HttpPost extends AbstractAssocArrayArguments
{
    public function getArguments(): array
    {
        return $_POST;
    }
}