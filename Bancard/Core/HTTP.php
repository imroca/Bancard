<?php

namespace LlevaUno\Bancard\Core;

class HTTP 
{
    public static function post($url, $data)
    {
        var_dump($data);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($curl);
        if ($response === false) {
            $info = curl_getinfo($curl);
            curl_close($curl);
            return $info;
        }
        curl_close($curl);
        return $response;
    }

    public static function read()
    {
        if ($_SERVER['REQUEST_METHOD'] != "POST") {
            return false;
        }

        $data = file_get_contents("php://input");

        if (empty($data)) {
            return false;
        }

        return $data;
    }
}
