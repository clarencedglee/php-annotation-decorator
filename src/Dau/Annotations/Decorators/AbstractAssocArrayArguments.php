<?php

namespace Dau\Annotations\Decorators;

use Dau\Annotations\Decorators\AbstractDecorator;

abstract class AbstractAssocArrayArguments extends AbstractDecorator
{
    abstract public function getArguments(): array;
    
    protected function onInvoke(array $args): array
    {
        $incomingArgs = $this->getArguments();
        $params   = $this->getOriginalMethod()->getParameters();
        $processArgs = [];
        foreach( $params as $param ) {
            $paramIndex = $param->getPosition();
            $paramName  = $param->getName();
            $processArgs[ $paramIndex ] = $incomingArgs[ $paramName ];
        }
        return $processArgs;
    }
}