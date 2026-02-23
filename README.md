# ArtifyForm - Powerful Dynamic Form Builder

ArtifyForm is a modern, lightweight, incredibly flexible PHP form builder designed to eliminate markup and tedious boilerplate attribute handling. Easily generate HTML forms, perform server-side validation, manage grid layouts, re-populate old inputs, and integrate natively into frameworks.

## Table of Contents
1. [Installation](#installation)
2. [Quickstart Usage Example](#quickstart-usage-example)
3. [Field Types & Methods](#field-types--methods)
4. [Validation Engine](#validation-engine)
5. [Layouts & Fieldsets](#layouts--fieldsets)
6. [Framework Integrations](#framework-integrations)
7. [Custom Extensions](#custom-extensions)

---

## Installation

via composer:
```bash
composer require miraafaq/artifyform
```

---

## Quickstart Usage Example

Build beautiful, self-validating forms in minutes using fluid APIs without ever touching `<form>` HTML manually!

```php
<?php
require_once __DIR__ . '/vendor/autoload.php';

use ArtifyForm\ArtifyForm;
use ArtifyForm\Fieldset;
use ArtifyForm\Field\TextField;
use ArtifyForm\Field\EmailField;
use ArtifyForm\Field\ButtonField;

// 1. Initialize Builder
$formBuilder = new ArtifyForm('submit.php', 'POST');
$formBuilder->setFormId('registration-form');

// 2. Add Native HTML (Headers)
$formBuilder->addHtml('<h2>Register Account</h2>');

// 3. Create Fluent Fields
$firstName = (new TextField('first_name'))
    ->label('First Name')
    ->placeholder('e.g. John')
    ->rules(['required', 'min:3']);

$email = (new EmailField('email'))
    ->label('Email Address')
    ->rules(['required', 'email']);

$submitBtn = (new ButtonField('register_btn'))->type('submit')->value('Create Account')->class('artifyform-btn-primary');

// 4. Arrange in layout grid
$formBuilder->addRow([$firstName, $email]); 
$formBuilder->addField($submitBtn);

// 5. Automatic Validation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($formBuilder->validate($_POST)) {
        // Safe arrays!
        $cleanData = $formBuilder->getValidatedData();
    } else {
        // Errors natively inject into their form fields 
        $errors = $formBuilder->getErrors();
    }
}

// 6. Generate (Outputs inline styled base CSS and completed HTML tags)
echo $formBuilder->generateCss(); 
echo $formBuilder->generateForm(); 
```

---

## Field Types & Methods

All fields inherit from `AbstractField` allowing you to completely chain settings directly upon initialization.

### Base Chainable Methods
```php
->label('My Field')        // Renders visual label
->placeholder('Hint text') // Sets input placeholder
->helperText('Extra desc') // Adds small instruction text under field
->value('Default Value')   // Sets default input
->class('custom-class')    // Appends an extra CSS class 
->attr('data-id', 123)     // Pushes any custom attribute
->required()               // Adds native HTML5 required="" parameter
->rules(['required', '...']) // Initiates PHP Server-Side validation rules
```

### Available Field Types
- `TextField`: Standard `<input type="text">`
- `EmailField`: `<input type="email">`
- `PasswordField`: `<input type="password">`
- `HiddenField`: Invisible field for storing metadata or User IDs.
- `NumberField`: Supports incrementing numbers (supports `->attr('min', 1)`)
- `DateField`: Native HTML5 Calendar UI.
- `ColorField`: Native Hex Color Picker UI.
- `TextAreaField`: Long paragraph box.
- `FileField`: Seamlessly converts `<form>` to `enctype="multipart/form-data"`!
- `CheckboxField`: Supports a clean single toggle option.
- `RadioField`: Define array options via `->options(['m'=>'Male', 'f'=>'Female'])`.
- `SelectField`: Standard `<select>` dropdown (uses `->options([])`).
- `MultiSelectField`: Multiple selection `<select multiple>`. Intelligently adds `[]` suffix to field name to auto-hydrate values as PHP Array!
- `WysiwygField`: Standalone Rich-Text-Editor (Requires Zero Dependencies!). Contains localized Javascript for Bold, Italics, and Underlines piping to a hidden `<textarea>`.
- `ButtonField`: Triggers submission `<button type="submit">`.

---

## Validation Engine 

Add validation rule strings using `->rules(['rule:value'])` on any field.

**Available Rules:**
- `'required'`: Input must not be empty.
- `'email'`: Standard PHP `FILTER_VALIDATE_EMAIL`.
- `'numeric'`: Must be number format.
- `'min:{x}'`: Minimum string length (e.g. `min:8` for passwords).
- `'max:{x}'`: Maximum string length (e.g. `max:255`).

If `$formBuilder->validate($_POST)` fails, **ArtifyForm remembers the user's previously typed inputs and automatically paints the error text in red beneath the targeted field dynamically.**

---

## Layouts & Fieldsets

By default, inputs stack downwards. To implement styling you can use Grids or HTML Fieldset Groups.

**Grids (Rows)**:
Display elements side-by-side using `addRow()`.
```php
$formBuilder->addRow([
    (new TextField('first_name'))->label('First Name'),
    (new TextField('last_name'))->label('Last Name')
]);
```

**Fieldset Containers**:
Bundle related fields under a visually pleasing boundary.
```php
$billingFields = new \ArtifyForm\Fieldset('Billing Address');
$billingFields->addRow([$country, $zipcode]);
$formBuilder->addField($billingFields);
```

---

## Framework Integrations

ArtifyForm natively supports specific platform bindings!

### 1. Laravel Native
Because ArtifyForm ships via composer using `extra.laravel.providers`, its Core Service Provider is automatically discovered! Immediately use standard blade directives targeting an inherited `$formBuilder` variable passed through your Controller:
```blade
<!-- Places base CSS block in Head -->
@artifyform_css($formBuilder)

<!-- Outputs your configured form anywhere -->
@artifyform_form($formBuilder)
```

### 2. WordPress Appending
Register forms to shortcodes natively using ArtifyFormWP! Place this inside `functions.php`:
```php
use ArtifyForm\Integration\WordPress\ArtifyFormWP;

ArtifyFormWP::registerShortcode('contact_us_form', function($atts) {
    $form = new \ArtifyForm\ArtifyForm();
    // Configure $form ...
    return $form;
});
```
Then output `[contact_us_form]` inside any Post layout!

### 3. Razorpay Implementation
Instantly mount a popup Razorpay Button simply by adding it exactly like an input field!
```php
use ArtifyForm\Integration\Razorpay\RazorpayButton;

$payBtn = clone (new RazorpayButton('rzp_test_KEY123', 50000, 'My Company'))
    ->theme('#ff5500')
    ->prefill('John Doe', 'email@test.com', '9999999999');

$formBuilder->addField($payBtn);
```

### 4. Real-Time Push Notifications (OneSignal API)
Broadcast native push notifications to admin devices instantly upon form success.
```php
use ArtifyForm\Integration\OneSignal\OneSignalNotifier;

if ($formBuilder->validate($_POST)) {
    // Alert the admins via OneSignal app segment mapping!
    $notifier = new OneSignalNotifier('your_app_id', 'your_rest_key');
    $notifier->notifyAdmins("New form submission received from: " . $_POST['email']);
}
```

### 5. WebSockets (Azure SignalR)
Fire real-time HTTP broadcasts natively to all connected front-end WebSockets for live statistic updating across clients!
```php
use ArtifyForm\Integration\SignalR\SignalRNotifier;

if ($formBuilder->validate($_POST)) {
    // Broadast Event silently via Azure API!
    $signalR = new SignalRNotifier('https://my-app.service.signalr.net', 'formHub', 'accessKey123');
    $signalR->broadcast('ReceiveNewSubmission', [$_POST['email']]);
}
```

---

## Custom Extensions

ArtifyForm architecture rests strictly upon `SOLID` formatting. 
You can override or invent new components infinitely without touching source code by simply implementing `RenderableInterface`.

```php
<?php
class CustomInput implements \ArtifyForm\Contract\RenderableInterface {
    public function render(): string {
        return "<div class='mystyle'>My brand new HTML feature</div>";
    }
}

// Inject directly!
$formBuilder->addField(new CustomInput());
```

---

## Testing Framework

To run validations in dev structures use PHPUnit:
```bash
composer require phpunit/phpunit --dev
vendor/bin/phpunit
```

## Author 
[Aafaq Ahmad Mir](https://miraafaq.in)
