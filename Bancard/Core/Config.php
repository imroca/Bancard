<?php

namespace Bancard\Bancard\Core;

class Config
{
    const PUBLIC_KEY = "******";
    const PRIVATE_KEY = "******";
    const RETURN_URL = "http://www.site.com.py/?confirm";
    const CANCEL_URL = "http://www.site.com.py/?cancel";
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
