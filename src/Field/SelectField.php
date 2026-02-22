<?php

namespace AskMe\Field;

class SelectField extends AbstractField
{
    private $options;

    public function __construct($name, $options = [])
    {
        parent::__construct($name);
        $this->options = $options;
    }

    public function options($options)
    {
        $this->options = $options;
        return $this;
    }

    public function render()
    {
        $this->class('askme-input askme-select');
        
        $html = sprintf('<div class="%s">%s<select%s>', $this->wrapperClass, $this->renderLabel(), $this->buildAttributes());

        if (isset($this->attributes['placeholder'])) {
             $html .= '<option value="" disabled selected>' . htmlspecialchars($this->attributes['placeholder']) . '</option>';
        }

        $isAssociative = array_keys($this->options) !== range(0, count($this->options) - 1);

        foreach ($this->options as $key => $label) {
            $val = $isAssociative ? $key : $label;
            $selected = ($this->value == $val) ? ' selected' : '';
            $html .= sprintf('<option value="%s"%s>%s</option>', htmlspecialchars((string)$val), $selected, $label);
        }

        $html .= '</select>' . $this->renderHelper() . '</div>';

        return $html;
    }
}
