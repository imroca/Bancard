<?php

namespace Bancard\Bancard\Operations;

/**
 *
 * Operation class that stores operations url paths.
 *
 **/

class Operations
{
    // Single buy operations url paths.
    const SINGLE_BUY_URL = "/vpos/api/0.3/single_buy";
    const SINGLE_BUY_PAYMENTS_URL = "/payment/single_buy";
    const SINGLE_BUY_ROLLBACK_URL = "/vpos/api/0.3/single_buy/rollback";
    const SINGLE_BUY_CONFIRM_URL = "/vpos/api/0.3/single_buy/confirmations";
    // Preauthorization operations url paths.
    const PREAUTHORIZATION_URL = "/vpos/api/0.3/preauthorizations";
    const PREAUTHORIZATION_PAYMENTS_URL = "/payment/preauthorization";
    const PREAUTHORIZATION_ROLLBACK_URL = "/vpos/api/0.3/preauthorizations/rollback";
    const PREAUTHORIZATION_CONFIRM_URL = "/vpos/api/0.3/preauthorizations/confirm";
    const PREAUTHORIZATION_CANCEL_URL = "/vpos/api/0.3/preauthorizations/abort";
    const PREAUTHORIZATION_CONFIRM_ROLLBACK_URL = "/vpos/api/0.3/preauthorizations/rollback-confirm";
}
