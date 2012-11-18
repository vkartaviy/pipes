<?php

namespace Pipes\Test\Iterator;

use Pipes\Iterator\Pipeline;
use Pipes\Iterator\Pipe\RenumberPipe;
use Pipes\Iterator\Pipe\TransformPipe;
use Pipes\Iterator\Pipe\FilterPipe;
use Pipes\Iterator\Pipe\DuplicateFilterPipe;

class PipelineTest extends \PHPUnit_Framework_TestCase
{
    public function testFactoryMethod()
    {
        $pipeline = Pipeline::create();
        $this->assertInstanceOf('Pipes\Iterator\Pipeline', $pipeline);
    }

    public function testWithoutPipes()
    {
        $input = array(1, 2, 3);

        $pipeline = new Pipeline($input);
        $this->assertSame($input, $pipeline->output());
    }

    public function testWithPipes()
    {
        $pipeline = new Pipeline(array(1, 1, 2, 2, 3, 3, 4, 4), array(
            new DuplicateFilterPipe(),
            new FilterPipe(function ($value) { return $value % 2 === 0; }),
            new TransformPipe(function ($value) { return $value / 2; }),
            new RenumberPipe()
        ));

        $this->assertSame(array(1, 2), $pipeline->output());
    }

    public function testDifferentInputs()
    {
        $input = array(1, 2, 3);
        $pipeline = new Pipeline();

        $pipeline->input($input);
        $this->assertSame($input, $pipeline->output());

        $pipeline->input(new \ArrayIterator($input));
        $this->assertSame($input, $pipeline->output());

        $pipeline->input(new \ArrayObject($input));
        $this->assertSame($input, $pipeline->output());

        try {
            $pipeline->input(null);
            $this->fail('Should throw InvalidArgumentException');
        } catch (\InvalidArgumentException $e) {
        }
    }

    public function testDefaultBuildInPipesInterface()
    {
        $pipeline = new Pipeline(array(1, 2, 3, 4));
        $pipeline
            ->filter(function ($value) { return $value % 2 === 0; })
            ->map(function ($value) { return $value / 2; })
            ->renumber();

        $this->assertSame(array(1, 2), $pipeline->output());
    }
}