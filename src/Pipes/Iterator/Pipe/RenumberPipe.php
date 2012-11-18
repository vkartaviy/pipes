<?php

namespace Pipes\Iterator\Pipe;

use Pipes\Iterator\Pipe;

class RenumberPipe extends Pipe
{
    private $count = 0;

    public function key()
    {
        return $this->count++;
    }

    public function rewind()
    {
        $this->count = 0;

        parent::rewind();
    }
}