<?php

use Pipes\Iterator\Pipeline;
use Pipes\Iterator\Pipe\RenumberPipe;
use Pipes\Iterator\Pipe\TransformPipe;
use Pipes\Iterator\Pipe\DuplicateFilterPipe;
use Pipes\Iterator\Pipe\FilterPipe;

require __DIR__.'/../vendor/autoload.php';

$pipeline = new Pipeline(array(1, 1, 2, 2, 3, 3, 4, 4), array(
    new DuplicateFilterPipe(),
    new FilterPipe(function ($value) { return $value % 2 === 0; }),
    new TransformPipe(function ($value) { return $value / 2; }),
    new RenumberPipe()
));

print_r($pipeline->toArray());