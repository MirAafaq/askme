<?php

namespace AskMe\Field;

class TextField extends AbstractField
{
    public function render()
    {
        return '<label for="' . $this->name . '">' . ucfirst($this->name) . ':</label>
                <input type="text" name="' . $this->name . '" placeholder="' . $this->name . '"><br>';
    }
}
