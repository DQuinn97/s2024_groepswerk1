<?php
require("../includes/db.inc.php");
require("../includes/funcs.inc.php");
include_once "../includes/css_js.inc.php";

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

requiredAdmin();

$users = getAllUsers();

?>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" integrity="sha384-tViUnnbYAV00FLIhhi3v/dWt3Jxw4gZQcNoSCxCIFNJVCx7/D55/wXsrNIRANwdD" crossorigin="anonymous">
    <meta charset="utf-8">
    <meta name="description" content="My description">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>User Management - SavePoint</title>
</head>

<body>
    <div class="container">

        <main>

            <div class="mt-3 mb-3 text-end">
                <a href="create.php">
                    <button type="button" class="btn btn-outline-primary">Create new user</button>
                </a>
            </div>

            <div class="table-responsive small">
                <table class="table table-hover table-striped table-sm">
                    <thead>
                        <tr>
                            <th scope="col">User Management</th>
                            <th scope="col">#ID</th>
                            <th scope="col">Display Name</th>
                            <th scope="col">Email Address</th>
                            <th scope="col">Date of Birth</th>
                            <th scope="col">Status</th>
                            <th scope="col">Admin</th>
                            <th scope="col">Created</th>
                            <th scope="col">Updated</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($users as $user): ?>

                            <tr>
                                <td><a href="manage.php?id=<?= $user['id'] ?>"><button type="button" class="btn btn-primary">Manage</button></a>
                                    <a href="remove.php?id=<?= $user['id'] ?>"><button type="button" class="btn btn-danger">Remove</button>
                                </td>
                                <td><?= $user['id']; ?></td>
                                <td><?= $user['displayname']; ?></td>
                                <td><?= $user['email']; ?></td>
                                <td><?= $user['dateofbirth']; ?></td>
                                <td><?= $user['status']; ?></td>
                                <td><?= $user['isAdmin']; ?></td>
                                <td><?= $user['created']; ?></td>
                                <td><?= $user['updated']; ?></td>
                            </tr>

                        <?php endforeach; ?>


                    </tbody>
                </table>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>