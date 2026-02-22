# AskMe - Powerful Modern Dynamic Form Builder

AskMe is a modern, lightweight, and incredibly flexible PHP form builder. Say goodbye to manual HTML markup and tedious attribute handling!

## Installation

Using composer:
```bash
composer require miraafaq/askme
```

## Features Overhauled
- **Modern UI Styling**: Comes packed with a beautiful, professional, and responsive base CSS layout (rounded corners, shadow rings, smooth transitions).
- **Grid Layout System**: Effortlessly organize your form elements into responsive multi-column rows.
- **Fluent & Chainable Methods**: Easily customize fields directly upon instantiation using a chainable API (`->label()`, `->placeholder()`, `->required()`, etc.).
- **Comprehensive Fields**: TextField, EmailField, PasswordField, CheckboxField, RadioField, SelectField, TextAreaField, FileField, and ButtonField.
- **Easy Attributes Management**: Add any custom dataset (`data-*`), CSS class, or boolean attribute intuitively.

## Usage Example

```php
<?php
require_once __DIR__ . '/vendor/autoload.php';

use AskMe\AskForm;
use AskMe\Field\TextField;
use AskMe\Field\EmailField;
use AskMe\Field\PasswordField;
use AskMe\Field\ButtonField;

// 1. Initialize the Form Builder
$formBuilder = new AskForm('submit.php', 'POST');
$formBuilder->setFormId('registration-form');

// 2. Add Form Header
$formBuilder->addHtml('<h2>Register Account</h2>');

// 3. Create your fields using the intuitive Fluent API
$firstName = (new TextField('first_name'))
    ->label('First Name')
    ->placeholder('John')
    ->required(true)
    ->class('custom-class')
    ->helperText('Your given name');

$lastName = (new TextField('last_name'))
    ->label('Last Name')
    ->placeholder('Doe')
    ->required(true);

$email = (new EmailField('email'))
    ->label('Email Address')
    ->required(true);

$password = (new PasswordField('password'))
    ->label('Secure Password')
    ->required(true);

$submitBtn = (new ButtonField('register_btn'))
    ->type('submit')
    ->value('Create Account')
    ->class('askme-btn-primary');

// 4. Arrange Layout (Grid Structure)
$formBuilder->addRow([$firstName, $lastName]); // Places them side-by-side!
$formBuilder->addField($email);
$formBuilder->addField($password);
$formBuilder->addField($submitBtn);

// 5. Generate and Output
$formCssHTML = $formBuilder->generateCss();
$formHTML = $formBuilder->generateForm();

echo $formCssHTML;
echo $formHTML;
```

## Testing

Install PHPUnit dev dependency if not already present:
```bash
composer require phpunit/phpunit --dev
```

Run tests from the root directory:
```bash
vendor/bin/phpunit
```

## Author 
[Aafaq Ahmad Mir](https://miraafaq.in)
