<?php

namespace Test\Dau\Annotations\Decorators;

class DecoratorTest extends \UnitTestCase
{
    public function testInvokesOriginalMethod()
    {
        $original = $this->getMockBuilder('\Test\Dau\Annotations\Decorators\Mock')->getMock();

        $hp = $this->getMockBuilder('\Dau\Annotations\Decorators\Decorator')
                   ->setConstructorArgs([$original, 'testMethod'])
                   ->getMock();

        // Mock onInvoke() to pass through the arguments unchanged
        $hp->method('onInvoke')
           ->will($this->returnCallback(function($args)
           {
               return $args[0];
           }));

        $original->expects($this->once())
                 ->method('testMethod');

        $hp->invokeArgs(['a string']);
    }

    public function testCanReferenceOriginalMethod()
    {
        $original = $this->getMockBuilder('\Test\Dau\Annotations\Decorators\Mock')->getMock();

        // decorate
        $hp1 = $this->getMockBuilder('\Dau\Annotations\Decorators\Decorator')
                   ->setConstructorArgs([$original, 'testMethod'])
                   ->getMock();

        // decorate again
        $hp2 = $this->getMockBuilder('\Dau\Annotations\Decorators\Decorator')
                   ->setConstructorArgs([$hp1])
                   ->getMock();

        // decorate it like a pass-the-parcel
        $hp3 = $this->getMockBuilder('\Dau\Annotations\Decorators\Decorator')
                   ->setConstructorArgs([$hp2])
                   ->getMock();

        $originalMethod = $hp3->getOriginalMethod();
        $this->assertEquals('testMethod', $originalMethod->getName());
        $this->assertEquals(1, count($originalMethod->getParameters()));
        $this->assertEquals('param1', $originalMethod->getParameters()[0]->getName());
        $this->assertEquals('string', $originalMethod->getParameters()[0]->getType()->__toString());
    }
}

class Mock
{
    public function testMethod(string $param1)
    {
    }
}
