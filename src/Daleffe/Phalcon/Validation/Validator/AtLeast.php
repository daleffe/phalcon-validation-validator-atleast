<?php

namespace Daleffe\Phalcon\Validation\Validator;

use Phalcon\Validation\Validator;
use Phalcon\Validation\Message;
use Phalcon\Validation\Exception as ValidationException;
use Phalcon\Validation;

class AtLeast extends Validator
{
    private $fields;

    /**
     * Class constructor.
     *
     * @param  array $options
     * @throws ValidationException
     */
    public function __construct(array $options = array())
    {
        parent::__construct($options);

        if (!$this->hasOption('fields')) {
        	throw new ValidationException('Validator require fields array to be set');
        } else {
        	$this->fields = $options['fields'];
        }
    }

    /**
     * Executes the uniqueness validation
     *
     * @param  \Phalcon\Validation $validator
     * @param  string $attribute
     * @return boolean
     */
    public function validate(Validation $validator, $attribute)
    {
    	if (in_array($attribute, $this->fields) === true) {
    		$response = false;

    		foreach ($this->fields as $field) {
    			if ($validator->getValue($field) != "" and !is_null($validator->getValue($field))) {
    				$response = true;
    			}
    		}

    		if ($response === false) {
    			$message = ($this->hasOption('message') === false ? 'At least one field must be filled' : $this->getOption('message'));

    			$validator->appendMessage(new Message($message, $attribute, 'AtLeast'));
    		}

    	} else {
    		throw new ValidationException('Field that call validation not found in fields list to be validated');
    	}

    	return $response;
    }
}
?>
