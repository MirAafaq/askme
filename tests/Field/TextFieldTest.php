<?php

namespace Tests\ArtifyForm\Field;

use PHPUnit\Framework\TestCase;
use ArtifyForm\Field\TextField;

class TextFieldTest extends TestCase
{
    public function testRender()
    {
        $fieldName = 'username';
        $textField = new TextField($fieldName);

        $html = $textField->render();

        $this->assertStringContainsString('class="artifyform-input"', $html);
        $this->assertStringContainsString('type="text"', $html);
        $this->assertStringContainsString('name="' . $fieldName . '"', $html);
    }
}
