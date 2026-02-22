<?php

namespace AskMe\Field;

class EmailField extends AbstractField
{
    public function render()
    {
        $this->class('askme-input');
        if (!isset($this->attributes['placeholder']) && $this->label) {
            $this->placeholder((string)$this->label);
        }
        
        $valueAttr = $this->value !== null ? ' value="' . htmlspecialchars((string)$this->value) . '"' : '';

        return sprintf(
            '<div class="%s">%s<input type="email"%s%s>%s</div>',
            $this->wrapperClass,
            $this->renderLabel(),
            $this->buildAttributes(),
            $valueAttr,
            $this->renderHelper()
        );
    }
}
