<?php

namespace Tests\ArtifyForm\Field;

use PHPUnit\Framework\TestCase;
use ArtifyForm\Field\RadioField;

class RadioFieldTest extends TestCase
{
    public function testRender()
    {
        $fieldName = 'gender';
        $options = ['male' => 'Male', 'female' => 'Female'];
        $radioField = new RadioField($fieldName, $options);

        $html = $radioField->render();

        $this->assertStringContainsString('type="radio"', $html);
        $this->assertStringContainsString('value="male"', $html);
        $this->assertStringContainsString('value="female"', $html);
    }
}
