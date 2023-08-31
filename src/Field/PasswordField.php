<?php

namespace AskMe\Field;

class PasswordField extends AbstractField
{
    public function render()
    {
        return '<label for="' . $this->name . '">' . ucfirst($this->name) . ':</label>
                <input type="password" name="' . $this->name . '" placeholder="' . $this->name . '"><br>';
    }
}
