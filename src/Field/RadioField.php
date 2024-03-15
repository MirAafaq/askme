<?php

namespace AskMe\Field;

class RadioField extends AbstractField
{
    private $options;

    public function __construct($name, $options)
    {
        parent::__construct($name);
        $this->options = $options;
    }

    public function render()
    {
        $html = '<div class="mdbn"><label>' . ucfirst($this->name) . ':</label><br>';

        foreach ($this->options as $value => $label) {
            $html .= '<label for="' . $this->name . '_' . $value . '"><input type="radio" name="' . $this->name . '" value="' . $value . '"> ' . $label . '</label><br>';
        }

        $html .= '</div>';

        return $html;
    }
}
