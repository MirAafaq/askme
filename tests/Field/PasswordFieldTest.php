<?php

namespace Tests\AskMe\Field;

use PHPUnit\Framework\TestCase;
use AskMe\Field\PasswordField;

class PasswordFieldTest extends TestCase
{
    public function testRender()
    {
        $fieldName = 'password';
        $passwordField = new PasswordField($fieldName);

        $expectedOutput = '<label for="' . $fieldName . '">' . ucfirst($fieldName) . ':</label>'
            . '<input type="password" name="' . $fieldName . '" placeholder="' . $fieldName . '"><br>';

        $this->assertEquals($expectedOutput, $passwordField->render());
    }

    // You can add more test methods to cover other functionalities of the PasswordField class
}
