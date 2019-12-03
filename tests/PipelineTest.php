<?php

namespace Hawk\Tests\Minify;

use Hawk\Minify\Pipeline;
use Hawk\Tests\Minify\Handlers\TestBarHandler;
use Hawk\Tests\Minify\Handlers\TestBazHandler;
use Hawk\Tests\Minify\Handlers\TestFooHandler;
use PHPUnit\Framework\TestCase;

/**
 * Class PipelineTest
 * @package Hawk\Tests\Minify
 */
class PipelineTest extends TestCase
{
    public function testConstructor()
    {
        $pipeline = new Pipeline('Foo', 'Bar');
        $this->assertEquals('Foo', $pipeline->getValue());
        $this->assertEquals('Bar', $pipeline->getAcceptor());
    }

    public function testPipelineHandlersProperty()
    {
        $pipeline = new Pipeline('FooBarBazXyz', 'cut');
        $pipeline->through(new TestFooHandler())
            ->through(new TestBarHandler())
            ->through(new TestBazHandler());

        $pipelineHandlers = new \ReflectionProperty($pipeline, 'handlers');
        $pipelineHandlers->setAccessible(true);

        $this->assertEquals(array(
            new TestFooHandler(),
            new TestBarHandler(),
            new TestBazHandler()
        ), $pipelineHandlers->getValue($pipeline));
    }

    public function testPipelineThroughAndRun()
    {
        $pipeline = new Pipeline('FooBarBazXyz', 'cut');
        $pipeline->through(new TestFooHandler())
            ->through(new TestBarHandler())
            ->through(new TestBazHandler())
            ->run();

        $this->assertEquals('Xyz', $pipeline->getValue());
    }
}