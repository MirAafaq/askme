<?php

namespace AskMe\Field;

class PasswordField extends AbstractField
{
    public function render()
    {
        $this->class('askme-input');
        if (!isset($this->attributes['placeholder']) && $this->label) {
            $this->placeholder((string)$this->label);
        }

        return sprintf(
            '<div class="%s">%s<input type="password"%s>%s</div>',
            $this->wrapperClass,
            $this->renderLabel(),
            $this->buildAttributes(),
            $this->renderHelper()
        );
    }
}
