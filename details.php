<?php
require("./includes/db.inc.php");
include_once "includes/css_js.inc.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$id = (int)@$_GET['id'];
$game = getGameById($id);
$release = formatDateTime($game['release_date']);
$ratings = getRatingsById($id);

if ($id === NULL) {
    header("Location: index.php");
}

if (isset($id)) {
    if (is_string($id) || $id == 0) {
        header("Location: index.php");
    }
}


?>
<html lang="en" data-lt-installed="true">

<head>
    <link rel="icon" href="https://via.placeholder.com/70x70">
    <link rel="stylesheet" href="https://unpkg.com/mvp.css">

    <meta charset="utf-8">
    <meta name="description" content="My description">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $game['name'] ?> - SavePoint</title>
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
        <div class="container">
            <h1><?= $game['name']; ?></h2>
                <!-- <hr /> -->

                <div class="image"><img src="<?= $game['image'] ?>" alt=""><img></div>
                <p>Developed by: <?= $game['developer']; ?></p>
                <p>Published by: <?= $game['publisher']; ?></p>
                <p>Release date: <?= $release; ?></p>

                <h4>About:</h4>
                <p>
                    <?= $game['description']; ?>
                </p>

        </div>
        <tbody>
            <?php foreach ($ratings as $rating) { ?>
                <tr>
                    <td>User <strong><?= $rating['displayname'] ?></strong></td>
                    <td>gave this game a rating of <strong><?= $rating['rating'] ?></strong>:</td>
                    <td><i>"<?= $rating['review'] ?>"</i></td><br>
                </tr>
            <?php } ?>
        </tbody>
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