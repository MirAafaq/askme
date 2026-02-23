<?php
require_once __DIR__ . '/vendor/autoload.php';

use ArtifyForm\ArtifyForm;
use ArtifyForm\Step;
use ArtifyForm\Fieldset;
use ArtifyForm\Field\TextField;
use ArtifyForm\Field\EmailField;
use ArtifyForm\Field\PasswordField;
use ArtifyForm\Field\SelectField;
use ArtifyForm\Field\RadioField;
use ArtifyForm\Field\CheckboxField;
use ArtifyForm\Field\FileField;
use ArtifyForm\Field\ColorField;
use ArtifyForm\Field\NumberField;
use ArtifyForm\Field\DateField;
use ArtifyForm\Field\HiddenField;
use ArtifyForm\Field\MultiSelectField;
use ArtifyForm\Field\WysiwygField;
use ArtifyForm\Integration\Razorpay\RazorpayButton;

/* =======================================================
 * 1. INITIALIZE MASTER FORM BUILDER
 * ======================================================= */
$formBuilder = new ArtifyForm('', 'POST');
$formBuilder->setFormId('mega-wizard');

// Enable Advanced Features!
$formBuilder->withHoneypot(); // Injects invisible spam trap
$formBuilder->enableAjax('Registration & Payment Successful via Background Fetch!');


/* =======================================================
 * 2. SERVER & VALIDATION LOGIC 
 * ======================================================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Server-Side Validation Check
    if ($formBuilder->validate($_POST)) {
        
        $cleanData = $formBuilder->getValidatedData();

        // Save File Native Method
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $formBuilder->saveFile('avatar', __DIR__ . '/uploads/');
        }

        /* 
        // 🚀 LIVE INTEGRATIONS EXAMPLES (Uncomment with real keys)
        // 1. OneSignal Push Notification to Admins
        $notifier = new \ArtifyForm\Integration\OneSignal\OneSignalNotifier('APP_ID', 'REST_KEY');
        $notifier->notifyAdmins("New signup from: " . $cleanData['email']);
        
        // 2. SignalR Live WebSocket Broadcast to UI
        $signalR = new \ArtifyForm\Integration\SignalR\SignalRNotifier('ENDPOINT', 'formHub', 'KEY');
        $signalR->broadcast('LiveCounterUpdate', ['new_user' => $cleanData['first_name']]);
        */
    }
    
    // sendJson() automatically outputs 422 standard validation errors or 200 Success msg and ends runtime!
    $formBuilder->sendJson();
}


/* =======================================================
 * 3. BUILD THE UI & FIELDS
 * ======================================================= */

// --- Header ---
$formBuilder->addHtml('<div style="margin-bottom: 2rem; border-bottom: 1px solid var(--artifyform-border); padding-bottom: 1rem; text-align: center;">');
$formBuilder->addHtml('<h2 style="margin: 0; color: inherit; font-size: 1.75rem;">Enterprise ArtifyForm Preview</h2>');
$formBuilder->addHtml('<p style="margin: 0.5rem 0 0 0; color: var(--artifyform-label); font-size: 0.875rem;">Showcasing every single feature: Wizards, Fieldsets, WYSIWYG, File Validations, Payment UIs, and AJAX Theming!</p>');
$formBuilder->addHtml('</div>');


// --- STEP 1: Layouts, Grids & Basic Components ---
$step1 = new Step('Step 1: Personal Profile');
$step1->setIsFirstStep(true)->buttons('Next: Account Types');

$firstName = (new TextField('first_name'))->label('First Name')->placeholder('John')->rules(['required', 'min:3']);
$lastName = (new TextField('last_name'))->label('Last Name')->placeholder('Doe')->rules(['required']);

$age = (new NumberField('age'))->label('Age')->attr('min', 18)->attr('max', 99)->rules(['numeric']);
$dob = (new DateField('dob'))->label('Date of Birth')->rules(['required']);
$color = (new ColorField('brand_color'))->label('Brand Color')->value('#4f46e5');

