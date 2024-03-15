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

        $expectedOutput = '<label for="' . $fieldName . '" class="block font-medium mb-1">' . ucfirst($fieldName) . ':</label>'
            . '<input type="email" name="' . $fieldName . '" placeholder="' . $fieldName . '"><br>';

        $this->assertEquals($expectedOutput, $emailField->render());
    }

    // You can add more test methods to cover other functionalities of the EmailField class
}
