<?php

namespace Tests\AskMe\Field;

use PHPUnit\Framework\TestCase;
use AskMe\Field\FileField;

class FileFieldTest extends TestCase
{
    public function testRender()
    {
        $fieldName = 'file';
        $fileField = new FileField($fieldName);

        $expectedOutput = '<label for="' . $fieldName . '" class="block font-medium mb-1">' . ucfirst($fieldName) . ':</label>'
            . '<input type="file" name="' . $fieldName . '"><br>';

        $this->assertEquals($expectedOutput, $fileField->render());
    }

    // You can add more test methods to cover other functionalities of the FileField class
}
