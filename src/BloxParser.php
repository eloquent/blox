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

/**
 * A documentation parser for standard Blox-type documentation block comments.
 */
class BloxParser implements DocumentationBlockParserInterface
{
    /**
     * Parse a documentation block comment.
     *
     * @param string $blockComment The documentation block comment.
     *
     * @return DocumentationBlock The parsed documentation block object.
     */
    public function parseBlockComment($blockComment)
    {
        $blockCommentLines = $this->parseBlockCommentLines($blockComment);

        return new Element\DocumentationBlock(
            $this->parseBlockCommentTags($blockCommentLines),
            $this->parseBlockCommentSummary($blockCommentLines),
            $this->parseBlockCommentBody($blockCommentLines)
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
        if (preg_match_all('~^\s*\* ?(?!/)(.*)$~m', $blockComment, $matches)) {
            $lines = $matches[1];
        }

        return $lines;
    }

    /**
     * @param array &$blockCommentLines
     *
     * @return DocumentationTags
     */
    protected function parseBlockCommentTags(array &$blockCommentLines)
    {
        $tags = array();
        $currentTagName = $currentTagContent = null;
        foreach ($blockCommentLines as $index => $blockCommentLine) {
            $isTagLine = preg_match(
                '~^@(\w+)(?:\s+(.*))?\s*$~',
                $blockCommentLine,
                $matches
            );
            $isEmptyLine = '' === trim($blockCommentLine);

            if (
                ($isTagLine || $isEmptyLine) &&
                null !== $currentTagName
            ) {
                if ('' === $currentTagContent) {
                    $currentTagContent = null;
                }
                $tags[] = new Element\DocumentationTag(
                    $currentTagName,
                    $currentTagContent
                );

                $currentTagName = $currentTagContent = null;
            }

            if ($isTagLine) {
                $currentTagName = $matches[1];
                $currentTagContent = '';
                if (array_key_exists(2, $matches)) {
                    $currentTagContent = $matches[2];
                }
            } elseif (!$isEmptyLine) {
                $currentTagContent .= ' ' . ltrim($blockCommentLine);
            }

            if (null !== $currentTagName || count($tags) > 0) {
                unset($blockCommentLines[$index]);
            }
        }
        if (null !== $currentTagName) {
            if ('' === $currentTagContent) {
                $currentTagContent = null;
            }
            $tags[] = new Element\DocumentationTag(
                $currentTagName,
                $currentTagContent
            );
        }

        return $tags;
    }

    /**
     * @param array &$blockCommentLines
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

            if ('' !== $summary) {
                $summary .= ' ';
            }
            $summary .= ltrim($blockCommentLine);

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
            $body .= $blockCommentLine . "\n";
        }

        if ('' === $body) {
            $body = null;
        } else {
            $body = trim($body);
        }

        return $body;
    }
}
