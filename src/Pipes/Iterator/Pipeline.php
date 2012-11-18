<?php

namespace Pipes\Iterator;

use Pipes\Iterator\Pipe\FilterPipe;
use Pipes\Iterator\Pipe\TransformPipe;
use Pipes\Iterator\Pipe\RenumberPipe;

class Pipeline extends Pipe
{
    /**
     * The iterator which generates the output values
     *
     * @var \Iterator
     */
    protected $output;

    /**
     * @param \Traversable|array $input
     * @param Pipe[]             $pipes
     * @return Pipeline
     */
    public static function create($input = null, array $pipes = null)
    {
        return new self($input, $pipes);
    }

    /**
     * @param \Traversable|array $input
     * @param Pipe[]             $pipes
     */
    public function __construct($input = null, array $pipes = null)
    {
        if ($input) {
            $this->input($input);
        }

        if ($pipes) {
            array_map(array($this, 'pipe'), $pipes);
        }
    }

    /**
     * @param \Traversable|array $input
     * @return Pipeline
     * @throws \InvalidArgumentException
     */
    public function input($input)
    {
        if ($this->input instanceof Pipe) {
            $this->input->input($input);
        } else {
            parent::input($input);
            $this->output = $this->input;
        }

        return $this;
    }

    /**
     * @param Pipe $pipe
     * @return Pipeline
     */
    public function pipe(Pipe $pipe)
    {
        if (!$this->input instanceof Pipe) {
            $this->input = $pipe;
        }

        if ($this->output) {
            $pipe->input($this->output);
        }

        $this->output = $pipe;

        return $this;
    }

    #region Fluent build-in pipes

    /**
     * @param callable $callback
     * @return Pipeline
     */
    public function filter($callback)
    {
        return $this->pipe(new FilterPipe($callback));
    }

    /**
     * @param callable $callback
     * @return Pipeline
     */
    public function map($callback)
    {
        return $this->pipe(new TransformPipe($callback));
    }

    /**
     * @return Pipeline
     */
    public function renumber()
    {
        return $this->pipe(new RenumberPipe());
    }

    #endregion

    #region Iterator implementation

    public function current()
    {
        return $this->output->current();
    }

    public function next()
    {
        $this->output->next();
    }

    public function key()
    {
        return $this->output->key();
    }

    public function valid()
    {
        return $this->output->valid();
    }

    public function rewind()
    {
        $this->output->rewind();
    }

    #endregion
}