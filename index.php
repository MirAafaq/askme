<?php

require_once __DIR__ . '/vendor/autoload.php';

use AskMe\AskForm;
use AskMe\Field\TextField;
use AskMe\Field\EmailField;
use AskMe\Field\PasswordField;
use AskMe\Field\SelectField;
use AskMe\Field\RadioField;
use AskMe\Field\CheckboxField;
use AskMe\Field\TextAreaField;
use AskMe\Field\FileField;
use AskMe\Field\ButtonField;

// Initialize Form Builder
$formBuilder = new AskForm('submit.php');
$formBuilder->setFormId('registration-form');
$formBuilder->setFormClass('askme-container');

// Adding header HTML
$formBuilder->addHtml('<div style="margin-bottom: 2rem; border-bottom: 1px solid #e5e7eb; padding-bottom: 1rem;">');
$formBuilder->addHtml('<h2 style="margin: 0; color: #111827; font-size: 1.5rem;">Register Account</h2>');
$formBuilder->addHtml('<p style="margin: 0.5rem 0 0 0; color: #6b7280; font-size: 0.875rem;">Fill out the information below to complete your registration using the modernized AskMe form builder.</p>');
$formBuilder->addHtml('</div>');

// Creating Fields
$firstName = (new TextField('first_name'))
    ->label('First Name')
    ->placeholder('e.g. John')
    ->required(true)
    ->helperText('Your given name');

$lastName = (new TextField('last_name'))
    ->label('Last Name')
    ->placeholder('e.g. Doe')
    ->required(true);

$email = (new EmailField('email'))
    ->label('Email Address')
    ->placeholder('john@example.com')
    ->required(true);

$password = (new PasswordField('password'))
    ->label('Secure Password')
    ->required(true)
    ->helperText('Must be at least 8 characters long');

$gender = (new RadioField('gender'))
    ->label('Gender')
    ->options([
        'male' => 'Male',
        'female' => 'Female',
        'other' => 'Other'
    ])
    ->value('male'); // pre-select

$country = (new SelectField('country'))
    ->label('Country of Residence')
    ->placeholder('Select your country...')
    ->options([
        'usa' => 'United States',
        'uk' => 'United Kingdom',
        'in' => 'India',
        'au' => 'Australia'
    ])
    ->required(true);

$bio = (new TextAreaField('bio'))
    ->label('Short Bio')
    ->placeholder('Tell us a little about yourself...')
    ->helperText('Maximum 500 characters');

$resume = (new FileField('resume'))
    ->label('Upload Resume')
    ->attr('accept', '.pdf,.doc,.docx');

$terms = (new CheckboxField('terms'))
    ->label('I agree to the Terms and Conditions')
    ->required(true);

$submitBtn = (new ButtonField('register_btn'))
    ->type('submit')
    ->value('Create Account')
    ->class('askme-btn-primary')
    ->attr('style', 'width: 100%; margin-top: 1rem;');

// Layout Building
$formBuilder->addRow([$firstName, $lastName]); // Grid row (2 columns)
$formBuilder->addRow([$email, $password]);
$formBuilder->addField($gender);
$formBuilder->addRow([$country, $resume]);
$formBuilder->addField($bio);
$formBuilder->addField($terms);
$formBuilder->addField($submitBtn);

$formCssHTML = $formBuilder->generateCss();
$formHTML = $formBuilder->generateForm();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AskMe Modern Form Builder</title>
    <!-- Background styling for the page -->
    <style>
        body {
            background-color: #f3f4f6;
            margin: 0;
            padding: 2rem;
            font-family: system-ui, -apple-system, sans-serif;
            display: flex;
            justify-content: center;
        }
    </style>
    <?= $formCssHTML ?>
</head>
<body>
    <?= $formHTML ?>
</body>
</html>
