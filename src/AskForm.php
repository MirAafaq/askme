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
    public function generateCss()
    {
         $css_code = "<style>

.mdbn {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 20px;
}

form {
  width: fit-content;
  text-align: start;
  margin: 20px;
  font-family: 'calibri', sans-serif;
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
  background: #edf2f7;
  border-radius: 8px;
  padding: 20px;
}

input, textarea, select {
  margin: 8px;
  border-radius: 8px;
  width: 100%;
  padding: 12px;
  border: 1px solid #cbd5e0;
  transition: border-color 0.3s;
  background-color: #fff;
}

input:focus, textarea:focus, select:focus {
  border-color: #4a90e2;
  outline: none;
}

button {
  padding: 12px;
  margin: 8px;
  font-weight: 800;
  border: none;
  border-radius: 6px;
  background-color: #4a90e2;
  color: #fff;
  cursor: pointer;
  transition: background-color 0.3s;
}

button:hover {
  background-color: #1c6bea;
}

/* Styling for radio button container */
.radio-container {
  display: flex;
  gap: 12px;
  align-items: center;
}

/* Styling for radio button */
input[type='radio'], input[type='checkbox'] {
  appearance: none;
  width: 20px;
  height: 20px;
  padding: 8px;
  border: 2px solid #4a90e2;
  border-radius: 4px;
  margin: 0;
  cursor: pointer;
  outline: none;
}

/* Styling for selected radio button or checkbox */
input[type='radio']:checked, input[type='checkbox']:checked {
  background-color: #1c6bea;
  border-color: #1c6bea;
}

/* Optional: Adding a label for radio button or checkbox */
.radio-label, .checkbox-label {
  font-size: 14px;
  color: #2d3748;
}

</style>";
    return $css_code;


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
