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
 * The interface implemented by documentation parsers.
 */
interface DocumentationBlockParserInterface
{
    /**
     * Parse a documentation block comment.
     *
     * @param string $blockComment The documentation block comment.
     *
     * @return DocumentationBlock The parsed documentation block object.
     */
    public function parseBlockComment($blockComment);
}
