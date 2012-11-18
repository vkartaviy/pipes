<?php

namespace Pipes\Test\Iterator;

use Pipes\Iterator\Pipe\RenumberPipe;

class RenumberPipeTest extends \PHPUnit_Framework_TestCase
{
    public function testRenumber()
    {
        $pipe = new RenumberPipe();
        $pipe->input(array(1 => 1, 2, 3, 4));
        $this->assertSame(array(1, 2, 3, 4), $pipe->toArray());
    }

    public function testCounterReset()
    {
        $pipe = new RenumberPipe();
        $pipe->input(array(1 => 1, 2, 3, 4));
        $this->assertSame(array(1, 2, 3, 4), $pipe->toArray());
        $this->assertSame(array(1, 2, 3, 4), $pipe->toArray());
    }
}