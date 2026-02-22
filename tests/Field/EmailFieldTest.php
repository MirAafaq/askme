<?php

namespace Tests\AskMe\Field;

use PHPUnit\Framework\TestCase;
use AskMe\Field\EmailField;

class EmailFieldTest extends TestCase
{
    public function testRender()
    {
        $fieldName = 'email';
        $emailField = new EmailField($fieldName);

        $html = $emailField->render();

        $this->assertStringContainsString('class="askme-input"', $html);
        $this->assertStringContainsString('type="email"', $html);
        $this->assertStringContainsString('name="' . $fieldName . '"', $html);
    }
}
