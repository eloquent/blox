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

class BloxParser implements DocumentationBlockParser
{
    /**
     * @param string $blockComment
     *
     * @return DocumentationBlock
     */
    public function parseBlockComment($blockComment)
    {
        $blockCommentLines = $this->parseBlockCommentLines($blockComment);

        return new AST\DocumentationBlock(
            $this->parseBlockCommentTags($blockCommentLines)
            , $this->parseBlockCommentSummary($blockCommentLines)
            , $this->parseBlockCommentBody($blockCommentLines)
        );
    }

    /**
     * @param string $blockComment
     *
     * @return array
     */
    protected function parseBlockCommentLines($blockComment)
    {
        $lines = array();
        if (preg_match_all(static::PATTERN_LINES, $blockComment, $matches)) {
            $lines = $matches[1];
        }

        return $lines;
    }

    /**
     * @param array $blockCommentLines
     *
     * @return DocumentationTags
     */
    protected function parseBlockCommentTags(array &$blockCommentLines)
    {
        $tags = array();
        foreach ($blockCommentLines as $index => $blockCommentLine) {
            if (preg_match(static::PATTERN_TAG, $blockCommentLine, $matches)) {
                $tags[] = new AST\DocumentationTag(
                    $matches[1]
                    , $matches[2]
                );
            }

            if (count($tags) > 0) {
                unset($blockCommentLines[$index]);
            }
        }

        return $tags;
    }

    /**
     * @param array $blockCommentLines
     *
     * @return string|null
     */
    protected function parseBlockCommentSummary(array &$blockCommentLines)
    {
        $summary = '';
        foreach ($blockCommentLines as $index => $blockCommentLine) {
            if ('' === trim($blockCommentLine)) {
                break;
            }

            $summary .= $blockCommentLine."\n";

            unset($blockCommentLines[$index]);
        }

        if ('' === $summary) {
            $summary = null;
        } else {
            $summary = trim($summary);
        }

        return $summary;
    }

    /**
     * @param array $blockCommentLines
     *
     * @return string|null
     */
    protected function parseBlockCommentBody(array $blockCommentLines)
    {
        $body = '';
        foreach ($blockCommentLines as $index => $blockCommentLine) {
            $body .= $blockCommentLine."\n";
        }

        if ('' === $body) {
            $body = null;
        } else {
            $body = trim($body);
        }

        return $body;
    }

    const PATTERN_LINES = '~^\s*\* ?(?!/)(.*)$~m';
    const PATTERN_TAG = '~^@(\w+)\s+(.*)\s*$~';
}
