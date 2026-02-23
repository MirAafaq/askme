<?php

namespace ArtifyForm\Field;

class NumberField extends AbstractField
{
    public function render(): string
    {
        $this->class('artifyform-input artifyform-number');
        if (!isset($this->attributes['placeholder']) && $this->label) {
            $this->placeholder((string)$this->label);
        }
        
        $valueAttr = $this->value !== null ? ' value="' . htmlspecialchars((string)$this->value) . '"' : '';

        return sprintf(
            '<div class="%s"%s>%s<input type="number"%s%s>%s%s</div>',
            $this->wrapperClass,
            $this->buildWrapperAttributes(),
            $this->renderLabel(),
            $this->buildAttributes(),
            $valueAttr,
            $this->renderError(),
            $this->renderHelper()
        );
    }
}
