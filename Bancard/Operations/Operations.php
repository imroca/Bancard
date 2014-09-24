<?php

namespace LlevaUno\Bancard\Operations;

class Operations
{
    const PREAUTHORIZATION_URL = "/vpos/api/0.3/preauthorizations";
    const PREAUTHORIZATION_ROLLBACK_URL = "/vpos/api/0.3/preauthorizations/rollback";
    const PREAUTHORIZATION_CONFIRM_URL = "/vpos/api/0.3/preauthorizations/confirm";
    const PREAUTHORIZATION_CANCEL_URL = "/vpos/api/0.3/preauthorizations/abort";
    const PREAUTHORIZATION_CONFIRM_ROLLBACK_URL = "/vpos/api/0.3/preauthorizations/rollback-confirm";
}
