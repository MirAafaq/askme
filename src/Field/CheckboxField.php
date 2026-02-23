<?php

namespace ArtifyForm\Field;

class CheckboxField extends AbstractField
{
    public function render(): string
    {
        $this->class('artifyform-checkbox');
        
        $checkedAttr = $this->value ? ' checked' : '';
        $req = isset($this->attributes['required']) ? ' <span class="artifyform-required">*</span>' : '';
        $labelText = $this->label ?: ucfirst($this->name);
        
        return sprintf(
            '<div class="%s artifyform-checkbox-group"%s><label class="artifyform-checkbox-label"><input type="checkbox"%s%s> <span class="artifyform-checkbox-text">%s</span>%s</label>%s%s</div>',
            $this->wrapperClass,
            $this->buildWrapperAttributes(),
            $this->buildAttributes(),
            $checkedAttr,
            $labelText,
            $req,
            $this->renderError(),
            $this->renderHelper()
        );
    }
}
