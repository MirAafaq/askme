<?php

namespace ArtifyForm\Field;

class RadioField extends AbstractField
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

    public function render(): string
    {
        $html = sprintf('<div class="%s artifyform-radio-group">%s<div class="artifyform-radio-options">', $this->wrapperClass, $this->renderLabel());
        
        $this->class('artifyform-radio');

        $isAssociative = array_keys($this->options) !== range(0, count($this->options) - 1);

        foreach ($this->options as $key => $label) {
            $val = $isAssociative ? $key : $label;
            $checked = ($this->value == $val) ? ' checked' : '';
            $id = $this->name . '_' . preg_replace('/[^a-zA-Z0-9]/', '', $val);
            
            // Duplicate attributes but replace id and value
            $attrs = $this->attributes;
            $attrs['id'] = $id;
            $attrs['value'] = $val;
            
            $attrStr = '';
            foreach ($attrs as $k => $v) {
                if ($v === true) $attrStr .= " {$k}";
                elseif ($v !== false && $v !== null) $attrStr .= " {$k}=\"" . htmlspecialchars((string)$v) . "\"";
            }

            $html .= sprintf(
                '<label class="artifyform-radio-label" for="%s"><input type="radio"%s%s> <span class="artifyform-radio-text">%s</span></label>',
                $id,
                $attrStr,
                $checked,
                $label
            );
        }

        $html .= '</div>' . $this->renderError() . $this->renderHelper() . '</div>';

        return $html;
    }
}
