<?php

namespace LlevaUno\Bancard\Operations\PreAuthorization;

use \LlevaUno\Bancard\Core\Config;
use \LlevaUno\Bancard\Core\HTTP;
use \LlevaUno\Bancard\Core\Environments;
use \LlevaUno\Bancard\Operations\Operations;

class PreAuthorization extends \LlevaUno\Bancard\Core\Request
{
    private function validateData(array $data)
    {
        if (array_key_exists('shop_process_id', $data)) {
            return false;
        }

        if (array_key_exists('amount', $data)) {
            return false;
        }

        if (array_key_exists('currency', $data)) {
            return false;
        }

        if (array_key_exists('amount', $data)) {
            return false;
        }

        if (array_key_exists('description', $data)) {
            return false;
        }

        if (array_key_exists('additional_data', $data)) {
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
        $self->path = Operations::PREAUTHORIZATION_URL;
        # Configure extra data.
        $data['return_url'] = Config::get('return_url');
        $data['cancel_url'] = Config::get('cancel_url');
        # Attach data.
        foreach ($data as $key => $value) {
            $self->addData($key, $value);
        }
        # Generate token.
        $self->getToken('pre_authorization');
        # Create operation array.
        $self->makeOperationObject();
        $self->post();
        return $self;
    }
}
