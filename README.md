# Askme
['https://camo.githubusercontent.com/5fd304917ddf748b207feb95703300eb14de48820133dd62113aff6be468dd02/68747470733a2f2f696d672e736869656c64732e696f2f62616467652f726571756972652d504850253230372d627269676874677265656e2e7376673f7374796c653d666c61742d737175617265']
### 
 # Askme - Simple Dynamic Form Builder
 ![askme](https://i.ibb.co/60s0tzb/Capture.png)

# installation 
- using composer
 ```bash
composer require miraafaq/askme
```
- using composer and specified Version
 ```bash
composer require miraafaq/askme "^1.0.4"
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
[Aafaq Ahmad Mir](https://miraafaq.in)
