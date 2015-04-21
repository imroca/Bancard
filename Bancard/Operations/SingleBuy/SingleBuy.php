<?php

namespace LlevaUno\Bancard\Operations\SingleBuy;

use \LlevaUno\Bancard\Core\Config;
use \LlevaUno\Bancard\Core\HTTP;
use \LlevaUno\Bancard\Core\Environments;
use \LlevaUno\Bancard\Operations\Operations;

/**
 *
 * Cancel operation.
 *
 **/

class SingleBuy extends \LlevaUno\Bancard\Core\Request
{

    /**
     *
     * Validates data
     *
     * @return void
     *
     **/

    private function validateData(array $data)
    {

        if (count($data) != 5) {
            throw new \InvalidArgumentException("Invalid argument count (5 values are expected).");
        }

        if (!array_key_exists('shop_process_id', $data)) {
            throw new \InvalidArgumentException("Shop process id not found [shop_process_id].");
        }

        if (!array_key_exists('amount', $data)) {
            throw new \InvalidArgumentException("Amount argument was not found [amount].");
        }

        if (!array_key_exists('currency', $data)) {
            throw new \InvalidArgumentException("Currency argument was not found [currency].");
        }

        if (!array_key_exists('description', $data)) {
            throw new \InvalidArgumentException("Description argment was not found [description].");
        }

        if (!array_key_exists('additional_data', $data)) {
            throw new \InvalidArgumentException("Additional data argument was not found [additional_data].");
        }
    }
    
    /**
     *
     * Initialize object
     *
     * @return class
     *
     **/
     
    public static function init(array $data, $environment = Environments::STAGING_URL)
    {
        # Instance.
        $self = new self;
        # Validate data.
        $self->validateData($data);
        # Set Enviroment.
        $self->environment = $environment;
        $self->path = Operations::PREAUTHORIZATION_URL;
        # Configure extra data.
        $data['return_url'] = Config::get('return_url');
        $data['cancel_url'] = Config::get('cancel_url');
        # Attach data.
        foreach ($data as $key => $value) {
            $self->addData($key, $value);
        }
        # Generate token.
        $self->getToken('single_buy');
        # Create operation array.
        $self->makeOperationObject();
        return $self;
    }
}
