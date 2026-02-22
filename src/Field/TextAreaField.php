<?php

namespace AskMe\Field;

class TextAreaField extends AbstractField
{
    public function render()
    {
        $this->class('askme-input askme-textarea');
        if (!isset($this->attributes['placeholder']) && $this->label) {
            $this->placeholder((string)$this->label);
        }
        
        $content = $this->value !== null ? htmlspecialchars((string)$this->value) : '';

        return sprintf(
            '<div class="%s">%s<textarea%s>%s</textarea>%s</div>',
            $this->wrapperClass,
            $this->renderLabel(),
            $this->buildAttributes(),
            $content,
            $this->renderHelper()
        );
    }
}
