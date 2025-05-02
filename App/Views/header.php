<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="./css/header.css">
</head>
<header>
    <div class="headerbody">
        <a href="home" target="_parent"><img src="./images/logo-land.png" alt="logo"></a>
        <div class="buttons">
            <?php if(isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']): ?>
                <a href="adm_da" class="button">Dashboard</a>
            <?php endif; ?>
            <?php if(isset($_SESSION['Logged_in']) && $_SESSION['Logged_in']): ?>
                <a href="Logout" class="button">Logout</a>
            <?php else: ?>
                <a href="Login" class="button">Login</a>
            <?php endif; ?>
            <a href="About" class="button">About</a>
            <a href="ContactUs" class="button">Contact Us</a>
        </div>
    </div>
</header>
