<?php

namespace Tests\AskMe\Field;

use PHPUnit\Framework\TestCase;
use AskMe\Field\PasswordField;

class PasswordFieldTest extends TestCase
{
    public function testRender()
    {
        $fieldName = 'password';
        $passwordField = new PasswordField($fieldName);

        $html = $passwordField->render();

        $this->assertStringContainsString('class="askme-input"', $html);
        $this->assertStringContainsString('type="password"', $html);
        $this->assertStringContainsString('name="' . $fieldName . '"', $html);
    }
}
