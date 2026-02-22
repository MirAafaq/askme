<?php

namespace ArtifyForm\Field;

class PasswordField extends AbstractField
{
    public function render(): string
    {
        $this->class('artifyform-input');
        if (!isset($this->attributes['placeholder']) && $this->label) {
            $this->placeholder((string)$this->label);
        }

        return sprintf(
            '<div class="%s">%s<input type="password"%s>%s%s</div>',
            $this->wrapperClass,
            $this->renderLabel(),
            $this->buildAttributes(),
            $this->renderError(),
            $this->renderHelper()
        );
    }
}
