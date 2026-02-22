<?php

namespace Tests\ArtifyForm\Field;

use PHPUnit\Framework\TestCase;
use ArtifyForm\Field\EmailField;

class EmailFieldTest extends TestCase
{
    public function testRender()
    {
        $fieldName = 'email';
        $emailField = new EmailField($fieldName);

        $html = $emailField->render();

        $this->assertStringContainsString('class="artifyform-input"', $html);
        $this->assertStringContainsString('type="email"', $html);
        $this->assertStringContainsString('name="' . $fieldName . '"', $html);
    }
}
