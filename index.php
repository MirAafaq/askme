<?php

require_once __DIR__ . '/vendor/autoload.php';

use ArtifyForm\ArtifyForm;
use ArtifyForm\Fieldset;
use ArtifyForm\Field\TextField;
use ArtifyForm\Field\EmailField;
use ArtifyForm\Field\PasswordField;
use ArtifyForm\Field\SelectField;
use ArtifyForm\Field\RadioField;
use ArtifyForm\Field\CheckboxField;
use ArtifyForm\Field\TextAreaField;
use ArtifyForm\Field\FileField;
use ArtifyForm\Field\ButtonField;
use ArtifyForm\Field\DateField;
use ArtifyForm\Field\NumberField;
use ArtifyForm\Field\ColorField;
use ArtifyForm\Field\MultiSelectField;
use ArtifyForm\Field\WysiwygField;

// Initialize Form Builder
$formBuilder = new ArtifyForm('', 'POST');
$formBuilder->setFormId('registration-form');

// Adding header HTML
$formBuilder->addHtml('<div style="margin-bottom: 2rem; border-bottom: 1px solid #e5e7eb; padding-bottom: 1rem;">');
$formBuilder->addHtml('<h2 style="margin: 0; color: #111827; font-size: 1.5rem;">Register Account</h2>');
$formBuilder->addHtml('<p style="margin: 0.5rem 0 0 0; color: #6b7280; font-size: 0.875rem;">Now with automatic Server-Side validation, old inputs repopulation, and Fieldsets!</p>');
$formBuilder->addHtml('</div>');

// 1. Personal Information Fieldset
$personalFieldset = new Fieldset('Personal Information');

$firstName = (new TextField('first_name'))
    ->label('First Name')
    ->placeholder('e.g. John')
    ->rules(['required', 'min:3']);

$lastName = (new TextField('last_name'))
    ->label('Last Name')
    ->placeholder('e.g. Doe')
    ->rules(['required']);

$dob = (new DateField('dob'))
    ->label('Date of Birth')
    ->rules(['required']);
    
$color = (new ColorField('profile_color'))
    ->label('Profile Hex Color')
    ->value('#4f46e5');

$personalFieldset->addRow([$firstName, $lastName]);
$personalFieldset->addRow([$dob, $color]);

// 2. Account Specifics Fieldset
$accountFieldset = new Fieldset('Account Details');

$email = (new EmailField('email'))
    ->label('Email Address')
    ->placeholder('john@example.com')
    ->rules(['required', 'email']);

$password = (new PasswordField('password'))
    ->label('Secure Password')
    ->rules(['required', 'min:8']);
    
$age = (new NumberField('age'))
    ->label('Current Age')
    ->attr('min', 18)
    ->rules(['required', 'numeric']);

$accountFieldset->addRow([$email, $password]);
$accountFieldset->addField($age);

// Additional Fields outside Fieldsets (For test coverage)
$gender = (new RadioField('gender'))
    ->label('Gender')
    ->options(['male' => 'Male', 'female' => 'Female', 'other' => 'Other'])
    ->rules(['required']);

$bio = (new WysiwygField('bio'))
    ->label('Short Bio')
    ->placeholder('Tell us about yourself...')
    ->rules(['max:500']);

$tools = (new MultiSelectField('tools'))
    ->label('Favorite Tools')
    ->options(['php' => 'PHP', 'js' => 'JavaScript', 'python' => 'Python', 'html' => 'HTML'])
    ->rules(['required']);

$terms = (new CheckboxField('terms'))
    ->label('I agree to the Terms and Conditions')
    ->rules(['required']);

$submitBtn = (new ButtonField('register_btn'))
    ->type('submit')
    ->value('Create Account')
    ->class('artifyform-btn-primary')
    ->attr('style', 'width: 100%; margin-top: 1rem;');

// Adding everything to the form
$formBuilder->addField($personalFieldset);
$formBuilder->addField($accountFieldset);
$formBuilder->addField($gender);
$formBuilder->addField($tools);
$formBuilder->addField($bio);
$formBuilder->addField($terms);
$formBuilder->addField($submitBtn);


// VALIDATION ENGINE SIMULATION
$successMsg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Calling ->validate($_POST) will automatically test all rules, 
    // populate errors directly into field UIs, and refill old values!
    if ($formBuilder->validate($_POST)) {
        $validatedData = $formBuilder->getValidatedData();
        $successMsg = '<div style="background: #ecfdf5; color: #047857; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; border: 1px solid #a7f3d0;">Success! Server validated. Data: '.json_encode($validatedData).'</div>';
    } else {
        $successMsg = '<div style="background: #fef2f2; color: #b91c1c; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; border: 1px solid #fecaca;">Failed Validation! Please check the inline field errors below.</div>';
    }
}

$formCssHTML = $formBuilder->generateCss();
$formHTML = $formBuilder->generateForm();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ArtifyForm Modern Form Builder Demo</title>
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
    <div style="width: 100%; max-width: 800px;">
        <?= $successMsg ?>
        <?= $formHTML ?>
    </div>
</body>
</html>
