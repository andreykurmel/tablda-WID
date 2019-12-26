<?php
header('Access-Control-Allow-Origin: *');


//LARAVEL
define('LARAVEL_START', microtime(true));
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
//---
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);
//--
require_once __DIR__.'/DataReceiver.php';


//added in Laravel
if (auth()->id()) {
    setcookie('stim_user_id', auth()->id());
}
//

$dbType = "local2DO";
// $dbType = "DO";
// $dbType = "MAMPLocal";

//$accessType = 'debug';
$accessType = 'production';

switch($dbType) {
    case 'local2DO':
        define('DB_NAME', env('APP_DB_NAME', 'app_e3c_bc_sitelok'));
        define('DB_CALC_NAME', env('APP_DB_CALC_NAME', 'app_e3c_calculations'));
        define('DB_WID_NAME', env('APP_DB_WID_NAME', 'app_e3c_wid'));
        define('DB_BA_NAME', env('APP_DB_BA_NAME', 'app_e3c_ba'));
        define('DB_PC_NAME', env('APP_DB_PC_NAME', 'app_e3c_pc'));
        define('DB_SITELOK_NAME', env('APP_DB_SHARED_NAME', 'app_e3c_shared'));
        define('DB_SHARED_NAME', env('APP_DB_SHARED_NAME', 'app_e3c_shared'));
        define('DB_QUIZ_NAME', env('APP_DB_QUIZ_NAME', 'app_e3c_quiz'));

        define('DB_HOSTNAME', env('DB_HOST', '127.0.0.1'));
        define('DB_USERNAME', env('DB_USERNAME', 'root'));
        define('DB_PASSWORD', env('DB_PASSWORD', ''));

        define('HOST_NAME', env('APP_URL', 'http://e3c.tablda.loc'));
        define('SUB_DIR', env('APP_URL', 'http://e3c.tablda.loc'));
        break;
}
