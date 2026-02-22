<?php

namespace AskMe\Field;

abstract class AbstractField
{
    protected $name;
    protected $label;
    protected $value;
    protected $attributes = [];
    protected $wrapperClass = 'askme-form-group';
    protected $helperText;
    
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
        $req = isset($this->attributes['required']) ? ' <span class="askme-required">*</span>' : '';
        return '<label for="' . $this->attributes['id'] . '" class="askme-label">' . $this->label . $req . '</label>';
    }

    protected function renderHelper()
    {
        if (!$this->helperText) return '';
        return '<small class="askme-helper-text">' . $this->helperText . '</small>';
    }

    abstract public function render();
}
