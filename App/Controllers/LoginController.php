<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Database\Database;

session_start();

class LoginController {
    public function processLogin() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;
    
            if ($email && $password) {
    
                $database = new Database();
                $userModel = new UserModel($database);
                $userData = $userModel->getUserData($email, $password, $database);
    
                if ($userData) {
                    $_SESSION['username'] = $email;
                    header("Location: ../public/index.php");
                    exit();
                } else {
                    $_SESSION['username'] = $username;
                    $_SESSION['error'] = 'Incorrect Username or Password!';
                    header("Location: ../public/index.php?url=login.php");
                    exit();
                }
            } else {
                $_SESSION['error'] = 'Please enter both username and password!';
                header("Location: ../public/index.php?url=login.php");
                exit();
            }
        } else {
            $this->form();
        }
    }
    

    public function form() {
        $error = $_SESSION['error'] ?? null;
        include __DIR__ . '/../Views/loginform.php';
    }

    public function index(){
        include __DIR__ . '/../Views/index.php';
    }
}
