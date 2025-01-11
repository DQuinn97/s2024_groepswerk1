<?php

include_once "includes/css_js.inc.php";
include "includes/db.inc.php";
include "includes/funcs.inc.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


requiredLoggedIn();

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
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SavePoint Profile</title>
    <link rel="stylesheet" href="dist/<?= $cssPath ?>" />
</head>

<body>
    <?php include("includes/header.inc.php"); ?>
    <main>


    </main>
    <?php include("includes/footer.inc.php"); ?>
</body>

</html>