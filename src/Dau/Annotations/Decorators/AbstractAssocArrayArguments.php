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
        foreach ($params as $param) {
            $paramName  = $param->getName();
            if (!isset($incomingArgs[$paramName])) {
                if ($param->isOptional()) {
                    continue;
                }
                $originalMethod = $this->getOriginalMethod();
                throw new MissingArgumentsException(
                    'Missing argument: ' . $originalMethod->class . '::' . $originalMethod->name
                    . ' requires parameter "' . $paramName . '"'
                    . ' of type '. $param->getType()
                );
            }
            $processArgs[ $param->getPosition() ] = $incomingArgs[ $paramName ];
        }
        return $processArgs;
    }
}
