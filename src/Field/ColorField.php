<?php

namespace ArtifyForm\Field;

class ColorField extends AbstractField
{
    public function render(): string
    {
        $this->class('artifyform-input artifyform-color');
        
        $valueAttr = $this->value !== null ? ' value="' . htmlspecialchars((string)$this->value) . '"' : '';

        return sprintf(
            '<div class="%s">%s<input type="color"%s%s style="padding: 0; min-height: 40px; cursor: pointer;">%s%s</div>',
            $this->wrapperClass,
            $this->renderLabel(),
            $this->buildAttributes(),
            $valueAttr,
            $this->renderError(),
            $this->renderHelper()
        );
    }
}
