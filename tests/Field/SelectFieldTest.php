<?php

namespace Tests\AskMe\Field;

use PHPUnit\Framework\TestCase;
use AskMe\Field\SelectField;

class SelectFieldTest extends TestCase
{
    public function testRender()
    {
        $fieldName = 'country';
        $options = [
            'us' => 'United States',
            'uk' => 'United Kingdom',
            'ca' => 'Canada',
        ];
        $selectField = new SelectField($fieldName, $options);

        $expectedOutput = '<label for="' . $fieldName . '">Country:</label><select name="' . $fieldName . '">'
            . '<option value="us">United States</option>'
            . '<option value="uk">United Kingdom</option>'
            . '<option value="ca">Canada</option>'
            . '</select><br>';

        $this->assertEquals($expectedOutput, $selectField->render());
    }

    // You can add more test methods to cover other functionalities of the SelectField class
}
