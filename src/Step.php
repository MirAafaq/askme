<?php

namespace ArtifyForm;

use ArtifyForm\Contract\RenderableInterface;

class Step implements RenderableInterface
{
    private $title;
    private $elements = [];
    private $isLastStep = false;
    private $isFirstStep = false;
    private $nextBtnText = 'Next';
    private $prevBtnText = 'Previous';
    private $submitBtnText = 'Submit';

    public function __construct(string $title = '', array $elements = [])
    {
        $this->title = $title;
        $this->elements = $elements;
    }

    public function setIsFirstStep(bool $bool) { $this->isFirstStep = $bool; return $this; }
    public function setIsLastStep(bool $bool) { $this->isLastStep = $bool; return $this; }
    public function buttons(string $next, string $prev = 'Previous', string $submit = 'Submit')
    {
        $this->nextBtnText = $next;
        $this->prevBtnText = $prev;
        $this->submitBtnText = $submit;
        return $this;
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
        $html = '<div class="artifyform-step" style="display: none; width: 100%;">'; // Let JS handle visibility
        
        if ($this->title) {
            $html .= '<h3 class="artifyform-step-title" style="margin-bottom: 1.5rem; font-size: 1.25rem; font-weight: 600; color: inherit;">' . htmlspecialchars($this->title) . '</h3>';
        }

        foreach ($this->elements as $element) {
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

        // Action Buttons mapped natively inside step blocks
        $html .= '<div class="artifyform-step-actions" style="display: flex; justify-content: space-between; margin-top: 2rem;">';
        
        if (!$this->isFirstStep) {
            $html .= sprintf('<button type="button" class="artifyform-btn" data-step-action="prev" style="background:var(--artifyform-input-bg); color:inherit; border: 1px solid var(--artifyform-border);">%s</button>', htmlspecialchars($this->prevBtnText));
        } else {
            $html .= '<div></div>'; // Spacer for flex-between
        }

        if (!$this->isLastStep) {
            $html .= sprintf('<button type="button" class="artifyform-btn artifyform-btn-primary" data-step-action="next">%s</button>', htmlspecialchars($this->nextBtnText));
        } else {
            $html .= sprintf('<button type="submit" class="artifyform-btn artifyform-btn-primary" data-step-action="submit">%s</button>', htmlspecialchars($this->submitBtnText));
        }
        
        $html .= '</div></div>';

        return $html;
    }
}
