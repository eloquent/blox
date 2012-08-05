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

class DocumentationTagTest extends PHPUnit_Framework_TestCase
{
    public function testTag()
    {
        $name = 'foo';
        $content = 'bar';
        $tag = new DocumentationTag($name, $content);

        $this->assertSame('foo', $tag->name());
        $this->assertSame('bar', $tag->content());
    }

    public function testTagNullContent()
    {
        $name = 'foo';
        $tag = new DocumentationTag($name);

        $this->assertSame('foo', $tag->name());
        $this->assertNull($tag->content());
    }

    public function testAccept()
    {
        $tag = new DocumentationTag('foo', 'bar');
        $visitor = Phake::mock(__NAMESPACE__.'\Visitor');
        Phake::when($visitor)
            ->visitDocumentationTag(Phake::anyParameters())
            ->thenReturn('foo')
        ;

        $this->assertSame('foo', $tag->accept($visitor));
        Phake::verify($visitor)->visitDocumentationTag(
            $this->identicalTo($tag)
        );
    }
}
