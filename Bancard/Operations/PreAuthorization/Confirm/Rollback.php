<?php

namespace LlevaUno\Bancard\Operations\PreAuthorization\Confirm;

use \LlevaUno\Bancard\Core\Config;
use \LlevaUno\Bancard\Core\HTTP;
use \LlevaUno\Bancard\Core\Environments;
use \LlevaUno\Bancard\Operations\Operations;

/**
 *
 * Preauthorization confirm rollback operation.
 *
 **/

class Rollback extends \LlevaUno\Bancard\Core\Request
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
        if (count($data) != 1) {
            throw new \InvalidArgumentException("Invalid argument count (5 values are expected).");
        }
        
        if (!array_key_exists('shop_process_id', $data)) {
            throw new \InvalidArgumentException("Shop process id not found [shop_process_id].");
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
        $self->path = Operations::PREAUTHORIZATION_CONFIRM_ROLLBACK_URL;
        # Attach data.
        foreach ($data as $key => $value) {
            $self->addData($key, $value);
        }
        # Generate token.
        $self->getToken('pre_authorization_rollback_confirm');
        # Create operation array.
        $self->makeOperationObject();
        $self->post();
        return $self;
    }
}
