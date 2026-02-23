<?php

namespace ArtifyForm\Field;

class MultiSelectField extends AbstractField
{
    private $options;

    public function __construct($name, $options = [])
    {
        parent::__construct($name);
        $this->options = $options;
        // Make name support array structure for PHP $_POST auto-parsing
        if (substr($this->attributes['name'], -2) !== '[]') {
            $this->attributes['name'] .= '[]';
        }
    }

    public function options($options)
    {
        $this->options = $options;
        return $this;
    }

    public function render(): string
    {
        $this->class('artifyform-input artifyform-select artifyform-multiselect');
        $this->attr('multiple', true);

        // Adjust ID back to cleaner version for labels without [] since ID shouldn't have them
        $cleanId = str_replace('[]', '', $this->attributes['id']);
        $this->attributes['id'] = $cleanId;
        
        // MultiSelect specific CSS inline for better sizing
        $currentStyle = $this->attributes['style'] ?? '';
        $this->attributes['style'] = $currentStyle . ' height: auto; padding: 0.5rem;';

        $html = sprintf('<div class="%s"%s>%s<select%s>', $this->wrapperClass,
            $this->buildWrapperAttributes(),
            $this->renderLabel(), $this->buildAttributes());

        $isAssociative = array_keys($this->options) !== range(0, count($this->options) - 1);
        
        // Value might be an array if re-populating old data
        $selectedValues = (array) $this->value;

        foreach ($this->options as $key => $label) {
            $val = $isAssociative ? $key : $label;
            $selected = in_array((string)$val, $selectedValues) ? ' selected' : '';
            $html .= sprintf('<option value="%s"%s>%s</option>', htmlspecialchars((string)$val), $selected, $label);
        }

        $html .= '</select>' . $this->renderError() . $this->renderHelper() . '</div>';

        return $html;
    }
}
