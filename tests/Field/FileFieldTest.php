<?php

namespace Tests\AskMe\Field;

use PHPUnit\Framework\TestCase;
use AskMe\Field\FileField;

class FileFieldTest extends TestCase
{
    public function testRender()
    {
        $fieldName = 'avatar';
        $fileField = new FileField($fieldName);

        $html = $fileField->render();

        $this->assertStringContainsString('type="file"', $html);
        $this->assertStringContainsString('name="' . $fieldName . '"', $html);
    }
}
