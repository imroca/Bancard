<?php

namespace Bancard\Bancard\Core;

use Bancard\Bancard\Core\Config;

use Closure;

/**
 *
 * Request class that handles all VPOS operations.
 *
 **/

class Request
{
    private $token;
    private $shop_process_id;
    private $response_data;

    protected $environment;
    protected $path;
    protected $redirect_path;

    public $url;

    public $redirect_to;

    public $public_key;
    public $operation = array();
    public $data = array();

    public $response;

    /**
     *
     * Get valid token for given operation type.
     *
     * @param $type Type of operation.
     *
     * @return void
     *
     **/

    protected function getToken($type)
    {
        $this->token = Token::create(
            $type,
            $this->data['shop_process_id'],
            $this->data
        );
    }

    /**
     *
     * Get configured public key.
     *
     * @return void
     *
     **/

    private function getPublicKey()
    {
        if (!empty($this->data['public_key'])) {
            $this->public_key = $this->data['public_key'];
        }
        if (empty($this->public_key)) {
            $this->public_key = Config::get('public_key');
        }
        return $this->public_key;
    }

    /**
     *
     * Fill data array with values that then will turn into a json.
     *
     * @return void
     *
     **/


    public function addData($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     *
     * Prapare operation object with expected structure.
     *
     * @return void
     *
     **/

    protected function makeOperationObject()
    {
        $this->operation['public_key'] = $this->getPublicKey();
        $this->operation['operation'] = array();
        $this->operation['operation']['token'] = $this->token->get();
        $this->operation['operation']['shop_process_id'] = $this->shop_process_id;
        foreach ($this->data as $key => $value) {
            if ($key == "public_key" or $key == "private_key") {
                continue;
            }
            $this->operation['operation'][$key] = $value;
        }
    }

    /**
     *
     * Prepare url and post data to Bancard configured enviroment url.
     * If successful sets up redirect url.
     * Raise exception on error.
     *
     * @return bool
     *
     **/

    protected function post()
    {
        $this->url = $this->environment . $this->path;
        $this->response_data = HTTP::post($this->url, $this->json());

        if (!$this->response_data) {
            throw new \RuntimeException("No response data was found.");
        }

        $this->response = $this->response();

        if ($this->response->status == "error") {
            throw new \Exception("[" . $this->response->messages[0]->key . "] " . $this->response->messages[0]->dsc);
        }

        if (!empty($this->response()->process_id)) {
            $this->redirect_to = $this->environment . $this->redirect_path . "?process_id=" . $this->response()->process_id;
        }

        return true;
    }

    /**
     *
     * Return opeartion object.
     *
     * @return object
     *
     **/

    public function get()
    {
        return $this->operation;
    }

    /**
     *
     * Get json represetation of operation object.
     *
     * @return json
     *
     **/

    public function json()
    {
        return json_encode($this->operation);
    }

    /**
     *
     * Return response object (stdClass).
     *
     * @return void
     *
     **/

    public function response()
    {
        return json_decode($this->response_data);
    }

    /**
     *
     * Post data wrapper.
     *
     * @return void
     *
     **/

    public function send()
    {
        $this->post();
        return $this;
    }
}
