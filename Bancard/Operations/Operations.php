<?php

namespace LlevaUno\Bancard\Operations;

/**
 *
 * Operation class that stores operations url paths.
 *
 **/

class Operations
{
    // Single buy operations.
    const SINGLE_BUY_URL = "/vpos/api/0.3/single_buy";
    const SINGLE_BUY_ROLLBACK_URL = "/vpos/api/0.3/single_buy/rollback";
    // Preauthorization operations.
    const PREAUTHORIZATION_URL = "/vpos/api/0.3/preauthorizations";
    const PREAUTHORIZATION_ROLLBACK_URL = "/vpos/api/0.3/preauthorizations/rollback";
    const PREAUTHORIZATION_CONFIRM_URL = "/vpos/api/0.3/preauthorizations/confirm";
    const PREAUTHORIZATION_CANCEL_URL = "/vpos/api/0.3/preauthorizations/abort";
    const PREAUTHORIZATION_CONFIRM_ROLLBACK_URL = "/vpos/api/0.3/preauthorizations/rollback-confirm";
}
