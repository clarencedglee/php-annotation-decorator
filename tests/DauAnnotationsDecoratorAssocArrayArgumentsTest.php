<?php

namespace Test\Dau\Annotations\Decorators\ArrayArguments;

use \Dau\Annotations\Decorators\ArrayArguments;

class ArrayArgumentsTest extends \UnitTestCase
{
    public function testArgumentsArePassedCorrectly()
    {
        $a = $this->getMockBuilder('\Dau\Annotations\Decorators\AbstractAssocArrayArguments')
                   ->setConstructorArgs([new Mock(), 'testMethod'])
                   ->getMock();

        $a->method('getArguments')
           ->willReturn(['param2int' => 2, 'param1str' => 'p1']);
        
        $a->invokeArgs();
    }

    /**
     * @expectedException TypeError
     */
    public function testParamsAreTypeChecked()
    {
        $a = $this->getMockBuilder('\Dau\Annotations\Decorators\AbstractAssocArrayArguments')
                   ->setConstructorArgs([new Mock(), 'testMethod'])
                   ->getMock();

        // param2int expects int, but we'll pass it a nasty string
        $a->method('getArguments')
           ->willReturn(['param2int' => 'smelly face', 'param1str' => 'another string']);
        
        $a->invokeArgs();
    }

    /**
     * @expectedException \Dau\Annotations\Decorators\MissingArgumentsException
     */
    public function testNumParamsChecked()
    {
        $a = $this->getMockBuilder('\Dau\Annotations\Decorators\AbstractAssocArrayArguments')
                   ->setConstructorArgs([new Mock(), 'testMethod'])
                   ->getMock();

        // expects 2 params, but we'll pass it one
        $a->method('getArguments')
           ->willReturn(['param1str' => 'another string']);
        
        $a->invokeArgs();
    }


    public function testOptionalParamsOk()
    {
        $a = $this->getMockBuilder('\Dau\Annotations\Decorators\AbstractAssocArrayArguments')
                   ->setConstructorArgs([new Mock(), 'optionsMethod'])
                   ->getMock();

        // expects 1 params, the other is optional
        $a->method('getArguments')
           ->willReturn(['param1str' => 'needy']);
        
        $a->invokeArgs();
    }
}

class Mock {
    public function testMethod(string $param1str, int $param2int){
        return [$param1str, $param2int];
    }

    public function optionsMethod(string $param1str, int $param2int = 2){
        return [$param1str, $param2int];
    }
}