<?php
require("../includes/db.inc.php");
include_once "../includes/css_js.inc.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$games = getAllGames();

?>

<head>
    <link rel="icon" href="https://via.placeholder.com/70x70">
    <link rel="stylesheet" href="https://unpkg.com/mvp.css">

    <meta charset="utf-8">
    <meta name="description" content="My description">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Game Management - SavePoint</title>
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
        <div class="table-responsive small">
            <table class="table table-hover table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">#ID</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email Address</th>
                        <th scope="col">Date of Birth</th>
                        <th scope="col">Status</th>
                        <th scope="col">Created</th>
                        <th scope="col">Updated</th>
                        <th scope="col">Image</th>
                        <th scope="col">Description</th>
                        <th scope="col">Publisher</th>
                        <th scope="col">Release Date</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($games as $game): ?>

                        <tr>
                            <td><?= $game['id']; ?></td>
                            <td><?= $game['name']; ?></td>
                            <td><?= $game['developer']; ?></td>
                            <td><?= $game['ageRestricted']; ?></td>
                            <td><?= $game['status']; ?></td>
                            <td><?= $game['created']; ?></td>
                            <td><?= $game['updated']; ?></td>
                            <td><?= substr($game['image'], 0, 20) . '(...)'; ?></td>
                            <td><?= substr($game['description'], 0, 50) . '(...)'; ?></td>
                            <td><?= $game['publisher']; ?></td>
                            <td><?= $game['release_date']; ?></td>
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