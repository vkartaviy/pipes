<?php

namespace Pipes\Test\Iterator;

use Pipes\Iterator\Pipe\FilterPipe;

class FilterPipeTest extends \PHPUnit_Framework_TestCase
{
    public function testFilter()
    {
        $pipe = new FilterPipe();
        $pipe->input(array(1, 0, 2, 0, 3, 0, 4, 0));
        $this->assertSame(array(0 => 1, 2 => 2, 4 => 3, 6 => 4), $pipe->output());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidCallback()
    {
        new FilterPipe(array());
    }
}