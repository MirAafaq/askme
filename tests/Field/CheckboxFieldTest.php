<?php

namespace Tests\AskMe\Field;

use PHPUnit\Framework\TestCase;
use AskMe\Field\CheckboxField;

class CheckboxFieldTest extends TestCase
{
    public function testRender()
    {
        $fieldName = 'test_field';
        $checkboxField = new CheckboxField($fieldName);

        $expectedOutput = '<label for="' . $fieldName . '">
                    <input type="checkbox" name="' . $fieldName . '"> ' . ucfirst($fieldName) . '
                </label><br>';

        $this->assertEquals($expectedOutput, $checkboxField->render());
    }

    // You can add more test methods to cover other functionalities of the CheckboxField class
}
