<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../app/Database/Database.php';
require __DIR__ . '/../app/Models/UserModel.php';
require __DIR__ . '/../app/Models/ItemModel.php';
require __DIR__ . '/../app/Models/adm_m.php';
require __DIR__ . '/../app/Controllers/LoginController.php';
require __DIR__ . '/../app/Controllers/HeaderController.php';
require __DIR__ . '/../app/Controllers/ContactUsController.php';
require __DIR__ . '/../app/Controllers/MainController.php';
require __DIR__ . '/../app/Controllers/FooterController.php';
require __DIR__ . '/../app/Controllers/admController.php';

use App\Database\Database;
use App\Controllers\LoginController;
use App\Controllers\HeaderController;
use App\Controllers\ContactUsController;
use App\Controllers\MainController;
use App\Controllers\FooterController;
use App\Controllers\admController;

$database = new Database();
$db = $database->getConnection();

$lcontroller = new LoginController($database);
$hcontroller = new HeaderController($database);
$ccontroller = new ContactUsController($database);
$mcontroller = new MainController($database);
$fcontroller = new footerController($database);
$admcontroller = new admController($database);

$url = isset($_GET['url']) ? $_GET['url'] : '';
$type = isset($_GET['type']) ? $_GET['type'] : '';
$hcontroller->index();
switch ($url) {
    case 'Login':
        $lcontroller->form();
        break;
    case 'processlogin':
        $lcontroller->processLogin();
        break;
    case 'ContactUs':
        $ccontroller->index();
        $fcontroller->index();
        break;
    case 'About':
        $hcontroller->About();
        $fcontroller->index();
        break;
    case 'Listall':
        $mcontroller->listall();
        $fcontroller->index();
        break;
    case 'item':
        $mcontroller->item();
        $fcontroller->index();
        break;
    case 'adm_da':
        $admcontroller->adm_da();
        $fcontroller->index();
        break;
    case 'adm_list':
        $admcontroller->adm_list();
        $fcontroller->index();
        break;
    case 'adm_add':
        $admcontroller->adm_add(null);
        $fcontroller->index();
        break;
    case 'adm_types':
        $admcontroller->adm_types(null);
        $fcontroller->index();
        break;
    case 'adm_types_list':
        $admcontroller->adm_types_list();
        $fcontroller->index();
        break;
    case 'process_add_type':
        $admcontroller->process_add_item_type();
        break;
    case 'process_add_item':
        $admcontroller->process_add_item();
        break;
    case 'Logout':
        $lcontroller->logout();
        break;
    case 'adm_changestatus':
        $admcontroller->adm_changestatus();
        break;
    case 'adm_remove':
        $admcontroller->adm_remove();
        break;
    case 'adm_changecatstatus':
        $admcontroller->adm_changecatstatus();
        break;
    case 'adm_remove_type':
        $admcontroller->adm_remove_type();
        break;
    default:
        $mcontroller->index();
        $fcontroller->index();
        break;
}
?>
