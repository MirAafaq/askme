<?php

namespace ArtifyForm\Field;

class FileField extends AbstractField
{
    public function render(): string
    {
        $this->class('artifyform-input artifyform-file');
        
        return sprintf(
            '<div class="%s"%s>%s<input type="file"%s>%s%s</div>',
            $this->wrapperClass,
            $this->buildWrapperAttributes(),
            $this->renderLabel(),
            $this->buildAttributes(),
            $this->renderError(),
            $this->renderHelper()
        );
    }
}
