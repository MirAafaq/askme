<?php

namespace Tests\ArtifyForm\Field;

use PHPUnit\Framework\TestCase;
use ArtifyForm\Field\CheckboxField;

class CheckboxFieldTest extends TestCase
{
    public function testRender()
    {
        $fieldName = 'agree';
        $checkboxField = new CheckboxField($fieldName);

        $html = $checkboxField->render();

        $this->assertStringContainsString('class="artifyform-checkbox-label"', $html);
        $this->assertStringContainsString('type="checkbox"', $html);
        $this->assertStringContainsString('name="' . $fieldName . '"', $html);
    }
}
