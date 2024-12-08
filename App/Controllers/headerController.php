<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Database\Database;

class HeaderController {
    public function index(){
        include __DIR__ . '/../Views/header.php';
    }

    public function About(){
        include __DIR__ . '/../Views/about.php';
    }
}