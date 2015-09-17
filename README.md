# Bancard

> Bancard S.A. es una empresa de apoyo al sector financiero, cuyos accionistas y clientes son las más importantes instituciones financieras del país, entre ellas Bancos Internacionales, Regionales y Nacionales, además de Financieras, Cooperativas y Procesadoras de tarjetas de crédito.

## Cliente

Implementacion en PHP para consumir el servicio de eCommerce de Bancard o VPOS.

## Operaciones

* Preautorizacion.
* Preautorizacion rollback.
* Preautorizacion confirm.
* Preautorizacion abort.
* Preautorizacion confirm rollback.

## Usage

```php

require_once(__DIR__ . '/../Bancard/autoload.php');

$redis = new Redis();
$redis->pconnect('127.0.0.1', 6379);

$id = $redis->incr("Bancard:Bancard:shop_process_id");

$data = [
    'shop_process_id'   => $id,
    'amount'            => $_POST['amount'],
    'currency'          => 'PYG',
    'additional_data'   => '',
    'description'       => $_POST['description']
];

try {
    $request = Bancard\Bancard\Operations\PreAuthorization\PreAuthorization::init($data)->send();
} catch (Exception $e) {
    die($e->getMessage());
}

var_dump($request);

```
