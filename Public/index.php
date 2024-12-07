<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../app/Database/Database.php';
require __DIR__ . '/../app/Models/UserModel.php';
require __DIR__ . '/../app/Models/ItemModel.php';
require __DIR__ . '/../app/Controllers/LoginController.php';
require __DIR__ . '/../app/Controllers/HeaderController.php';
require __DIR__ . '/../app/Controllers/ContactUsController.php';
require __DIR__ . '/../app/Controllers/MainController.php';
require __DIR__ . '/../app/Controllers/FooterController.php';

use App\Database\Database;
use App\Controllers\LoginController;
use App\Controllers\HeaderController;
use App\Controllers\ContactUsController;
use App\Controllers\MainController;
use App\Controllers\FooterController;

$database = new Database();
$db = $database->getConnection();

$lcontroller = new LoginController($database);
$hcontroller = new HeaderController($database);
$ccontroller = new ContactUsController($database);
$mcontroller = new MainController($database);
$fcontroller = new FooterController($database);

$url = isset($_GET['url']) ? $_GET['url'] : '';
$hcontroller->index();
$fcontroller->index();
switch ($url) {
    case 'Login':
        $lcontroller->form();
        break;
    case 'processlogin':
        $lcontroller->processLogin();
        break;
    case 'ContactUs':
        $ccontroller->index();
        break;
    default:
        $mcontroller->index();
        break;
}
?>
