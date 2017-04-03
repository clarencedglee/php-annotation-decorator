<?php

namespace Test\Dau\Annotations\Decorators\ArrayArguments;

use \Dau\Annotations\Decorators\ArrayArguments;

class ArrayArgumentsTest extends \UnitTestCase
{
    public function test()
    {
        $hp = $this->getMockBuilder('\Dau\Annotations\Decorators\AbstractAssocArrayArguments')
                   ->setConstructorArgs([new Mock(), 'testMethod'])
                   ->getMock();

        $hp->method('getArguments')
           ->willReturn(['param2int' => 2, 'param1str' => 'p1']);
        
        $hp->invokeArgs();
    }
}

class Mock {
    public function testMethod(string $param1str, int $param2int){
        return [$param1str, $param2int];
    }
}