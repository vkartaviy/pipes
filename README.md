Batch
=====

The library for data flow processing.

[![Build Status](https://secure.travis-ci.org/vkartaviy/pipes.png?branch=master)](http://travis-ci.org/vkartaviy/pipes)


Here is a simple example:

```php
<?php

use Pipes\Iterator\Pipeline;
use Pipes\Iterator\Pipe\RenumberPipe;
use Pipes\Iterator\Pipe\TransformPipe;
use Pipes\Iterator\Pipe\DuplicateFilterPipe;
use Pipes\Iterator\Pipe\FilterPipe;

require __DIR__.'/../vendor/autoload.php';

$input = array(1, 1, 2, 2, 3, 3, 4, 4);

$pipeline = new Pipeline($input, array(
    new DuplicateFilterPipe(),
    new FilterPipe(function ($value) { return $value % 2 === 0; }),
    new TransformPipe(function ($value) { return $value / 2; }),
    new RenumberPipe()
));

foreach ($pipeline as $key => $value) {
    echo "{$key} => {$value}\n";
}
```