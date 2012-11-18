<?php

namespace Pipes\Iterator\Pipe;

use Pipes\Iterator\Pipe;

class FilterPipe extends Pipe
{
    /**
     * @var callable
     */
    private $callback;

    public function __construct($callback = null)
    {
        if (!$callback) {
            $callback = function ($value) {
                return (boolean) $value;
            };
        }

        if (!is_callable($callback)) {
            throw new \InvalidArgumentException('Callback should be callable.');
        }

        $this->callback = $callback;
    }

    public function rewind()
    {
        parent::rewind();

        $this->filter();
    }

    public function next()
    {
        parent::next();

        $this->filter();
    }

    protected function filter()
    {
        while (parent::valid() && !call_user_func($this->callback, parent::current(), parent::key())) {
            parent::next();
        }
    }
}