<?php

namespace LlevaUno\Bancard\Core;

class Token
{
    private $type;
    private $private_key;
    private $shop_process_id;
    private $data;
    private $unhashed_string = "";
    private $hash;

    private function __construct($type, $shop_process_id, $data)
    {
        $this->type = $type;
        $this->getPrivateKey();
        $this->shop_process_id = $shop_process_id;
        $this->data = $data;
        $this->make();
        $this->hash();
        var_dump($this->unhashed_string);
        var_dump($this->hash);
    }

    private function getPrivateKey()
    {
        $this->private_key = Config::get('private_key');
    }

    private function make()
    {
        if ($this->type == "pre_authorization") {
            $this->unhashed_string .= $this->private_key;
            $this->unhashed_string .= $this->shop_process_id;
            $this->unhashed_string .= $this->data['amount'];
            $this->unhashed_string .= $this->data['currency'];
        }

        if ($this->type == "pre_authorization_rollback") {
            $this->unhashed_string .= $this->private_key;
            $this->unhashed_string .= $this->shop_process_id;
            $this->unhashed_string .= "rollback";
            $this->unhashed_string .= "0.00";
        }

        if ($this->type == "pre_authorization_confirm") {
            $this->unhashed_string .= $this->private_key;
            $this->unhashed_string .= $this->shop_process_id;
            $this->unhashed_string .= "confirm";
        }

        if ($this->type == "pre_authorization_abort") {
            $this->unhashed_string .= $this->private_key;
            $this->unhashed_string .= $this->shop_process_id;
            $this->unhashed_string .= "pre-authorization-abort";
        }

        if ($this->type == "pre_authorization_client_confirm") {
            $this->unhashed_string .= $this->private_key;
            $this->unhashed_string .= $this->shop_process_id;
            $this->unhashed_string .= "pre-authorization-client-confirm";
            $this->unhashed_string .= $this->data['amount'];
            $this->unhashed_string .= $this->data['currency'];
        }
    }

    private function hash()
    {
        $this->hash = md5($this->unhashed_string);
    }

    public static function create($type, $shop_process_id, $data = array())
    {
        $self = new self($type, $shop_process_id, $data);
        return $self;
    }

    public function get()
    {
        return $this->hash;
    }
}
