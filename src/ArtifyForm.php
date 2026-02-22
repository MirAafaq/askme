<?php

namespace ArtifyForm;

use ArtifyForm\Field\AbstractField;
use ArtifyForm\Field\FileField;

class ArtifyForm
{
    private $action;
    private $method;
    private $enctype = '';
    private $elements = [];
    private $submitButtonText = 'Submit';
    private $submitButtonClass = 'artifyform-btn artifyform-btn-primary';
    private $formId = 'artifyform-form';
    private $formClass = 'artifyform-container';
    private $validator;

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

    public function addField(\ArtifyForm\Contract\RenderableInterface $field)
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
        return \ArtifyForm\Renderer\StyleRenderer::render();
    }

    public function getElements(): array
    {
        return $this->elements;
    }

    public function validate(array $data): bool
    {
        if (!$this->validator) {
            $this->validator = new \ArtifyForm\Validation\Validator();
        }
        return $this->validator->validate($this, $data);
    }

    public function getErrors(): array
    {
        return $this->validator ? $this->validator->getErrors() : [];
    }

    public function getValidatedData(): array
    {
        return $this->validator ? $this->validator->getValidatedData() : [];
    }

    public function generateForm()
    {
        return \ArtifyForm\Renderer\HtmlRenderer::render(
            $this->elements,
            $this->action,
            $this->method,
            $this->formId,
            $this->formClass,
            $this->enctype
        );
    }
}
