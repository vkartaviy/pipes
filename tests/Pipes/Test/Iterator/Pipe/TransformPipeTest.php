<?php

namespace Pipes\Test\Iterator;

use Pipes\Iterator\Pipe\TransformPipe;

class TransformPipeTest extends \PHPUnit_Framework_TestCase
{
    public function testTransform()
    {
        $pipe = new TransformPipe(function ($value) {
            return strtoupper($value);
        });

        $pipe->input(array('one', 'two', 'three'));
        $this->assertSame(array('ONE', 'TWO', 'THREE'), $pipe->toArray());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidCallback()
    {
        new TransformPipe(array());
    }
}