<?php

/*
 * This file is part of the Blox package.
 *
 * Copyright © 2012 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Blox;

use PHPUnit_Framework_TestCase;

class BloxParserTest extends PHPUnit_Framework_TestCase
{
    public function blockCommentData()
    {
        $data = array();

        // #0: Empty block
        $blockComment = <<<'EOD'
/**
 *
 */
EOD;
        $expected = new AST\DocumentationBlock;
        $data[] = array($expected, $blockComment);

        // #1: Standard block
        $blockComment = <<<'EOD'
/**
 * This is the summary.
 *     This is also the summary.
 *
 * This is the body.
 *
 *     This is also the body.
 *
 * @foo bar baz
 * @foo qux doom
 * @splat  boing
 * This is ignored.
 * This is also ignored.
 */
EOD;
        $tags = array(
            new AST\DocumentationTag('foo', 'bar baz'),
            new AST\DocumentationTag('foo', 'qux doom'),
            new AST\DocumentationTag('splat', 'boing'),
        );
        $summary = <<<'EOD'
This is the summary.
    This is also the summary.
EOD;
        $body = <<<'EOD'
This is the body.

    This is also the body.
EOD;
        $expected = new AST\DocumentationBlock($tags, $summary, $body);
        $data[] = array($expected, $blockComment);

        // #2: Summary only
        $blockComment = <<<'EOD'
/**
 * This is the summary.
 *     This is also the summary.
 *
 */
EOD;
        $summary = <<<'EOD'
This is the summary.
    This is also the summary.
EOD;
        $expected = new AST\DocumentationBlock(null, $summary);
        $data[] = array($expected, $blockComment);

        // #3: Body only
        $blockComment = <<<'EOD'
/**
 *
 * This is the body.
 *
 *     This is also the body.
 */
EOD;
        $body = <<<'EOD'
This is the body.

    This is also the body.
EOD;
        $expected = new AST\DocumentationBlock(null, null, $body);
        $data[] = array($expected, $blockComment);

        // #4: Tags only
        $blockComment = <<<'EOD'
/**
 * @foo bar baz
 * @foo qux doom
 * @splat boing
 * This is ignored.
 * This is also ignored.
 */
EOD;
        $tags = array(
            new AST\DocumentationTag('foo', 'bar baz'),
            new AST\DocumentationTag('foo', 'qux doom'),
            new AST\DocumentationTag('splat', 'boing'),
        );
        $expected = new AST\DocumentationBlock($tags);
        $data[] = array($expected, $blockComment);

        // #5: Empty tags
        $blockComment = <<<'EOD'
/**
 * @foo
 * @bar
 */
EOD;
        $tags = array(
            new AST\DocumentationTag('foo'),
            new AST\DocumentationTag('bar'),
        );
        $expected = new AST\DocumentationBlock($tags);
        $data[] = array($expected, $blockComment);

        return $data;
    }

    /**
     * @dataProvider blockCommentData
     */
    public function testParseBlockComment(AST\DocumentationBlock $expected, $blockComment)
    {
        $parser = new BloxParser;

        $this->assertEquals($expected, $parser->parseBlockComment($blockComment));
    }
}
