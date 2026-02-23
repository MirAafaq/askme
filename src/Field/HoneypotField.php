<?php

namespace ArtifyForm\Field;

class HoneypotField extends AbstractField
{
    public function __construct(string $name = 'website_url_hp')
    {
        parent::__construct($name);
        $this->rules(['honeypot']);
    }

    public function render(): string
    {
        // Hide from humans, accessible to bots
        $html = sprintf(
            '<div style="display:none; visibility:hidden;">
                <label for="%s">Leave this field blank</label>
                <input type="text" id="%s" name="%s" value="">
            </div>',
            htmlspecialchars($this->name),
            htmlspecialchars($this->name),
            htmlspecialchars($this->name)
        );

        return $html;
    }
}
