<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Database\Database;
use App\Models\adm_m;

session_start();

class LoginController {
    public function processLogin() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;

            if ($email && $password) {
                $database = new Database();
                $userModel = new UserModel($database);
                $adm_m = new adm_m($database);
                if($userData = $userModel->getUserDataByEmail($email,$database)){
                    if ($userData && password_verify($password, $userData['pass'])) {
                        $_SESSION['username'] = $email;
                        $_SESSION['Logged_in'] = true;
                        header("Location: ../public/index.php");
                        exit();
                    } else {
                        $_SESSION['error'] = 'Incorrect Username or Password!';
                        header("Location: ../public/index.php?url=Login");
                        exit();
                    }
                } else if($userData = $adm_m->getUserDatabyEmail($email,$database)){
                    if ($userData && password_verify($password, $userData['adm_p'])) {
                        $_SESSION['admin_logged_in'] = true;
                        $_SESSION['Logged_in'] = true;
                        header("Location: ../public/index.php?url=adm_da");
                        exit();
                    } else {
                        $_SESSION['error'] = 'Incorrect Username or Password!';
                        header("Location: ../public/index.php?url=Login");
                        exit();
                    }
                } else {
                    $_SESSION['error'] = 'Incorrect Username or Password!';
                    header("Location: ../public/index.php?url=Login");
                    exit();
                }
            } else {
                $_SESSION['error'] = 'Please enter both username and password!';
                header("Location: ../public/index.php?url=Login");
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

    public function logout() {
        session_destroy();
        header("Location: ../public/index.php?url=Login");
        exit();
    }
}
