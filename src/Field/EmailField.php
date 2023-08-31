<?php

namespace AskMe\Field;

class EmailField extends AbstractField
{
    public function render()
    {
        $html = '<label for="' . $this->name . '" class="block font-medium mb-1">' . ucfirst($this->name) . ':</label>';
        $html .= '<input type="email" name="' . $this->name . '" class="w-full p-2 border rounded focus:outline-none focus:border-blue-500"><br>';

        return $html;
    }
}
