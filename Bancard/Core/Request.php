<?php

namespace LlevaUno\Bancard\Core;

use LlevaUno\Bancard\Core\Config;
use Closure;

class Request
{
    private $token;
    private $shop_process_id;
    private $response_data;

    protected $environment;
    protected $path;
    
    public $url;

    public $redirect_to;

    public $public_key;
    public $operation = array();
    public $data = array();

    public $response;

    protected function __construct()
    {
        $this->getPublicKey();
    }

    protected function getToken($type)
    {
        $this->token = Token::create(
            $type,
            $this->data['shop_process_id'],
            $this->data
        );
    }

    private function getPublicKey()
    {
        $this->public_key = Config::get("public_key");
    }

    public function addData($key, $value)
    {
        $this->data[$key] = $value;
    }

    protected function makeOperationObject()
    {
        $this->operation['public_key'] = $this->public_key;
        $this->operation['operation'] = array();
        $this->operation['operation']['token'] = $this->token->get();
        $this->operation['operation']['shop_process_id'] = $this->shop_process_id;
        foreach ($this->data as $key => $value) {
            $this->operation['operation'][$key] = $value;
        }
    }

    protected function post()
    {
        $this->url = $this->environment . $this->path;
        $this->response_data = HTTP::post($this->url, $this->json());

        if (!$this->response_data) {
            
            throw new InvalidHTTPDataException("No response data was found.");
        }
        
        $this->response = $this->response();
        
        if ($this->response->status == "error") {
            $class = $this->response->message->key . "Exception";
            if (class_exists("\\LlevaUno\\Bancard\\Core\\Exceptions\\" . $class)) {
                throw new $class;
            } else {
                throw new Exception("Unknow exception raised");
            }
        }
        
        $this->redirect_to = $this->environment . Config::get("redirect_path") . "?process_id=" . $this->response()->process_id;
        return true;
    }

    public function get()
    {
        return $this->operation;
    }

    public function json()
    {
        return json_encode($this->operation);
    }

    public function response()
    {
        return json_decode($this->response_data);
    }

    public function send()
    {
        $this->post();
        return $this;
    }
}
