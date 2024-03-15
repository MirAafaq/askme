<?php

namespace Tests\AskMe\Field;

use PHPUnit\Framework\TestCase;
use AskMe\Field\AbstractField;

class AbstractFieldTest extends TestCase
{
    public function testConstructor()
    {
        $fieldName = 'test_field';
        $field = $this->getMockForAbstractClass(AbstractField::class, [$fieldName]);

        $this->assertEquals($fieldName, $field->getName());
    }

    
}
