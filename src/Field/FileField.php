<?php

namespace AskMe\Field;

class FileField extends AbstractField
{
    public function render()
    {
        $html = '<label for="' . $this->name . '" class="block font-medium mb-1">' . ucfirst($this->name) . ':</label>';
        $html .= '<input type="file" name="' . $this->name . '"><br>';

        return $html;
    }
}
