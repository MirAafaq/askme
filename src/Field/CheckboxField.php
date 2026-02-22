<?php

namespace AskMe\Field;

class CheckboxField extends AbstractField
{
    public function render()
    {
        $this->class('askme-checkbox');
        
        $checkedAttr = $this->value ? ' checked' : '';
        $req = isset($this->attributes['required']) ? ' <span class="askme-required">*</span>' : '';
        $labelText = $this->label ?: ucfirst($this->name);
        
        return sprintf(
            '<div class="%s askme-checkbox-group"><label class="askme-checkbox-label"><input type="checkbox"%s%s> <span class="askme-checkbox-text">%s</span>%s</label>%s</div>',
            $this->wrapperClass,
            $this->buildAttributes(),
            $checkedAttr,
            $labelText,
            $req,
            $this->renderHelper()
        );
    }
}
