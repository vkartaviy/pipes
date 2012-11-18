<?php

namespace Pipes\Iterator\Pipe;

use Pipes\Iterator\Pipe;

class TransformPipe extends Pipe
{
    /**
     * @var callable
     */
    private $callback;

    public function __construct($callback)
    {
        if (!is_callable($callback)) {
            throw new \InvalidArgumentException('Callback should be callable.');
        }

        $this->callback = $callback;
    }

    public function current()
    {
        return call_user_func($this->callback, parent::current(), parent::key());
    }
}