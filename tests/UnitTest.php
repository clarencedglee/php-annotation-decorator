<?php

namespace Test;

use \Dau\AnnotationsDecorator;

/**
 * An class to act as the subject of our Decorator
 */
class Subject
{
    function unannotated($a, $b, $c)
    {
        return [$a, $b, $c];
    }

    /**
     * @MyAnnotation
     */
    function annotated($a, $b, $c)
    {
        return [$a, $b, $c];
    }
}

class MyAnnotation {
    function __construct() {
        throw new MyAnnotationException('MyAnEx');
    }
}

class MyAnnotationException extends \Exception {}

/**
 * Class UnitTest
 */
class UnitTest extends \UnitTestCase
{
    public function testSubjectMethodAreExposed()
    {
        $subject = new AnnotationsDecorator(new Subject);
        $this->assertEquals(
            [3, 5, 8],
            $subject->unannotated(3, 5, 8)
        );
    }
 
    /**
     * @expectedException Exception
     * @expectedExceptionMessage MyAnEx
     */
    public function testAnnotationIsCalled()
    {
        $subject = new AnnotationsDecorator(new Subject);
    }
}
