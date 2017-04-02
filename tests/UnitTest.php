<?php

namespace Test;

use \Dau\AnnotationsDecorator;

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

    public function testOneAnnotationApplied()
    {
        $subject = new AnnotationsDecorator(new SubjectWithMakeFirstParamZero);
        $this->assertEquals(
            [0, 13, 17],
            $subject->zero(11, 13, 17)
        );
    }
    
    public function testManyAnnotationsAppliedInOrder()
    {
        $subject = new AnnotationsDecorator(new SubjectWithMakeFirstParamZero);
        $this->assertEquals(
            [9, 13, 17],
            $subject->zeroNine(11, 13, 17)
        );
    }
}

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
     * This should not cause an error
     * even though there is no class
     * Test\NonExistentAnnotation
     *
     * @Test\NonExistentAnnotation
     */
    function missing()
    {
    }
}

class SubjectWithMakeFirstParamZero
{

    /**
     * @Test\MakeFirstArgZero
     */
    function zero($a, $b, $c)
    {
        return [$a, $b, $c];
    }

    /**
     * @Test\MakeFirstArgZero
     * @Test\MakeZerosNines
     */
    function zeroNine($a, $b, $c)
    {
        return [$a, $b, $c];
    }
}

class makeFirstArgZero extends \Dau\Annotation
{
    function onInvoke($args)
    {
        $args[0] = 0;
        return $args;
    }
}

class makeZerosNines extends \Dau\Annotation
{
    function onInvoke($args)
    {
        $out = [];
        foreach( $args as $key => $arg ) {
            if( $arg === 0 ) {
                $out[$key] = 9;
            }else {
                $out[$key] = $arg;
            }
        }
        return $out;
    }
}
