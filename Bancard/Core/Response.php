<?php

namespace LlevaUno\Bancard\Core;

use LlevaUno\Bancard\Core\Config;
use Closure;

class Response
{
    private $token;
    private $shop_process_id;
    private $response;

    protected $environment;
    protected $url;

    public $public_key;
    public $operation;
    public $data = array();

    protected function read()
    {
        $this->response = HTTP::read();
    }

    public function get()
    {
        return $this->response;
    }

    public function json()
    {
        return json_decode($this->response);
    }
}
