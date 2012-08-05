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

use Icecave\Visita\Host;

class DocumentationTag extends Host
{
    /**
     * @param string $name
     * @param string|null $content
     */
    public function __construct($name, $content = null)
    {
        $this->name = $name;
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function content()
    {
        return $this->content;
    }

    private $name;
    private $content;
}
