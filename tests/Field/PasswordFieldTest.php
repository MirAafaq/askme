<?php

namespace Tests\ArtifyForm\Field;

use PHPUnit\Framework\TestCase;
use ArtifyForm\Field\PasswordField;

class PasswordFieldTest extends TestCase
{
    public function testRender()
    {
        $fieldName = 'password';
        $passwordField = new PasswordField($fieldName);

        $html = $passwordField->render();

        $this->assertStringContainsString('class="artifyform-input"', $html);
        $this->assertStringContainsString('type="password"', $html);
        $this->assertStringContainsString('name="' . $fieldName . '"', $html);
    }
}
