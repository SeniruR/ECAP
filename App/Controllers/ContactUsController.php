<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Database\Database;

class ContactUsController {
    public function index(){
        include __DIR__ . '/../Views/contactus.php';
    }
}