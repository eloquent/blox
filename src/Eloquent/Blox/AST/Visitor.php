<?php

/*
 * This file is part of the Blox package.
 *
 * Copyright © 2012 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

// @codeCoverageIgnoreStart

namespace Eloquent\Blox\AST;

interface Visitor
{
    /**
     * @param DocumentationBlock $documentationBlock
     *
     * @return mixed
     */
    public function visitDocumentationBlock(DocumentationBlock $documentationBlock);

    /**
     * @param DocumentationTag $documentationTag
     *
     * @return mixed
     */
    public function visitDocumentationTag(DocumentationTag $documentationTag);
}
