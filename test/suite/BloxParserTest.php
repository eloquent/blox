<?php

/*
 * This file is part of the Blox package.
 *
 * Copyright © 2014 Erin Millard
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

        $blockComment = <<<'EOD'
/**
 *
 */
EOD;
        $expected = new Element\DocumentationBlock;
        $data['Empty block'] = array($expected, $blockComment);

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
 *     This is part of the previous tag.
 *
 * This is ignored.
 */
EOD;
        $tags = array(
            new Element\DocumentationTag('foo', 'bar baz'),
            new Element\DocumentationTag('foo', 'qux doom'),
            new Element\DocumentationTag('splat', "boing This is part of the previous tag."),
        );
        $summary = 'This is the summary. This is also the summary.';
        $body = <<<'EOD'
This is the body.

    This is also the body.
EOD;
        $expected = new Element\DocumentationBlock($tags, $summary, $body);
        $data['Standard block'] = array($expected, $blockComment);

        $blockComment = <<<'EOD'
/**
 * This is the summary.
 *     This is also the summary.
 *
 */
EOD;
        $summary = 'This is the summary. This is also the summary.';
        $expected = new Element\DocumentationBlock(null, $summary);
        $data['Summary only'] = array($expected, $blockComment);

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
        $expected = new Element\DocumentationBlock(null, null, $body);
        $data['Body only'] = array($expected, $blockComment);

        $blockComment = <<<'EOD'
/**
 * @foo bar baz
 * @foo qux doom
 * @splat boing
 *     This is part of the previous tag.
 *
 * This is ignored.
 */
EOD;
        $tags = array(
            new Element\DocumentationTag('foo', 'bar baz'),
            new Element\DocumentationTag('foo', 'qux doom'),
            new Element\DocumentationTag('splat', "boing This is part of the previous tag."),
        );
        $expected = new Element\DocumentationBlock($tags);
        $data['Tags only'] = array($expected, $blockComment);

        $blockComment = <<<'EOD'
/**
 * @foo
 * @bar
 */
EOD;
        $tags = array(
            new Element\DocumentationTag('foo'),
            new Element\DocumentationTag('bar'),
        );
        $expected = new Element\DocumentationBlock($tags);
        $data['Empty tags'] = array($expected, $blockComment);

        return $data;
    }

    /**
     * @dataProvider blockCommentData
     */
    public function testParseBlockComment(Element\DocumentationBlock $expected, $blockComment)
    {
        $parser = new BloxParser;

        $this->assertEquals($expected, $parser->parseBlockComment($blockComment));
    }
}
