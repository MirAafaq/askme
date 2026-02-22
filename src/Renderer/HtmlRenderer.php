<?php

namespace ArtifyForm\Renderer;

class HtmlRenderer
{
    /**
     * Renders the HTML structure for the form and its fields.
     *
     * @param array $elements
     * @param string $action
     * @param string $method
     * @param string $formId
     * @param string $formClass
     * @param string $enctype
     * @return string
     */
    public static function render(array $elements, string $action, string $method, string $formId, string $formClass, string $enctype): string
    {
        $html = sprintf(
            '<form action="%s" method="%s" id="%s" class="%s"%s>',
            htmlspecialchars($action),
            htmlspecialchars($method),
            htmlspecialchars($formId),
            htmlspecialchars($formClass),
            $enctype ? ' enctype="' . htmlspecialchars($enctype) . '"' : ''
        );

        foreach ($elements as $element) {
            if ($element['type'] === 'field') {
                $html .= $element['content']->render();
            } elseif ($element['type'] === 'row') {
                $html .= '<div class="artifyform-row">';
                foreach ($element['content'] as $field) {
                    // Check if it's an object conforming to RenderableInterface before calling render
                    if (is_object($field) && method_exists($field, 'render')) {
                        $html .= $field->render();
                    }
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
