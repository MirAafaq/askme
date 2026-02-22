<?php

namespace AskMe;

use AskMe\Field\AbstractField;
use AskMe\Field\FileField;

class AskForm
{
    private $action;
    private $method;
    private $enctype = '';
    private $elements = [];
    private $submitButtonText = 'Submit';
    private $submitButtonClass = 'askme-btn askme-btn-primary';
    private $formId = 'askme-form';
    private $formClass = 'askme-container';

    public function __construct($action = '', $method = 'POST')
    {
        $this->action = $action;
        $this->method = $method;
    }

    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    public function setEnctype($enctype)
    {
        $this->enctype = $enctype;
        return $this;
    }

    public function setFormId($id)
    {
        $this->formId = $id;
        return $this;
    }

    public function setFormClass($class)
    {
        $this->formClass = $class;
        return $this;
    }

    public function addField(AbstractField $field)
    {
        $this->elements[] = ['type' => 'field', 'content' => $field];
        if ($field instanceof FileField && empty($this->enctype)) {
            $this->enctype = 'multipart/form-data';
        }
        return $this;
    }

    public function addRow(array $fields)
    {
        $rowFields = [];
        foreach ($fields as $field) {
            if ($field instanceof FileField && empty($this->enctype)) {
                $this->enctype = 'multipart/form-data';
            }
            $rowFields[] = $field;
        }
        $this->elements[] = ['type' => 'row', 'content' => $rowFields];
        return $this;
    }

    public function addHtml($html)
    {
        $this->elements[] = ['type' => 'html', 'content' => $html];
        return $this;
    }

    public function generateCss()
    {
        return '<style>
            :root {
                --askme-primary: #4f46e5;
                --askme-primary-hover: #4338ca;
                --askme-bg: #ffffff;
                --askme-text: #111827;
                --askme-border: #d1d5db;
                --askme-border-focus: #6366f1;
                --askme-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                --askme-radius: 0.5rem;
                --askme-error: #ef4444;
                --askme-label: #374151;
            }
            .askme-container {
                max-width: 800px;
                margin: 2rem auto;
                padding: 2.5rem;
                background: var(--askme-bg);
                border-radius: var(--askme-radius);
                box-shadow: var(--askme-shadow);
                font-family: system-ui, -apple-system, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
                color: var(--askme-text);
                border: 1px solid #e5e7eb;
            }
            .askme-form-group {
                margin-bottom: 1.5rem;
                display: flex;
                flex-direction: column;
            }
            .askme-row {
                display: flex;
                flex-wrap: wrap;
                gap: 1.5rem;
                margin-bottom: 1.5rem;
            }
            .askme-row > .askme-form-group {
                flex: 1;
                min-width: 250px;
                margin-bottom: 0;
            }
            .askme-label {
                font-weight: 500;
                font-size: 0.875rem;
                margin-bottom: 0.5rem;
                color: var(--askme-label);
            }
            .askme-required {
                color: var(--askme-error);
            }
            .askme-input {
                width: 100%;
                padding: 0.75rem 1rem;
                border: 1px solid var(--askme-border);
                border-radius: var(--askme-radius);
                background-color: #f9fafb;
                font-size: 1rem;
                transition: all 0.2s ease-in-out;
                box-sizing: border-box;
            }
            .askme-input:focus {
                outline: none;
                border-color: var(--askme-border-focus);
                box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
                background-color: #fff;
            }
            .askme-textarea {
                min-height: 120px;
                resize: vertical;
            }
            .askme-select {
                cursor: pointer;
                appearance: none;
                background-image: url("data:image/svg+xml,%3csvg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 20 20\'%3e%3cpath stroke=\'%236b7280\' stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'M6 8l4 4 4-4\'/%3e%3c/svg%3e");
                background-position: right 0.5rem center;
                background-repeat: no-repeat;
                background-size: 1.5em 1.5em;
                padding-right: 2.5rem;
            }
            .askme-checkbox-group {
                display: flex;
                align-items: center;
            }
            .askme-checkbox-label {
                display: flex;
                align-items: center;
                cursor: pointer;
                font-size: 0.875rem;
                color: var(--askme-text);
            }
            .askme-checkbox-label input[type="checkbox"] {
                width: 1.25rem;
                height: 1.25rem;
                margin-right: 0.5rem;
                border-radius: 0.25rem;
                border: 1px solid var(--askme-border);
                cursor: pointer;
            }
            /* Radio Styling */
            .askme-radio-group { width: 100%; }
            .askme-radio-options {
                display: flex;
                flex-direction: column;
                gap: 0.75rem;
                margin-top: 0.5rem;
            }
            .askme-radio-label {
                display: flex;
                align-items: center;
                cursor: pointer;
                font-size: 0.875rem;
            }
            .askme-radio-label input[type="radio"] {
                width: 1.25rem;
                height: 1.25rem;
                margin-right: 0.5rem;
                cursor: pointer;
            }
            .askme-btn {
                display: inline-flex;
                justify-content: center;
                align-items: center;
                padding: 0.75rem 1.5rem;
                font-size: 1rem;
                font-weight: 500;
                border: none;
                border-radius: var(--askme-radius);
                cursor: pointer;
                transition: background-color 0.2s;
            }
            .askme-btn-primary {
                background-color: var(--askme-primary);
                color: white;
            }
            .askme-btn-primary:hover {
                background-color: var(--askme-primary-hover);
            }
            .askme-helper-text {
                margin-top: 0.25rem;
                font-size: 0.75rem;
                color: #6b7280;
            }
        </style>';
    }

    public function generateForm()
    {
        $html = sprintf(
            '<form action="%s" method="%s" id="%s" class="%s"%s>',
            htmlspecialchars($this->action),
            htmlspecialchars($this->method),
            htmlspecialchars($this->formId),
            htmlspecialchars($this->formClass),
            $this->enctype ? ' enctype="' . htmlspecialchars($this->enctype) . '"' : ''
        );

        foreach ($this->elements as $element) {
            if ($element['type'] === 'field') {
                $html .= $element['content']->render();
            } elseif ($element['type'] === 'row') {
                $html .= '<div class="askme-row">';
                foreach ($element['content'] as $field) {
                    $html .= $field->render();
                }
                $html .= '</div>';
            } elseif ($element['type'] === 'html') {
                $html .= $element['content'];
            }
        }

        $html .= '</form>';

        return $html;
    }
}
