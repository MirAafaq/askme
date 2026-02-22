<?php

namespace ArtifyForm\Field;

class WysiwygField extends AbstractField
{
    public function render(): string
    {
        $this->class('artifyform-input artifyform-textarea artifyform-wysiwyg');
        
        // We initialize basic tools, but the actual magic needs JS. 
        // We'll append a tiny localized script below it that triggers simple formatting commands.
        $content = $this->value !== null ? htmlspecialchars((string)$this->value) : '';
        $id = $this->attributes['id'];

        // Minimalist UI styling injected directly for the specific editor controls
        $editorHtml = sprintf('
            <div class="%s" style="display: flex; flex-direction: column;">
                %s
                <div class="artifyform-wysiwyg-toolbar" style="display: flex; gap: 5px; padding: 8px; border: 1px solid var(--artifyform-border); border-bottom: none; border-radius: var(--artifyform-radius) var(--artifyform-radius) 0 0; background-color: #f3f4f6;">
                    <button type="button" onclick="document.execCommand(\'bold\',false,null);" style="cursor:pointer; padding: 4px 8px; border: 1px solid #d1d5db; border-radius: 4px; background: white;"><b>B</b></button>
                    <button type="button" onclick="document.execCommand(\'italic\',false,null);" style="cursor:pointer; padding: 4px 8px; border: 1px solid #d1d5db; border-radius: 4px; background: white;"><i>I</i></button>
                    <button type="button" onclick="document.execCommand(\'underline\',false,null);" style="cursor:pointer; padding: 4px 8px; border: 1px solid #d1d5db; border-radius: 4px; background: white;"><u>U</u></button>
                </div>
                <!-- The real hidden textarea that submits data -->
                <textarea%s style="display:none;">%s</textarea>
                <!-- The visual editable div -->
                <div id="%s-editable" contenteditable="true" class="artifyform-input artifyform-textarea" style="border-radius: 0 0 var(--artifyform-radius) var(--artifyform-radius); min-height: 150px;">%s</div>
                %s
                %s
                <script>
                    (function() {
                        const editable = document.getElementById("%s-editable");
                        const hiddenInput = document.getElementById("%s");
                        editable.addEventListener("input", function() {
                            hiddenInput.value = editable.innerHTML;
                        });
                        // Allow initial content parsing natively
                        if (hiddenInput.value) {
                             editable.innerHTML = hiddenInput.value;
                        }
                    })();
                </script>
            </div>
        ', 
            $this->wrapperClass, 
            $this->renderLabel(), 
            $this->buildAttributes(), 
            $content, 
            $id, 
            $content, 
            $this->renderError(), 
            $this->renderHelper(),
            $id,
            $id
        );

        return $editorHtml;
    }
}
