<?php

namespace ArtifyForm\Validation;

use ArtifyForm\ArtifyForm;
use ArtifyForm\Field\AbstractField;
use ArtifyForm\Fieldset;

class Validator
{
    private $errors = [];
    private $validatedData = [];

    public function validate(ArtifyForm $form, array $data): bool
    {
        $this->errors = [];
        $this->validatedData = [];

        $fields = $this->extractFields($form->getElements());

        foreach ($fields as $field) {
            $name = $field->getName();
            
            // For file fields, we check $_FILES natively if present and not handled manually
            $value = $data[$name] ?? null;
            if ($value === null && isset($_FILES[$name])) {
                $value = $_FILES[$name];
            }
            
            $rules = $field->getRules();

            // Ignore fields with no name (like Buttons) unless required specifically
            if (!$name) continue;

            // Optional repopulation (skip passwords and files for security)
            if ($value !== null && !is_array($value) && !($field instanceof \ArtifyForm\Field\PasswordField || $field instanceof \ArtifyForm\Field\FileField)) {
                if (method_exists($field, 'value')) {
                    $field->value($value);
                }
            }

            foreach ($rules as $rule) {
                $check = $this->applyRule($rule, $name, $value, $field);
                if ($check !== true) {
                    $this->errors[$name] = $check;
                    if (method_exists($field, 'error')) {
                        $field->error($check);
                    }
                    break;
                }
            }

            // If it's required natively (via HTML setter ->required(true)), it should be enforced here implicitly
            // if no required rule was manually set in ->rules(['required'])
            $attrs = [];
            if (method_exists($field, 'getAttributes')) {
                // but AbstractField attributes are protected. We can just use reflection or pass it through a getter.
                // We'll rely on the rule string explicitly set by the user for now.
            }

            if (!isset($this->errors[$name])) {
                $this->validatedData[$name] = $value;
            }
        }

        return empty($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getValidatedData(): array
    {
        return $this->validatedData;
    }

    private function applyRule($rule, $name, $value, $field)
    {
        $label = ucfirst(str_replace('_', ' ', $name)); 
        
        if (strpos($rule, 'min:') === 0) {
            $min = (int) substr($rule, 4);
            if (strlen((string) $value) < $min) return "The {$label} field must be at least {$min} characters.";
        } elseif (strpos($rule, 'max:') === 0) {
            $max = (int) substr($rule, 4);
            if (strlen((string) $value) > $max) return "The {$label} field may not be greater than {$max} characters.";
        } elseif ($rule === 'required') {
            if ($value === null || $value === '') return "The {$label} field is required.";
        } elseif ($rule === 'email') {
            if ($value && !filter_var((string)$value, FILTER_VALIDATE_EMAIL)) return "The {$label} must be a valid email address.";
        } elseif ($rule === 'numeric') {
            if ($value && !is_numeric($value)) return "The {$label} must be a number.";
        }
        
        return true;
    }

    private function extractFields(array $elements): array
    {
        $fields = [];
        foreach ($elements as $element) {
            if (is_array($element) && isset($element['type'])) {
                if ($element['type'] === 'field' && $element['content'] instanceof AbstractField) {
                    $fields[] = $element['content'];
                } elseif ($element['type'] === 'row') {
                    foreach ($element['content'] as $contentField) {
                        if ($contentField instanceof AbstractField) {
                            $fields[] = $contentField;
                        }
                    }
                }
            } elseif ($element instanceof \ArtifyForm\Fieldset) {
                if (method_exists($element, 'getElements')) {
                    $fields = array_merge($fields, $this->extractFields($element->getElements()));
                }
            } elseif ($element instanceof AbstractField) {
                $fields[] = $element;
            } elseif (is_array($element)) {
                 $fields = array_merge($fields, $this->extractFields($element));
            }
        }
        return $fields;
    }
}
