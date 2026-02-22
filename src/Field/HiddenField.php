<?php

namespace ArtifyForm\Field;

class HiddenField extends AbstractField
{
    public function render(): string
    {
        $valueAttr = $this->value !== null ? ' value="' . htmlspecialchars((string)$this->value) . '"' : '';

        return sprintf(
            '<input type="hidden"%s%s>',
            $this->buildAttributes(),
            $valueAttr
        );
    }
}
