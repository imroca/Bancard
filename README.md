
# Esta librería es un buen comienzo pero no incluye toda la funcionalidad necesaria para certificar para la version del VPOS 2.0

# Bancard

> Bancard S.A. es una empresa de apoyo al sector financiero, cuyos accionistas y clientes son las más importantes instituciones financieras del país, entre ellas Bancos Internacionales, Regionales y Nacionales, además de Financieras, Cooperativas y Procesadoras de tarjetas de crédito.

## Cliente

Implementacion en PHP para consumir el servicio de eCommerce de Bancard o vPOS.
*Nota:* Este cliente es para la v1 del servicio. Actualmente existe vPOS v2.0.

## Modo de uso

Este cliente fue desarrollado con el fin de ser 100% agnóstico.

¿Esto que significa?

No utilíza librerías externas para realizar llamadas al api de bancard.
No depende de ninguna base de datos.

La idea detrás de esto es hacer algo que se pueda implemetar en cualquier proyecto PHP.

En conclusión solo se encarga de cosumir los servicios de bancard y la persistencia de datos depende del gusto del desarrollador.

## ¿Como esta hecho?

El cliente esta hecho (o trata al menos) siguiendo las recomendaciones de http://www.php-fig.org/psr/ especificamente:

* PSR-1
* PSR-2
* PSR-4

## Operaciones

* SingleBuy.
* SingleBuy rollback.
* Preautorizacion.
* Preautorizacion rollback.
* Preautorizacion confirm.
* Preautorizacion abort.
* Preautorizacion confirm rollback.

# Ejemplo

A pedido del público :+1: un ejemplo.

### Ejemplo para una operación de SingleBuy

1) Configurar el archivo de configuracion en Bancard/Core/Config.php (si hubiera necesidad).

2) Iniciar el flujo de compra

```php

require_once(__DIR__ . '/../Bancard/autoload.php');

$redis = new Redis();
$redis->pconnect('127.0.0.1', 6379);

$id = $redis->incr("Bancard:Bancard:shop_process_id");

$amount = number_format($_POST['amount'], 2, ".", "");

$data = [
    'shop_process_id'   => $id,
    'amount'            => $amount,
    'currency'          => 'PYG',
    'additional_data'   => '',
    'description'       => $_POST['description']
    // Optional: sobre escribir variables.
    // 'private_key'       => "##########",
    // 'public_key'        => "##########",
    // 'return_url'        => "http://example.com/thankyou?id={$id}",
    // 'cancel_url'        => "http://example.com/cancel?id={$id}"
];

if ($_POST['sandbox']) {
    $env = Bancard\Bancard\Core\Environments\Environments::STAGING_URL;
} else {
    $env = Bancard\Bancard\Core\Environments\Environments::PRODUCTION_URL;
}

try {
    $singlebuy = Bancard\Bancard\Operations\SingleBuy\SingleBuy::init($data, $env)->send();
} catch (Exception $e) {
    die($e->getMessage());
}

header("Location: " . $singlebuy->redirect_to;
die();

```

3) En la página de bancard configurar cual es el endpoint en nuestro sitio con el cual confirmaremos la transacción.
Este paso no tiene nada que ver con el cliente, pero sí con el flujo de pago, más información en la documentación de bancard.
A modo informativo dejo un ejemplo.

Ej.: https://example.com/confirm

```php

if ($_SERVER['REQUEST_METHOD'] != "POST") {
    http_response_code(403);
    exit;
}

try {
    $post = json_decode(file_get_contents('php://input'));
} catch (Exception $e) {
    http_response_code(403);
    exit;
}

if (empty($post)) {
    http_response_code(403);
    exit;
}

$transaction = get_transaction_automagically($post->operation->shop_process_id);
$amount = number_format($transaction->amount, 2, ".", "");

if ($amount !== $post->operation->amount) {
    http_response_code(403);
    exit;
}

// Hacer algo con esta info
$transaction->complete($post->operation);

http_response_code(200);
header('Content-type: application/json');
echo json_encode([
    "status" => "success",
    "message" => "Su pago ha sido procesado",
    "developer_message" => "Operation confirmed"]);
exit;

```

4) Bancard redirige a la página que configuramos en `return_url`.

5) Bancard en el caso que un usuario haya dado click en el boton de cancelar, retorna al cancel_url, ningun misterio ahí.

6) Rollbacks.

```php

include_once('bancard/Bancard/autoload.php');

$transaction = get_transaction_automagically($_GET['id']);

$data = [
    'shop_process_id'   => $transaction->id,
    // Optional: override variables.
    // 'private_key'       => "##########",
    // 'public_key'        => "##########"
];

if ($_POST['sandbox']) {
    $env = Bancard\Bancard\Core\Environments::STAGING_URL;
} else {
    $env = Bancard\Bancard\Core\Environments::PRODUCTION_URL;
}

try {
    $rollback = Bancard\Bancard\Operations\SingleBuy\Rollback::init($data, $env)->send();
} catch (Exception $e) {
    die($e->getMessage());
}

var_dump($rollback);

// Hacer algo con esta info.
$transaction->rollback($rollback);


exit;

```

## Integraciones

* Llevauno (solo sandbox para las operaciones de pre autorización)
* ~~Woocommerce, plugin desarrollado para integrar pagos de bancard utilizando la operación SingleBuy. El plugin está a la venta. :stuck_out_tongue_winking_eye:~~

El plugin de woocomerce utiliza esta librería como dependencia y como mencioné anteriormente este cliente es para la v1 de la pasarela de Bancard. La v2 tiene una arquitectura completamente diferente por lo que tristemente les recomiendo que busquen alternativas a este repositorio.

## Pull Request & Contribuciones.

Los PR son bienvenidos, ademas de las cervezas, asados, picadas y/o similares.

## Developer

Ignacio Rojas :sunglasses:

* La completamente inútil web: http://imroca.com
* Email <<imroca@gmail.com>>
* [LinkedIn](https://www.linkedin.com/in/imroca)
* Twitter: [@iMalignus](https://twitter.com/iMalignus/)

Cualquier duda a las ordenes.
