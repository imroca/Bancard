<?php

namespace LlevaUno\Bancard\Core\Exceptions;

class InvalidArgumentCountException extends \InvalidArgumentException {}
class InvalidHTTPDataException extends \RuntimeException {}

class InvalidJsonError extends \RuntimeException {}
class UnauthorizedOperationError extends \RuntimeException {}
class ApplicationNotFoundError extends \RuntimeException {}
class InvalidPublicKeyError extends \RuntimeException {}
class InvalidTokenError extends \RuntimeException {}
class InvalidOperationError extends \RuntimeException {}
class BuyNotFoundError extends \RuntimeException {}
class PaymentNotFoundError extends \RuntimeException {}
class AlreadyRollbackedError extends \RuntimeException {}
class RollbackSuccessful extends \RuntimeException {}
class PreauthorizationAlreadyAbortedError extends \RuntimeException {}
class PreauthorizationAlreadyConfirmedError extends \RuntimeException {}

class PreauthorizationCannotBeConfirmedError extends \RuntimeException {}

class PreauthorizationCannotBeAbortedError extends \RuntimeException {}
