<?php

namespace ArtifyForm\Field;

class ButtonField extends AbstractField
{
    private $type = 'submit';

    public function __construct($name = 'submit')
    {
        parent::__construct($name);
        $this->label = ucfirst($name);
    }

    public function type($type)
    {
        $this->type = $type;
        $this->class('artifyform-btn artifyform-btn-' . $type);
        return $this;
    }

    public function render(): string
    {
        $this->class('artifyform-btn');
        if (!isset($this->attributes['class']) || strpos($this->attributes['class'], 'artifyform-btn-') === false) {
             $this->class('artifyform-btn-primary');
        }

        $labelText = $this->value ?: $this->label;

        return sprintf(
            '<div class="%s"><button type="%s"%s>%s</button></div>',
            $this->wrapperClass,
            $this->type,
            $this->buildAttributes(),
            htmlspecialchars($labelText)
        );
    }
}
