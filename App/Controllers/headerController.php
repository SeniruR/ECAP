<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Database\Database;

class HeaderController {
    public function index(){
        include __DIR__ . '/../Views/header.php';
    }
}