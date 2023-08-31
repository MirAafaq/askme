<?php

namespace AskMe;

class CoreCss
{
  public function applyCss()
  {
    $css_code = <<<EOF
/* The .mdbn class is used to make text monospaced */
.mdbn {
  display: contents;
  white-space: pre-line;
}

form {
  width: fit-content;
  text-align: start;
  margin: 20px;
  font-family: calibri;
  box-shadow: 1px 10px 40px lightcoral;
  background: aliceblue;
  border-radius: 8px;
  padding: 10px;
}

input {
  margin: 8px;
  box-shadow: 1px 10px 40px lightcoral;
  border-radius: 8px;
  width: -webkit-fill-available;
  transition: border-color 0.3s;
  border: none;
  padding: 10px;
}

textarea {
  border: none;
  border-radius: 8px;
  width: -webkit-fill-available;
  margin: 4px;
  padding: 4px;
  box-shadow: 1px 10px 40px lightcoral;
}

textarea:focus {
  outline: none;
}

/* Style for the input when focused */
input:focus {
  border-color: green;
  outline: none;
}

button {
  padding: 10px;
  margin: 4px;
  font-weight: 800;
  box-shadow: 1px 10px 40px lightcoral;
  border: none;
  border-radius: 6px;
}

button:hover {
  background: #000;
  box-shadow: 1px 10px 40px #fff;
  color: #fff;
}

/* Styling for select field */
select {
  appearance: none;
  outline: none;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 8px;
  font-size: 14px;
  width: 100%;
  max-width: 300px;
  background-color: white;
}

/* Styling for radio button container */
.radio-container {
  display: flex;
  gap: 12px;
  align-items: center;
}

/* Styling for radio button */
input[type='radio'] {
  appearance: none;
  width: 20px;
  padding: 8px;
  border: 2px solid #007bff;
  margin: 0;
  cursor: pointer;
  outline: none;
}

/* Styling for selected radio button */
input[type='radio']:checked {
  background-color: #e97688;
}

/* Hide the default radio button */
input[type='radio']::before {
  content: '';
  display: inline-block;
}

/* Optional: Adding a label for radio button */
.radio-label {
  font-size: 14px;
}

/* Styling for checkbox container */

/* Styling for checkbox input */
input[type='checkbox'] {
  appearance: none;
  width: 20px;
  padding: 8px;
  border: none; /* Change to your desired color */
  border-radius: 4px;
  margin: 4px;
  cursor: pointer;
  outline: none;
}

/* Styling for selected checkbox */
input[type='checkbox']:checked {
  background: #459; /* Change to your desired color */
}

/* Hide the default checkbox */
input[type='checkbox']::before {
  content: '';
  display: inline-block;
  border-radius: 4px;
}

/* Optional: Adding a label for checkbox */
.checkbox-label {
  font-size: 14px;
}
EOF;
    return $css_code;
  }
}

?>
