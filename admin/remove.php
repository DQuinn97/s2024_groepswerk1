<?php
require("../includes/db.inc.php");
require("../includes/funcs.inc.php");
include_once "../includes/css_js.inc.php";

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

requiredAdmin();

$errors = [];
$success = false;
$id = (int)@$_GET['id'];
$user = getUserById($id);
$status = $user['status'];
$admin = $user['isAdmin'];

if (isset($_POST['formDelete'])) {
    if ($status === 1) {
        $errors[] = "User status needs to be set to 0 in order to be removed.";
    }
    if ($admin === 1) {
        $errors[] = "User is set as Admin and cannot be removed.";
    }

    if (count($errors) == 0) {
        $success = deleteUser($id);
        header("Location: users.php");
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" integrity="sha384-tViUnnbYAV00FLIhhi3v/dWt3Jxw4gZQcNoSCxCIFNJVCx7/D55/wXsrNIRANwdD" crossorigin="anonymous">
    <meta charset="utf-8">
    <meta name="description" content="My description">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Remove User - SavePoint</title>
</head>

<body>

    <main>

        <?php if (count($errors) > 0): ?>
            <div class="alert alert-danger" role="alert">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif ?>

        <div class="mt-3 mb-3 text-end">
            <a href="users.php">
                <button type="button" class="btn btn-outline-primary">Return</button>
            </a>
        </div>
        <form method="post" action="">
            <div>
                <h1>Are you sure you want to delete user #<?= $user['id']; ?> - <?= $user['displayname']; ?>?<br>This action cannot be undone!</h1>
                <button type="submit" class="btn btn-danger" name="formDelete" style="width: 100%">Delete</button>
            </div>
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>