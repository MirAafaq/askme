# askme

### 
 simple Form Generator 
# installation 
- using composer
 ```bash
composer require miraafaq/askme
```
- Git clone 
```bash
git clone https://github.com/miraafaq/askme.git
```
  

 # usage
 ```php
 <?php
require_once __DIR__ . '/vendor/autoload.php';

use AskMe\AskForm;
use AskMe\Field\TextField;
use AskMe\Field\EmailField;
use AskMe\Field\TextAreaField;
use AskMe\Field\PasswordField;

$formBuilder = new AskForm('/submit.php');
$formBuilder->addField(new TextField('name'));
$formBuilder->addField(new EmailField('email'));
$formBuilder->addField(new PasswordField('password'));
$formBuilder->addField(new TextAreaField('message'));

$formHTML = $formBuilder->generateForm();
echo $formHTML;
```
# Author 
Aafaq Ahmad Mir
