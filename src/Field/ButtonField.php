<?php

namespace AskMe\Field;

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
        $this->class('askme-btn askme-btn-' . $type);
        return $this;
    }

    public function render()
    {
        $this->class('askme-btn');
        if (!isset($this->attributes['class']) || strpos($this->attributes['class'], 'askme-btn-') === false) {
             $this->class('askme-btn-primary');
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
