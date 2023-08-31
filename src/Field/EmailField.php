<?php

namespace AskMe\Field;

class EmailField extends AbstractField
{
    public function render()
    {
        return '<label for="' . $this->name . '">' . ucfirst($this->name) . ':</label>
                <input type="email" name="' . $this->name . '"><br>';
    }
}
