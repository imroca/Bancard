<?php

namespace LlevaUno\Bancard\Operations\PreAuthorization\Confirm;

use \LlevaUno\Bancard\Core\Config;
use \LlevaUno\Bancard\Core\HTTP;
use \LlevaUno\Bancard\Core\Environments;
use \LlevaUno\Bancard\Operations\Operations;

class Confirm extends \LlevaUno\Bancard\Core\Request
{
    private function validateData(array $data)
    {
        if (array_key_exists('shop_process_id', $data)) {
            return false;
        }
    }

    public static function send(array $data, $environment = Environments::STAGING_URL)
    {
        # Instance.
        $self = new self;
        # Validate data.
        $self->validateData($data);
        # Set Enviroment.
        $self->environment = $environment;
        $self->path = Operations::PREAUTHORIZATION_CONFIRM_URL;
        # Attach data.
        foreach ($data as $key => $value) {
            $self->addData($key, $value);
        }
        # Generate token.
        $self->getToken('pre_authorization_confirm');
        # Create operation array.
        $self->makeOperationObject();
        $self->post();
        return $self;
    }
}
