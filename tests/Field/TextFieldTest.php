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

        $expectedOutput = '<label for="' . $fieldName . '">Username:</label><input type="text" name="' . $fieldName . '" placeholder="' . $fieldName . '"><br>';

        $this->assertEquals($expectedOutput, $textField->render());
    }

    // You can add more test methods to cover other functionalities of the TextField class
}
