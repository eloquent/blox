<?php

/*
 * This file is part of the Blox package.
 *
 * Copyright © 2012 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Blox\AST;

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


        $this->assertEquals($expectedFoo, $block->tagsbyName('foo'));
        $this->assertEquals($expectedBar, $block->tagsbyName('bar'));
        $this->assertEquals($expectedBaz, $block->tagsbyName('baz'));
    }

    public function testAccept()
    {
        $visitor = Phake::mock(__NAMESPACE__.'\Visitor');
        $block = new DocumentationBlock;
        $block->accept($visitor);

        Phake::verify($visitor)->visitDocumentationBlock(
            $this->identicalTo($block)
        );
    }
}
