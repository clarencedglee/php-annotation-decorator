<?php

namespace Test\Dau\Annotations\Decorators\HttpPost;

use \Dau\Annotations\Decorators\HttpPost;

class ArrayArgumentsTest extends \UnitTestCase
{
    public function test()
    {
        $mock = new Mock();

        $hp = new HttpPost($mock, 'testMethod');

        $_POST = ['param2int' => 99, 'param1str' => 'hello'];
        $this->assertEquals( ['hello', 99], $hp->invokeArgs() );
    }
}

class Mock {
    public function testMethod(string $param1str, int $param2int){
        return [$param1str, $param2int];
    }
}