<?php

namespace Tests\ArtifyForm\Field;

use PHPUnit\Framework\TestCase;
use ArtifyForm\Field\TextAreaField;

class TextAreaFieldTest extends TestCase
{
    public function testRender()
    {
        $fieldName = 'message';
        $textAreaField = new TextAreaField($fieldName);

        $html = $textAreaField->render();

        $this->assertStringContainsString('<textarea', $html);
        $this->assertStringContainsString('name="' . $fieldName . '"', $html);
    }
}
