<?php

namespace ArtifyForm\Field;

use ArtifyForm\Contract\RenderableInterface;

abstract class AbstractField implements RenderableInterface
{
    protected $name;
    protected $label;
    protected $value;
    protected $attributes = [];
    protected $wrapperClass = 'artifyform-form-group';
    protected $helperText;
    protected $error;
    protected $rules = [];
    
    public function getAttributes(): array
    {
        return $this->attributes;
    }
    
    public function __construct($name)
    {
        $this->name = $name;
        $this->label = ucfirst(str_replace('_', ' ', $name));
        $this->attributes['id'] = $name;
        $this->attributes['name'] = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function label($label)
    {
        $this->label = $label;
        return $this;
    }

    public function id($id)
    {
        $this->attributes['id'] = $id;
        return $this;
    }

    public function value($value)
    {
        $this->value = $value;
        return $this;
    }

    public function required($required = true)
    {
        if ($required) {
            $this->attributes['required'] = true;
        } else {
            unset($this->attributes['required']);
        }
        return $this;
    }

    public function placeholder($placeholder)
    {
        $this->attributes['placeholder'] = $placeholder;
        return $this;
    }

    public function class($class)
    {
        if (isset($this->attributes['class'])) {
            $this->attributes['class'] .= ' ' . $class;
        } else {
            $this->attributes['class'] = $class;
        }
        return $this;
    }

    public function attr($name, $value = true)
    {
        $this->attributes[$name] = $value;
        return $this;
    }

    public function helperText($text)
    {
        $this->helperText = $text;
        return $this;
    }

    public function error($message)
    {
        $this->error = $message;
        $this->class('artifyform-field-error');
        return $this;
    }

    public function rules($rules)
    {
        if (is_string($rules)) {
            $rules = explode('|', $rules);
        }
        $this->rules = $rules;
        return $this;
    }

    public function getRules(): array
    {
        return $this->rules;
    }

    public function wrapperClass($class) {
        $this->wrapperClass = $class;
        return $this;
    }

    protected function buildAttributes()
    {
        $html = '';
        foreach ($this->attributes as $key => $value) {
            if ($value === true) {
                $html .= " {$key}";
            } elseif ($value !== false && $value !== null) {
                $html .= " {$key}=\"" . htmlspecialchars((string)$value) . "\"";
            }
        }
        return $html;
    }

    protected function renderLabel()
    {
        if (!$this->label) return '';
        $req = isset($this->attributes['required']) ? ' <span class="artifyform-required">*</span>' : '';
        return '<label for="' . $this->attributes['id'] . '" class="artifyform-label">' . $this->label . $req . '</label>';
    }

    protected function renderHelper()
    {
        if (!$this->helperText) return '';
        return '<small class="artifyform-helper-text">' . $this->helperText . '</small>';
    }

    protected function renderError()
    {
        if (!$this->error) return '';
        return '<div class="artifyform-error-text" style="color: var(--artifyform-error); font-size: 0.875rem; margin-top: 0.25rem;">' . htmlspecialchars($this->error) . '</div>';
    }

    abstract public function render(): string;
}
