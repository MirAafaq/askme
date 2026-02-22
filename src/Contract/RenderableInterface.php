<?php

namespace ArtifyForm\Contract;

interface RenderableInterface
{
    /**
     * Renders the component to an HTML string.
     *
     * @return string
     */
    public function render(): string;
}
