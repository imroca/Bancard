# LlevaUno

> LlevaUno nace a finales del 2010 siendo el primer sitio web de compras grupales que te permite obtener grandes descuentos y descubrir nuevas formas de disfrutar de Asuncion.

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

$id = $redis->incr("LlevaUno:Bancard:shop_process_id");

$data = [
    'shop_process_id'   => $id,
    'amount'            => $_POST['amount'],
    'currency'          => 'PYG',
    'additional_data'   => '',
    'description'       => $_POST['description']
];

try {
    $request = LlevaUno\Bancard\Operations\PreAuthorization\PreAuthorization::init($data)->send();
} catch (Exception $e) {
    die($e->getMessage());
}

var_dump($request);

```