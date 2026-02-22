<?php

namespace AskMe\Field;

class FileField extends AbstractField
{
    public function render()
    {
        $this->class('askme-input askme-file');
        
        return sprintf(
            '<div class="%s">%s<input type="file"%s>%s</div>',
            $this->wrapperClass,
            $this->renderLabel(),
            $this->buildAttributes(),
            $this->renderHelper()
        );
    }
}
