<?php

/*
 * This file is part of the Blox package.
 *
 * Copyright © 2014 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Eloquent\Blox\BloxParser;

class FunctionalTest extends PHPUnit_Framework_TestCase
{
    public function testExample()
    {
        $this->expectOutputString(
            'This is the summary. This is also the summary.' .
            "This is the body.\n\nThis is also the body." .
            'This is some tag content.' .
            'This is some more tag content.' .
            'This is content for a different tag which spans multiple lines.'
        );

        $blockComment = <<<'EOD'
/**
 * This is the summary.
 *     This is also the summary.
 *
 * This is the body.
 *
 * This is also the body.
 *
 * @tagA This is some tag content.
 * @tagA This is some more tag content.
 * @tagB This is content for a different tag
 *     which spans multiple lines.
 *
 * This is ignored.
 */
EOD;

        $parser = new BloxParser;
        $block = $parser->parseBlockComment($blockComment);

        echo $block->summary(); // outputs 'This is the summary. This is also the summary.'
        echo $block->body();    // outputs "This is the body.\n\nThis is also the body."

        // outputs 'This is some tag content.', then 'This is some more tag content.'
        foreach ($block->tagsByName('tagA') as $tag) {
            echo $tag->content();
        }

        $splatTags = $block->tagsByName('tagB');
        echo array_pop($splatTags)->content(); // outputs 'This is content for a different tag which spans multiple lines.'
    }
}
