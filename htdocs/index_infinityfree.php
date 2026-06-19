<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Check If The Application Is Under Maintenance
|--------------------------------------------------------------------------
|
| MODIFIED FOR INFINITYFREE DEPLOYMENT
| Core Laravel files are placed in /cbt_core/ (one level above htdocs)
| This public/index.php goes inside /htdocs/
|
*/

if (file_exists($maintenance = __DIR__.'/../cbt_core/storage/framework/maintenance.php')) {
    require $maintenance;
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Path diubah untuk mengarah ke folder cbt_core
| yang berada sejajar dengan htdocs di server InfinityFree
|
*/

require __DIR__.'/../cbt_core/vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
*/

$app = require_once __DIR__.'/../cbt_core/bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
