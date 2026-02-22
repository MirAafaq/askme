<?php

namespace ArtifyForm\Field;

class DateField extends AbstractField
{
    public function render(): string
    {
        $this->class('artifyform-input artifyform-date');
        
        $valueAttr = $this->value !== null ? ' value="' . htmlspecialchars((string)$this->value) . '"' : '';

        return sprintf(
            '<div class="%s">%s<input type="date"%s%s>%s%s</div>',
            $this->wrapperClass,
            $this->renderLabel(),
            $this->buildAttributes(),
            $valueAttr,
            $this->renderError(),
            $this->renderHelper()
        );
    }
}
