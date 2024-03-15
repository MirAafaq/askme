<?php

namespace Tests\AskMe;

use PHPUnit\Framework\TestCase;
use AskMe\AskForm;
use AskMe\Field\TextField;
use AskMe\Field\EmailField;
use AskMe\Field\FileField;
use AskMe\Field\CheckboxField;
use AskMe\Field\PasswordField;
use AskMe\Field\RadioField;
use AskMe\Field\SelectField;
use AskMe\Field\TextAreaField;
class AskFormTest extends TestCase
{
    public function testGenerateCss()
    {
        $askForm = new AskForm('action.php');
        $css = $askForm->generateCss();

        // You can add assertions here to verify the generated CSS code
        $this->assertNotEmpty($css);
        // Add more assertions as needed
    }

    public function testGenerateFormWithFileField()
    {
        $askForm = new AskForm('action.php');
        $askForm->addField(new TextField('username'));
        $askForm->addField(new EmailField('email'));
        $askForm->addField(new FileField('avatar'));

        $form = $askForm->generateForm();

        
        $this->assertStringContainsString('<form action="action.php" method="POST" enctype="multipart/form-data">', $form);
        $this->assertStringContainsString('<input type="file" name="avatar">', $form);
        
    }

    public function testGenerateFormWithoutFileField()
    {
        $askForm = new AskForm('action.php');
        $askForm->addField(new TextField('username'));
        $askForm->addField(new EmailField('email'));

        $form = $askForm->generateForm();

        
        $this->assertStringContainsString('<form action="action.php" method="POST">', $form);
        $this->assertStringNotContainsString('enctype="multipart/form-data"', $form);
       
    }

    public function testGenerateFormWithCheckboxField()
    {
        $askForm = new AskForm('action.php');
        $askForm->addField(new CheckboxField('agree'));

        $form = $askForm->generateForm();

        // You can add assertions here to verify the generated form HTML code
        $this->assertStringContainsString('<input type="checkbox" name="agree">', $form);
        // Add more assertions as needed
    }

    public function testGenerateFormWithPasswordField()
    {
        $askForm = new AskForm('action.php');
        $askForm->addField(new PasswordField('password'));

        $form = $askForm->generateForm();

        
        $this->assertStringContainsString('<form action="action.php" method="POST"><label for="password">Password:</label><input type="password" name="password" placeholder="password"><br><button type="submit">Submit</button></form>', $form);
        
    }

    public function testGenerateFormWithRadioField()
    {
        $askForm = new AskForm('action.php');
        $askForm->addField(new RadioField('gender', ['male' => 'Male', 'female' => 'Female']));

        $form = $askForm->generateForm();

        // You can add assertions here to verify the generated form HTML code
        $this->assertStringContainsString('<input type="radio" name="gender" value="male">', $form);
        $this->assertStringContainsString('<input type="radio" name="gender" value="female">', $form);
        // Add more assertions as needed
    }

    public function testGenerateFormWithSelectField()
    {
        $askForm = new AskForm('action.php');
        $askForm->addField(new SelectField('country', ['us' => 'United States', 'uk' => 'United Kingdom']));

        $form = $askForm->generateForm();

        // You can add assertions here to verify the generated form HTML code
        $this->assertStringContainsString('<select name="country">', $form);
        $this->assertStringContainsString('<option value="us">United States</option>', $form);
        $this->assertStringContainsString('<option value="uk">United Kingdom</option>', $form);
        // Add more assertions as needed
    }

    public function testGenerateFormWithTextAreaField()
    {
        $askForm = new AskForm('action.php');
        $askForm->addField(new TextAreaField('message'));

        $form = $askForm->generateForm();

        // You can add assertions here to verify the generated form HTML code
        $this->assertStringContainsString('<textarea name="message">', $form);
        // Add more assertions as needed
    }
}
