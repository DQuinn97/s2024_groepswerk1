<?php
require("../includes/db.inc.php");
include_once "../includes/css_js.inc.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
    <link rel="icon" href="https://via.placeholder.com/70x70">
    <link rel="stylesheet" href="https://unpkg.com/mvp.css">

    <meta charset="utf-8">
    <meta name="description" content="My description">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Remove User - SavePoint</title>
</head>

<body>
    <header><img src="" alt="logo">
        <nav>
            <ul>
                <li><a href="#">New Releases</a></li>
                <li><a href="#">Categories</a></li>
                <li><a href="#">My Lists</a></li>
            </ul>
            <div id="notification"></div>
            <div id="profile"></div>
        </nav>
    </header>

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
                <button type="submit" class="btn btn-primary" name="formDelete" style="width: 100%">Delete</button>
            </div>
        </form>
    </main>

    <footer>
        <section>
            <p>SavePoint Gaming Database</p>
            <ul>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </section>
        <section>
            <p>Stay in touch! Subscribe to our Newsletter!</p>
            <form action=""><input type="text" name="sub_email" id="sub_email"><input type="submit" value="sub_submit" id="sub_submit"></form>
        </section>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>