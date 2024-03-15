### 
 # Askme - Simple Dynamic Form Builder


# installation 
- using composer
 ```bash
composer require miraafaq/askme
```
- using composer and specified Version
 ```bash
composer require miraafaq/askme "^1.0.5"
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
# Testing 
- After installing this library install phpunit for testing with below commmand in root directory
  ```bash
  composer require phpunit/phpunit
  ```
 - copy the file phpunit.xml available in test-config directory & paste it into root directory
 - edit the composer.json in root directory and add the below code if not sure see composer.json in test-config directory
   ```bash
   "autoload": {
        "psr-4": {
            "AskMe\\": "src/"
        }
    }
   ```
 - run the below command
    ```bash
    composer dump-autoload
    ```
 - To Run tests enter below command
   ```bash
   php vendor/bin/phpunit
   ```
 - if everything goes well you will see similar below results
   ```bash
   PS C:\Users\user\Downloads\PHPTESTING\c> php vendor/bin/phpunit          
   PHPUnit 10.5.13 by Sebastian Bergmann and contributors.

   Runtime:       PHP 8.1.6
   Configuration: C:\Users\user\Downloads\PHPTESTING\c\phpunit.xml

   .................                                                 17 / 17 (100%)

   Time: 00:00.060, Memory: 8.00 MB

   OK (17 tests, 22 assertions)
   ```
   
   

# Author 
[Aafaq Ahmad Mir](https://miraafaq.in)
