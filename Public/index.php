<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../app/Database/Database.php';
require __DIR__ . '/../app/Models/UserModel.php';
require __DIR__ . '/../app/Controllers/LoginController.php';
require __DIR__ . '/../app/Controllers/HeaderController.php';

use App\Database\Database;
use App\Controllers\LoginController;
use App\Controllers\HeaderController;

$database = new Database();
$db = $database->getConnection();

$lcontroller = new LoginController($database);
$hcontroller = new HeaderController($database);

$url = isset($_GET['url']) ? $_GET['url'] : '';
$hcontroller->index();
switch ($url) {
    case 'login.php':
        $lcontroller->form();
        break;
    case 'processlogin':
        $lcontroller->processLogin();
        break;
    default:
        $lcontroller->index();
        break;
}
?>
