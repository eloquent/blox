<?php

/*
 * This file is part of the Blox package.
 *
 * Copyright © 2014 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Blox\Element;

/**
 * The interface implemented by documentation visitors.
 */
interface DocumentationVisitorInterface
{
    /**
     * Visit a documentation block.
     *
     * @param DocumentationBlock $documentationBlock The block.
     *
     * @return mixed The visitor's result.
     */
    public function visitDocumentationBlock(
        DocumentationBlock $documentationBlock
    );

    /**
     * Visit a documentation tag.
     *
     * @param DocumentationTag $documentationTag
     *
     * @return mixed The visitor's result.
     */
    public function visitDocumentationTag(DocumentationTag $documentationTag);
}
