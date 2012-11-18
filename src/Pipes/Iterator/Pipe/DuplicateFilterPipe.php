<?php

namespace Pipes\Iterator\Pipe;

use Pipes\Iterator\Pipe;

class DuplicateFilterPipe extends FilterPipe
{
    private $history = array();

    public function __construct()
    {
        parent::__construct(array($this, 'duplicateFilter'));
    }

    public function rewind()
    {
        $this->history = array();

        parent::rewind();
    }

    protected function duplicateFilter($value)
    {
        if (in_array($value, $this->history)) {
            return false;
        }

        $this->history[] = $value;

        return true;
    }
}