<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Database\Database;

class footerController {
    public function index(){
        include __DIR__ . '/../Views/footer.php';
    }
}