$step1->addRow([$firstName, $lastName]); // Side-by-side Grid!
$step1->addRow([$age, $dob, $color]);

// Nested Fieldset inside a Step!
$bioFieldset = new Fieldset('Public Biography Profile');
$email = (new EmailField('email'))->label('Public Email Address')->rules(['required', 'email']);
$bio = (new WysiwygField('bio'))->label('Write your story (Rich Text Editor)')->rules(['max:5000']);
$bioFieldset->addField($email)->addField($bio);

$step1->addField($bioFieldset);


// --- STEP 2: Conditional Logic & Selections ---
$step2 = new Step('Step 2: Technical & Conditional');
$step2->buttons('Next: Checkout', 'Back to Profile');

$role = (new RadioField('role'))
    ->label('Select your platform role:')
    ->options(['user' => 'Standard User', 'admin' => 'Administrator'])
    ->rules(['required']);

// This stays completely HIDDEN organically until "admin" is checked!
$adminCode = (new PasswordField('admin_code'))
    ->label('Enter Admin Secret Validation Code')
    ->dependsOn('role', 'admin') 
    ->rules(['min:5']);

$tools = (new MultiSelectField('tools'))
    ->label('Favorite Development Tools (Hold Ctrl to select multiple)')
    ->options(['php' => 'PHP', 'js' => 'JavaScript', 'py' => 'Python', 'rs' => 'Rust']);

$country = (new SelectField('country'))
    ->label('Country of Residence')
    ->options(['us' => 'USA', 'in' => 'India', 'uk' => 'United Kingdom']);

$step2->addField($role)->addField($adminCode);
$step2->addRow([$tools, $country]);


// --- STEP 3: File Validations, Hidden Tracking & Integrations ---
$step3 = new Step('Step 3: Verification & Finish');
$step3->setIsLastStep(true)->buttons('', 'Back to Technicals', 'Submit via Serverless AJAX');

$avatar = (new FileField('avatar'))
    ->label('Upload KYC / Avatar (JPG/PNG only, max 2MB)')
    ->rules(['mimes:png,jpg', 'max_size:2048']); // Native PHP File Parsing Engine!

$tracker = new HiddenField('session_tracker', 'TRACK_ID_99214');

// Checkout integration mock!
$payBtn = (new RazorpayButton('rzp_test_KEY123', 50000, 'Artify Premium Access'))
    ->theme('#2563eb')
    ->description('Lifetime Access Fee')
    ->prefill('Testing Account', 'test@test.com', '9999999999');

$terms = (new CheckboxField('terms'))
    ->label('I accept the end-user licensing agreement and confirm my data.')
    ->rules(['required']);

$step3->addField($avatar)->addField($tracker)->addField($payBtn)->addField($terms);


// Append Wizard Steps to the core stack
$formBuilder->addField($step1);
$formBuilder->addField($step2);
$formBuilder->addField($step3);


// Generate Form & CSS using the Premium Glass Theme
$css = $formBuilder->generateCss('glass');
$html = $formBuilder->generateForm();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ArtifyForm Complete Feature Showcase</title>
    <style>
        /* A cool animated background to show off the 'Glassmorphism' CSS Theme */
        body { 
            margin: 0; 
            padding: 2rem; 
            font-family: system-ui, -apple-system, sans-serif; 
            display: flex; 
            justify-content: center; 
            background: linear-gradient(45deg, #4f46e5, #ec4899);
            min-height: 100vh;
            background-attachment: fixed;
        }
        .demo-wrapper { width: 100%; max-width: 750px; }
    </style>
    <?= $css ?>
</head>
<body>
    <div class="demo-wrapper">
        <!-- Render the entirely complete ArtifyForm Engine String -->
        <?= $html ?>
    </div>
</body>
</html>
