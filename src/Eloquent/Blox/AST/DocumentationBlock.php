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

class DocumentationBlock
{
    /**
     * @param array<DocumentationTag>|null $tags
     * @param string|null $summary
     * @param string|null $body
     */
    public function __construct(
        array $tags = null,
        $summary = null,
        $body = null
    ) {
        if (null === $tags) {
            $tags = array();
        }

        $this->tags = $tags;
        $this->summary = $summary;
        $this->body = $body;
    }

    /**
     * @return array<DocumentationTag>
     */
    public function tags()
    {
        return $this->tags;
    }

    /**
     * @param string $name
     *
     * @return array<DocumentationTag>
     */
    public function tagsbyName($name)
    {
        $tags = array();
        foreach ($this->tags() as $tag) {
            if ($name === $tag->name()) {
                $tags[] = $tag;
            }
        }

        return $tags;
    }

    /**
     * @return string|null
     */
    public function summary()
    {
        return $this->summary;
    }

    /**
     * @return string|null
     */
    public function body()
    {
        return $this->body;
    }

    /**
     * @param Visitor $visitor
     *
     * @return mixed
     */
    public function accept(Visitor $visitor)
    {
        return $visitor->visitDocumentationBlock($this);
    }

    private $tags;
    private $summary;
    private $body;
}