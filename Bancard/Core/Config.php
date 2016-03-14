<?php

namespace Bancard\Bancard\Core;

class Config
{
    const PUBLIC_KEY = "";
    const PRIVATE_KEY = "";
    const RETURN_URL = "";
    const CANCEL_URL = "";

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
