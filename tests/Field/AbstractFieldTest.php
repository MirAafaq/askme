<?php

namespace Tests\ArtifyForm\Field;

use PHPUnit\Framework\TestCase;
use ArtifyForm\Field\AbstractField;

class AbstractFieldTest extends TestCase
{
    public function testConstructor()
    {
        $fieldName = 'test_field';
        $field = $this->getMockForAbstractClass(AbstractField::class, [$fieldName]);

        $this->assertEquals($fieldName, $field->getName());
    }

    
}
