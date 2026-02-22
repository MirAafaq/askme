<?php

namespace Tests\AskMe\Field;

use PHPUnit\Framework\TestCase;
use AskMe\Field\TextField;

class TextFieldTest extends TestCase
{
    public function testRender()
    {
        $fieldName = 'username';
        $textField = new TextField($fieldName);

        $html = $textField->render();

        $this->assertStringContainsString('class="askme-input"', $html);
        $this->assertStringContainsString('type="text"', $html);
        $this->assertStringContainsString('name="' . $fieldName . '"', $html);
    }
}
