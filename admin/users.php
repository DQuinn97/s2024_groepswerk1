<?php
require("../includes/db.inc.php");
include_once "../includes/css_js.inc.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$users = getAllUsers();

?>

<head>
    <link rel="icon" href="https://via.placeholder.com/70x70">
    <link rel="stylesheet" href="https://unpkg.com/mvp.css">

    <meta charset="utf-8">
    <meta name="description" content="My description">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>User Management - SavePoint</title>
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
                            <td><a href="manage.php?id=<?= $user['id'] ?>"><button type="button">Manage</button></a>
                                <a href="remove.php?id=<?= $user['id'] ?>"><button type="button">Remove</button>
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