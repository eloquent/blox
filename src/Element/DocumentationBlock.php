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
 * Represents an entire documentation block.
 */
class DocumentationBlock
{
    /**
     * Construct a new documentation block.
     *
     * @param array<DocumentationTag>|null $tags    The tags contained in the
     *     block.
     * @param string|null                  $summary The summary text.
     * @param string|null                  $body    The body text.
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
     * Get all the tags of this block.
     *
     * @return array<DocumentationTag> The tags.
     */
    public function tags()
    {
        return $this->tags;
    }

    /**
     * Get all the tags of this block with a specific tag name.
     *
     * @param string $name The tag name to search for.
     *
     * @return array<DocumentationTag> The tags with a matching tag name.
     */
    public function tagsByName($name)
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
     * Get the summary text.
     *
     * @return string|null The summary text.
     */
    public function summary()
    {
        return $this->summary;
    }

    /**
     * Get the body text.
     *
     * @return string|null The body text.
     */
    public function body()
    {
        return $this->body;
    }

    /**
     * Visit this block.
     *
     * @param DocumentationVisitorInterface $visitor The visitor to accept.
     *
     * @return mixed The visitor's result.
     */
    public function accept(DocumentationVisitorInterface $visitor)
    {
        return $visitor->visitDocumentationBlock($this);
    }

    private $tags;
    private $summary;
    private $body;
}
