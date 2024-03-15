<?php

namespace AskMe\Field;

abstract class AbstractField
{
    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }

    abstract public function render();
}
