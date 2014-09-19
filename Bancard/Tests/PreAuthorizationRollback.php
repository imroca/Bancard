<?php

require_once(__DIR__ . '/../autoload.php');

# use LlevaUno\Bancard\Config\Config;
# use LlevaUno\Bancard\Operations\PreAuthorization;

$data = [
    'shop_process_id'   => 123
];

$rollback = LlevaUno\Bancard\Operations\PreAuthorization\Rollback::send($data);
var_dump($rollback->json());
var_dump($rollback->response());
