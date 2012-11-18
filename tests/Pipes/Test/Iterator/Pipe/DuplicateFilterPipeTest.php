<?php

namespace Pipes\Test\Iterator;

use Pipes\Iterator\Pipe\DuplicateFilterPipe;

class DuplicateFilterPipeTest extends \PHPUnit_Framework_TestCase
{
    public function testFilter()
    {
        $pipe = new DuplicateFilterPipe();
        $pipe->input(array(1, 1, 2, 2, 3, 3, 4, 4));
        $this->assertSame(array(0 => 1, 2 => 2, 4 => 3, 6 => 4), $pipe->output());
    }
}