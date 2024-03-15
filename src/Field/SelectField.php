<?php

namespace AskMe\Field;

class SelectField extends AbstractField
{
    private $options;

    public function __construct($name, $options)
    {
        parent::__construct($name);
        $this->options = $options;
    }

    public function render()
    {
        $html = '<label for="' . $this->name . '">' . ucfirst($this->name) . ':</label><select name="' . $this->name . '">';

        foreach ($this->options as $value => $label) {
            $html .= '<option value="' . $value . '">' . $label . '</option>';
        }

        $html .= '</select><br>';

        return $html;
    }
}
