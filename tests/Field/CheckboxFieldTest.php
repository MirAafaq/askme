<?php

namespace Tests\AskMe\Field;

use PHPUnit\Framework\TestCase;
use AskMe\Field\CheckboxField;

class CheckboxFieldTest extends TestCase
{
    public function testRender()
    {
        $fieldName = 'agree';
        $checkboxField = new CheckboxField($fieldName);

        $html = $checkboxField->render();

        $this->assertStringContainsString('class="askme-checkbox-label"', $html);
        $this->assertStringContainsString('type="checkbox"', $html);
        $this->assertStringContainsString('name="' . $fieldName . '"', $html);
    }
}
