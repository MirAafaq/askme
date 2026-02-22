<?php

namespace Tests\AskMe\Field;

use PHPUnit\Framework\TestCase;
use AskMe\Field\SelectField;

class SelectFieldTest extends TestCase
{
    public function testRender()
    {
        $fieldName = 'country';
        $options = ['us' => 'United States', 'uk' => 'United Kingdom'];
        $selectField = new SelectField($fieldName, $options);

        $html = $selectField->render();

        $this->assertStringContainsString('<select', $html);
        $this->assertStringContainsString('name="' . $fieldName . '"', $html);
        $this->assertStringContainsString('value="us"', $html);
        $this->assertStringContainsString('value="uk"', $html);
    }
}
