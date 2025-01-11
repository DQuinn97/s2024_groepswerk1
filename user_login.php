<?php

include_once "includes/css_js.inc.php";
include "includes/db.inc.php";
include "includes/funcs.inc.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


requiredLoggedOut();
$errors = [];

if (isset($_POST['login_submit'])) {
    if (!strlen($_POST['login_email'])) $errors[] = "Please enter email...";
    if (!strlen($_POST['login_password'])) $errors[] = "Please enter password...";

    $UUID = checkUser($_POST['login_email'], $_POST['login_password']);
    if ($UUID) {
        logIn($UUID);
        $_SESSION['messages'][] = ['type' => 'log', 'content' => 'logged in on ' . date("d-m-Y")];

        header("Location: index.php");
        exit;
    } else {
        $errors[] = "Unknown log in credentials...";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SavePoint Login</title>
    <link rel="stylesheet" href="dist/<?= $cssPath ?>" />
</head>

<body>
    <?php include("includes/header.inc.php"); ?>
    <main>
        <section id="loginform">
            <form action="user_login.php" method="POST">
                <h3>Log in</h3>
                <ul id="error_messages"><?php foreach ($errors as $error): ?><li><?= $error ?></li><?php endforeach; ?></ul>
                <label for="login_email">Email:</label><input type="text" name="login_email">
                <label for="login_password">Password:</label><input type="text" name="login_password">
                <input type="submit" value="log in" name="login_submit">
                <a href="user_register.php">Need an account? Register now!</a>
            </form>
        </section>

    </main>
    <?php include("includes/footer.inc.php"); ?>
</body>

</html>