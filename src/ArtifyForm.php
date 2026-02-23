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
    private $honeypotEnabled = false;
    private $ajaxEnabled = false;
    private $ajaxSuccessMessage = 'Success!';

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

    public function generateCss(string $theme = 'default')
    {
        return \ArtifyForm\Renderer\StyleRenderer::render($theme);
    }

    public function withHoneypot()
    {
        $this->honeypotEnabled = true;
        return $this;
    }

    public function enableAjax(string $successMessage = 'Success!')
    {
        $this->ajaxEnabled = true;
        $this->ajaxSuccessMessage = $successMessage;
        $this->formClass .= ' artifyform-ajax';
        return $this;
    }

    public function saveFile(string $fieldName, string $destinationDir): bool
    {
        $data = $this->getValidatedData();
        if (isset($data[$fieldName]) && is_array($data[$fieldName]) && $data[$fieldName]['error'] === UPLOAD_ERR_OK) {
            $tmpName = $data[$fieldName]['tmp_name'];
            $name = basename($data[$fieldName]['name']);
            if (!is_dir($destinationDir)) {
                mkdir($destinationDir, 0755, true);
            }
            return move_uploaded_file($tmpName, rtrim($destinationDir, '/') . '/' . $name);
        }
        return false;
    }

    public function sendJson()
    {
        header('Content-Type: application/json');
        if (empty($this->getErrors())) {
            echo json_encode(['success' => true, 'message' => $this->ajaxSuccessMessage]);
        } else {
            http_response_code(422);
            echo json_encode(['success' => false, 'errors' => $this->getErrors()]);
        }
        exit;
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
        if ($this->honeypotEnabled) {
            $this->addField(new \ArtifyForm\Field\HoneypotField());
        }

        $html = \ArtifyForm\Renderer\HtmlRenderer::render(
            $this->elements,
            $this->action,
            $this->method,
            $this->formId,
            $this->formClass,
            $this->enctype
        );
        
        // Inject JS for Advanced Features (Conditional Logic & AJAX)
        $html .= $this->generateAdvancedScripts();
        return $html;
    }

    private function generateAdvancedScripts() 
    {
        $script = '<script>document.addEventListener("DOMContentLoaded", function() {';
        $script .= 'const form = document.getElementById("'.htmlspecialchars($this->formId).'");';
        $script .= 'if (!form) return;';

        // 1. Conditional Logic Binding
        $script .= 'const conditionalElements = form.querySelectorAll("[data-depends-on]");';
        $script .= 'if (conditionalElements.length > 0) {';
        $script .= '    const checkConditions = () => {';
        $script .= '        conditionalElements.forEach(el => {';
        $script .= '            const targetName = el.getAttribute("data-depends-on");';
        $script .= '            const targetValue = el.getAttribute("data-depends-value");';
        $script .= '            const targetInputs = form.querySelectorAll(`[name="${targetName}"], [name="${targetName}[]"]`);';
        $script .= '            let matched = false;';
        $script .= '            targetInputs.forEach(input => {';
        $script .= '                if (input.type === "radio" || input.type === "checkbox") {';
        $script .= '                    if (input.checked && input.value === targetValue) matched = true;';
        $script .= '                } else {';
        $script .= '                    if (input.value === targetValue) matched = true;';
        $script .= '                }';
        $script .= '            });';
        $script .= '            el.style.display = matched ? "" : "none";';
        $script .= '        });';
        $script .= '    };';
        $script .= '    form.addEventListener("change", checkConditions);';
        $script .= '    checkConditions();'; // initial check
        $script .= '}';

        // 2. Multi-Step Wizard Binding
        $script .= 'const steps = form.querySelectorAll(".artifyform-step");';
        $script .= 'if (steps.length > 0) {';
        $script .= '    let currentStep = 0;';
        $script .= '    const showStep = (index) => {';
        $script .= '        steps.forEach((step, i) => {';
        $script .= '            step.style.display = i === index ? "block" : "none";';
        $script .= '        });';
        $script .= '    };';
        $script .= '    const stepBtns = form.querySelectorAll("[data-step-action]");';
        $script .= '    stepBtns.forEach(btn => {';
        $script .= '        btn.addEventListener("click", (e) => {';
        $script .= '            const action = btn.getAttribute("data-step-action");';
        $script .= '            if (action === "next" && currentStep < steps.length - 1) currentStep++;';
        $script .= '            if (action === "prev" && currentStep > 0) currentStep--;';
        $script .= '            showStep(currentStep);';
        $script .= '            if (action !== "submit") e.preventDefault();';
        $script .= '        });';
        $script .= '    });';
        $script .= '    showStep(0);';
        $script .= '}';

        // 3. Native AJAX Payload
        if ($this->ajaxEnabled) {
            $script .= 'form.addEventListener("submit", async function(e) {';
            $script .= '    e.preventDefault();';
            $script .= '    const submitBtn = form.querySelector("[type=\"submit\"]");';
            $script .= '    const originalText = submitBtn ? submitBtn.innerHTML : "";';
            $script .= '    if (submitBtn) submitBtn.innerHTML = "Processing...";';
            
            $script .= '    form.querySelectorAll(".artifyform-field-error").forEach(el => el.classList.remove("artifyform-field-error"));';
            $script .= '    form.querySelectorAll(".artifyform-error-text").forEach(el => el.remove());';

            $script .= '    try {';
            $script .= '        const formData = new FormData(form);';
            $script .= '        const response = await fetch(form.action || window.location.href, {';
            $script .= '            method: form.method || "POST", body: formData, headers: {"Accept": "application/json"}';
            $script .= '        });';
            $script .= '        const data = await response.json();';
            $script .= '        if (data.success) {';
            $script .= '            form.insertAdjacentHTML("beforebegin", `<div class="artifyform-success-banner" style="background: #ecfdf5; color: #047857; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; border: 1px solid #a7f3d0;">${data.message}</div>`);';
            $script .= '            form.reset();';
            $script .= '            if (steps.length > 0) { currentStep = 0; showStep(0); }';
            $script .= '        } else if (data.errors) {';
            $script .= '            for (const [field, errorMsg] of Object.entries(data.errors)) {';
            $script .= '                const input = form.querySelector(`[name="${field}"], [name="${field}[]"]`);';
            $script .= '                if (input) {';
            $script .= '                    const group = input.closest(".artifyform-form-group");';
            $script .= '                    if (group) {';
            $script .= '                        group.classList.add("artifyform-field-error");';
            $script .= '                        group.insertAdjacentHTML("beforeend", `<div class="artifyform-error-text" style="color: var(--artifyform-error); font-size: 0.875rem; margin-top: 0.25rem;">${errorMsg}</div>`);';
            $script .= '                    }';
            $script .= '                }';
            $script .= '            }';
            $script .= '        }';
            $script .= '    } catch (err) {}';
            
            $script .= '    if (submitBtn) submitBtn.innerHTML = originalText;';
            $script .= '});';
        }

        $script .= '});</script>';
        return $script;
    }
}
