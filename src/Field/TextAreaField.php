<?php
namespace AskMe\Field;

class TextAreaField extends AbstractField
{
    public function render()
    {
        return '<label for="' . $this->name . '">' . ucfirst($this->name) . ':</label>
                <textarea name="' . $this->name . '"></textarea><br>';
    }
}
