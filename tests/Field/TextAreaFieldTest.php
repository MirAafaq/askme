<?php

namespace Tests\AskMe\Field;

use PHPUnit\Framework\TestCase;
use AskMe\Field\TextAreaField;

class TextAreaFieldTest extends TestCase
{
    public function testRender()
    {
        $fieldName = 'message';
        $textAreaField = new TextAreaField($fieldName);

        $expectedOutput = '<label for="' . $fieldName . '">Message:</label>
                <textarea name="' . $fieldName . '">Enter Your Text ....</textarea><br>';

        $this->assertEquals($expectedOutput, $textAreaField->render());
    }

    // You can add more test methods to cover other functionalities of the TextAreaField class
}
