<?php

namespace Pipes\Iterator;

abstract class Pipe implements \Iterator
{
    /**
     * The iterator which generates the input values
     *
     * @var \Traversable|Pipe
     */
    protected $input;

    /**
     * @param \Traversable|array $input
     * @return Pipe
     * @throws \InvalidArgumentException
     */
    public function input($input)
    {
        if (is_array($input)) {
            $this->input = new \ArrayIterator($input);
        } elseif ($input instanceof \Iterator) {
            $this->input = $input;
        } elseif ($input instanceof \IteratorAggregate) {
            $this->input = $input->getIterator();
        } elseif ($input instanceof \Traversable) {
            $iterator = new \IteratorIterator($input);
            $this->input = $iterator->getInnerIterator();
        } else {
            throw new \InvalidArgumentException('Invalid input type.');
        }

        return $this;
    }

    /**
     * @return array
     */
    public function output()
    {
        return iterator_to_array($this);
    }

    #region Iterator implementation

    public function current()
    {
        return $this->input->current();
    }

    public function next()
    {
        $this->input->next();
    }

    public function key()
    {
        return $this->input->key();
    }

    public function valid()
    {
        return $this->input->valid();
    }

    public function rewind()
    {
        $this->input->rewind();
    }

    #endregion
}