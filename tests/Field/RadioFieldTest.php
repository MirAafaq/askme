<?php

namespace Tests\AskMe\Field;

use PHPUnit\Framework\TestCase;
use AskMe\Field\RadioField;

class RadioFieldTest extends TestCase
{
    public function testRender()
    {
        $fieldName = 'gender';
        $options = [
            'male' => 'Male',
            'female' => 'Female',
            'other' => 'Other',
        ];
        $radioField = new RadioField($fieldName, $options);

        $expectedOutput = '<div class="mdbn"><label>Gender:</label><br>'
            . '<label for="' . $fieldName . '_male"><input type="radio" name="' . $fieldName . '" value="male"> Male</label><br>'
            . '<label for="' . $fieldName . '_female"><input type="radio" name="' . $fieldName . '" value="female"> Female</label><br>'
            . '<label for="' . $fieldName . '_other"><input type="radio" name="' . $fieldName . '" value="other"> Other</label><br>'
            . '</div>';

        $this->assertEquals($expectedOutput, $radioField->render());
    }

    // You can add more test methods to cover other functionalities of the RadioField class
}
