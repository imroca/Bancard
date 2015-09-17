<?php

namespace Bancard\Bancard\Core;

/**
 *
 * HTTP class.
 *
 **/

class HTTP
{
    /**
     *
     * Send POST data to url.
     *
     **/
    public static function post($url, $data)
    {
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
    /**
     *
     * Read data sent by POST.
     *
     **/
    public static function read()
    {
        $data = file_get_contents("php://input");
        return $data;
    }
}
