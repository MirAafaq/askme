<?php

namespace ArtifyForm;

use ArtifyForm\Contract\RenderableInterface;

class Fieldset implements RenderableInterface
{
    private $legend;
    private $elements = [];

    public function __construct(string $legend = '', array $elements = [])
    {
        $this->legend = $legend;
        $this->elements = $elements;
    }

    public function getElements(): array
    {
        return $this->elements;
    }

    public function addField(RenderableInterface $field)
    {
        $this->elements[] = ['type' => 'field', 'content' => $field];
        return $this;
    }

    public function addRow(array $fields)
    {
        $this->elements[] = ['type' => 'row', 'content' => $fields];
        return $this;
    }

    public function render(): string
    {
        $html = '<fieldset class="artifyform-fieldset" style="border: 1px solid var(--artifyform-border); padding: 1.5rem; margin-bottom: 2rem; border-radius: var(--artifyform-radius);">';
        
        if ($this->legend) {
            $html .= '<legend class="artifyform-legend" style="padding: 0 0.5rem; font-weight: 600; color: var(--artifyform-text);">' . htmlspecialchars($this->legend) . '</legend>';
        }

        foreach ($this->elements as $element) {
            // Allow simplified direct arrays to be treated as rows implicitly
            if (is_array($element) && !isset($element['type'])) {
                 $html .= '<div class="artifyform-row">';
                 foreach ($element as $f) {
                     if (is_object($f) && method_exists($f, 'render')) {
                         $html .= $f->render();
                     }
                 }
                 $html .= '</div>';
                 continue;
            }

            if (isset($element['type'])) {
                if ($element['type'] === 'field') {
                    $html .= $element['content']->render();
                } elseif ($element['type'] === 'row') {
                    $html .= '<div class="artifyform-row">';
                    foreach ($element['content'] as $field) {
                        if (is_object($field) && method_exists($field, 'render')) {
                            $html .= $field->render();
                        }
                    }
                    $html .= '</div>';
                }
            } else {
                 if (is_object($element) && method_exists($element, 'render')) {
                     $html .= $element->render();
                 }
            }
        }

        $html .= '</fieldset>';
        return $html;
    }
}
