<?php

include_once "includes/css_js.inc.php";
include "includes/db.inc.php";
include "includes/funcs.inc.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

requiredLoggedOut();
$errors = [];

if (isset($_POST['register_submit'])) {
    $passwordRegex = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/";

    if (!strlen($_POST['register_email'])) $errors[] = "Please enter an email...";
    elseif (!filter_var($_POST['register_email'], FILTER_VALIDATE_EMAIL)) $errors[] = "Please enter a valid email address...";
    elseif (checkEmail($_POST['register_email'])) $errors[] = "Email already exists, try logging in instead...";
    if (!strlen($_POST['register_password'])) $errors[] = "Please enter a password...";
    elseif (!preg_match($passwordRegex, $_POST['register_password']) && strlen($_POST['register_password']) > 45) $errors[] = "Please enter a valid, secure password...";
    elseif (!strlen($_POST['register_password_confirm']) && $_POST['register_password'] !== $_POST['register_password_confirm']) $errors[] = "Please confirm password...";

    if (!count($errors)) {
        $newUUID = register($_POST['register_email'], $_POST['register_password']);
        if (!$newUUID) $errors[] = "Something went wrong...";
        else {
            logIn($newUUID);
            $_SESSION['messages'][] = ['type' => 'notif', 'content' => 'Successfully registered!'];

            header("Location: index.php");
            exit;
        }
    }
}


// echo '<pre>';
// print_r($cssPath);
// echo '<pre>';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SavePoint Register</title>
    <link rel="stylesheet" href="dist/<?= $cssPath ?>" />

</head>

<body>
    <?php include("includes/header.inc.php"); ?>
    <main>
        <section id="loginform">
            <form action="user_register.php" method="POST">
                <h3>Register</h3>
                <ul id="error_messages"></ul>
                <label for="register_email">Email *:</label><input type="text" name="register_email">
                <label for="register_password">Password *:</label>
                <div id="password_validation"></div>
                <input type="text" name="register_password">
                <label for="register_password_confirm">Confirm password *:</label><input type="text" name="register_password_confirm">
                <input type="submit" value="register" name="register_submit">
                <a href="user_login.php">Already have an account? Log in!</a>
            </form>
        </section>

    </main>
    <?php include("includes/footer.inc.php"); ?>
</body>

</html>