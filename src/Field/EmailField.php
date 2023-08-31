<?php

namespace AskMe\Field;

class EmailField extends AbstractField
{
    public function render()
    {
        $html = '<label for="' . $this->name . '" class="block font-medium mb-1">' . ucfirst($this->name) . ':</label>';
        $html .= '<input type="email" name="' . $this->name . '" placeholder="' . $this->name . '"><br>';

        return $html;
    }
}
