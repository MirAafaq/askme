<?php

namespace AskMe\Field;

class CheckboxField extends AbstractField
{
    public function render()
    {
        return '<label for="' . $this->name . '">
                    <input type="checkbox" name="' . $this->name . '"> ' . ucfirst($this->name) . '
                </label><br>';
    }
}
