<?php

namespace Daleffe\Phalcon\Validation\Validator;

use Phalcon\Messages\Message;
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\AbstractValidator;
use Phalcon\Filter\Validation\Exception as ValidationException;

class AtLeast extends AbstractValidator
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
     * Executes the at least validation
     *
     * @param \Phalcon\Validation $validator
     * @param string $attribute
     * @return boolean
     */
    public function validate(Validation $validator, $attribute): bool
    {
    	if (in_array($attribute, $this->fields) === true) {
    		$response = false;

    		foreach ($this->fields as $field) {
                // Check if field is array
                if (strpos($field,'[]')) $field = str_replace('[]','',$field);

                $value = $validator->getValue($field);

                if (is_array($value)) $value = array_filter($value);

                if ((($value != '') and !is_null($value) and !is_array($value)) or (is_array($value) and count($value) > 0)) {
                    $response = true;
                    break;
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
