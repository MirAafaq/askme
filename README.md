# Askme

### 
 #Simple Dyanmic Form Builder
 ![askme](https://codejourney.in/App/Uploads/External/Images/askme.png)

# installation 
- using composer
 ```bash
composer require miraafaq/askme
```
- using composer and specified Version
 ```bash
composer require miraafaq/askme "^1.0.3"
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
use AskMe\Field\PasswordField;




$formBuilder = new AskForm('/submit.php');
$formBuilder->addField(new TextField('name'));
$formBuilder->addField(new EmailField('email'));
$formBuilder->addField(new PasswordField('password'));

$formCssHTML = $formBuilder->generateCss();
$formHTML = $formBuilder->generateForm();

echo $formCssHTML;
echo $formHTML;
```
# Author 
Aafaq Ahmad Mir
