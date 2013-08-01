<?php

/*
 * This file is part of the Blox package.
 *
 * Copyright © 2013 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Blox\Element;

use Phake;
use PHPUnit_Framework_TestCase;

class DocumentationBlockTest extends PHPUnit_Framework_TestCase
{
    public function testBlock()
    {
        $block = new DocumentationBlock;

        $this->assertSame(array(), $block->tags());
        $this->assertNull($block->summary());
        $this->assertNull($block->body());


        $tags = array(
            new DocumentationTag('foo', 'bar'),
            new DocumentationTag('baz', 'qux'),
        );
        $summary = 'foo';
        $body = 'bar';
        $block = new DocumentationBlock($tags, $summary, $body);

        $this->assertSame($tags, $block->tags());
        $this->assertSame('foo', $block->summary());
        $this->assertSame('bar', $block->body());
    }

    public function testTagsByName()
    {
        $tagFooA = new DocumentationTag('foo', 'fooA');
        $tagFooB = new DocumentationTag('foo', 'fooB');
        $tagBarA = new DocumentationTag('bar', 'barA');
        $tagBarB = new DocumentationTag('bar', 'barB');
        $tags = array(
            $tagFooA,
            $tagFooB,
            $tagBarA,
            $tagBarB,
        );
        $block = new DocumentationBlock($tags);

        $expectedFoo = array(
            $tagFooA,
            $tagFooB,
        );
        $expectedBar = array(
            $tagBarA,
            $tagBarB,
        );
        $expectedBaz = array();


        $this->assertEquals($expectedFoo, $block->tagsByName('foo'));
        $this->assertEquals($expectedBar, $block->tagsByName('bar'));
        $this->assertEquals($expectedBaz, $block->tagsByName('baz'));
    }

    public function testAccept()
    {
        $visitor = Phake::mock(__NAMESPACE__.'\DocumentationVisitorInterface');
        Phake::when($visitor)
            ->visitDocumentationBlock(Phake::anyParameters())
            ->thenReturn('foo')
        ;
        $host = new DocumentationBlock;

        $this->assertSame('foo', $host->accept($visitor));
        Phake::verify($visitor)->visitDocumentationBlock(
            $this->identicalTo($host)
        );
    }
}
