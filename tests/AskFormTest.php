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
        $this->assertNotEmpty($css);
    }

    public function testGenerateFormWithFileField()
    {
        $askForm = new AskForm('action.php');
        $askForm->addField(new TextField('username'));
        $askForm->addField(new EmailField('email'));
        $askForm->addField(new FileField('avatar'));

        $form = $askForm->generateForm();
        
        $this->assertStringContainsString('enctype="multipart/form-data', $form);
        $this->assertStringContainsString('type="file"', $form);
        $this->assertStringContainsString('name="avatar"', $form);
    }

    public function testGenerateFormWithoutFileField()
    {
        $askForm = new AskForm('action.php');
        $askForm->addField(new TextField('username'));
        $askForm->addField(new EmailField('email'));

        $form = $askForm->generateForm();
        $this->assertStringNotContainsString('enctype="multipart/form-data"', $form);
    }

    public function testGenerateFormWithCheckboxField()
    {
        $askForm = new AskForm('action.php');
        $askForm->addField(new CheckboxField('agree'));

        $form = $askForm->generateForm();
        $this->assertStringContainsString('type="checkbox"', $form);
        $this->assertStringContainsString('name="agree"', $form);
    }

    public function testGenerateFormWithPasswordField()
    {
        $askForm = new AskForm('action.php');
        $askForm->addField(new PasswordField('password'));

        $form = $askForm->generateForm();
        $this->assertStringContainsString('type="password"', $form);
        $this->assertStringContainsString('name="password"', $form);
    }

    public function testGenerateFormWithRadioField()
    {
        $askForm = new AskForm('action.php');
        $askForm->addField(new RadioField('gender', ['male' => 'Male', 'female' => 'Female']));

        $form = $askForm->generateForm();
        $this->assertStringContainsString('type="radio"', $form);
        $this->assertStringContainsString('value="male"', $form);
        $this->assertStringContainsString('value="female"', $form);
    }

    public function testGenerateFormWithSelectField()
    {
        $askForm = new AskForm('action.php');
        $askForm->addField(new SelectField('country', ['us' => 'United States', 'uk' => 'United Kingdom']));

        $form = $askForm->generateForm();
        $this->assertStringContainsString('<select', $form);
        $this->assertStringContainsString('value="us"', $form);
        $this->assertStringContainsString('value="uk"', $form);
    }

    public function testGenerateFormWithTextAreaField()
    {
        $askForm = new AskForm('action.php');
        $askForm->addField(new TextAreaField('message'));

        $form = $askForm->generateForm();
        $this->assertStringContainsString('<textarea', $form);
        $this->assertStringContainsString('name="message"', $form);
    }
}
