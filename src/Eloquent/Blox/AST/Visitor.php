<?php // @codeCoverageIgnoreStart

/*
 * This file is part of the Blox package.
 *
 * Copyright © 2013 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Blox\AST;

use Icecave\Visita\IVisitor;

interface Visitor extends IVisitor
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
