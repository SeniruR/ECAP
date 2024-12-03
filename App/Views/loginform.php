<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="./css/loginformstyle.css">
</head>
<body>
    <div class="main">
        <div class="main_box">
            <div>
                <div class="leftside">
                    <h1 style="color:rgb(34, 139, 34);">Welcome to ECAP</h1>
                    <h3>Explore our range of eco-friendly products and join us in making the world a greener place.</h3>
                    <h5>Log in to access your personalized shopping experience and start your journey towards a sustainable lifestyle.</h5>
                </div>
            </div>
            <hr>
            <div class="rightside">
                <h2>Login</h2>
                <form name="login" action="index.php?url=processlogin" method="post">
                    <table>
                        <tr>
                            <td><label for="email">Email</label></td>
                            <td><input type="text" id="email" name="email" placeholder="Enter your Email"></td>
                        </tr>
                        <tr>
                            <td><label for="password">Password</label></td>
                            <td><input type="password" id="password" name="password" placeholder="Enter your Password"></td>
                        </tr>
                        <tr class="button">
                            <td colspan="2"><button type="submit">Login</button></td>
                        </tr>
                        <?php if (isset($_SESSION['error'])) { ?>
                            <tr>
                                <td colspan="2"><p style="color: red; text-align: center"><?php echo $_SESSION['error']; ?></p></td>
                            </tr>
                        <?php } ?>
                    </table>
                    <p>If you haven't signed up yet? <a href="signin.php">Sign Up</a></p>
                    <p><a href="forgetpassword.php">Forget Password</a></p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
