# Phalcon Forms
## Validator - At Least
Validator to check for at least one of the selected fields filled.

### Installation
Update your composer.json with following options:
```
{
	"repositories": [
		{
			"type": "vcs",
			"url": "https://github.com/daleffe/phalcon-validation-validator-atleast"
		}
	],
    "require": {
		  "daleffe/phalcon-validation-validator-atleast": "dev-master",
    }
}
```
> I will check how to put this package in Packagist.org.

### Usage
In your forms class use:
``` php
use Daleffe\Phalcon\Validation\Validator\AtLeast;

$main_phone->addValidators(array(
	new AtLeast(array('message' => $this->translate->_("at_least_one_phone_is_required"), 
					  'fields' => array('main_phone','alternative_phone'))
				)
));