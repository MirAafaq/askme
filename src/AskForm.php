<?php

namespace AskMe;

use AskMe\Field\AbstractField;

class AskForm
{
    private $fields = [];
    private $action;
    private $method;

    public function __construct($action, $method = 'POST')
    {
        $this->action = $action;
        $this->method = $method;
    }

    public function addField(AbstractField $field)
    {
        $this->fields[] = $field;
    }

    public function generateForm()
    {
        $form = '<form action="' . $this->action . '" method="' . $this->method . '">';

        foreach ($this->fields as $field) {
            $form .= $field->render();
        }

        $form .= '<button type="submit">Submit</button></form>';

        return $form;
    }
}
