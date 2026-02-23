<?php

namespace ArtifyForm\Field;

class TextAreaField extends AbstractField
{
    public function render(): string
    {
        $this->class('artifyform-input artifyform-textarea');
        if (!isset($this->attributes['placeholder']) && $this->label) {
            $this->placeholder((string)$this->label);
        }
        
        $content = $this->value !== null ? htmlspecialchars((string)$this->value) : '';

        return sprintf(
            '<div class="%s"%s>%s<textarea%s>%s</textarea>%s%s</div>',
            $this->wrapperClass,
            $this->buildWrapperAttributes(),
            $this->renderLabel(),
            $this->buildAttributes(),
            $content,
            $this->renderError(),
            $this->renderHelper()
        );
    }
}
