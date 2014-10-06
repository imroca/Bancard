<?php

namespace LlevaUno\Bancard\Core;

class Config
{
    const PUBLIC_KEY = "vHRE8WvNhdnuQ7Am5uUkDcN9fEP4Wt59";
    const PRIVATE_KEY = "oHDvtjWDEuHJ604JV6NIhSJfXZFzvcNpd,mHF6v.";
    const RETURN_URL = "http://www.llevauno.com.py/bancard/test/preauthorization?confirm";
    const CANCEL_URL = "http://www.llevauno.com.py/bancard/cancel";
    const REDIRECT_PATH = "/payment/preauthorization";
    
    /**
     *
     * Get defined configuration constants.
     *
     */

    public static function get($key)
    {
        return constant(strtoupper('self::' . $key));
    }
}
