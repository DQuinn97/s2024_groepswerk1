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
    <link rel="stylesheet" href="./dist/<?= $cssPath ?>" />

    <meta charset="utf-8">
    <meta name="description" content="My description">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $game['name'] ?> - SavePoint</title>
</head>

<body>
    <?php include("includes/header.inc.php"); ?>


    <main>
        <div class="gamedetails">
            <h1><?= $game['name']; ?></h2>
                <!-- <hr /> -->

                <div class="image"><img src="<?= $game['image'] ?>" alt=""><img></div>
                <div class="gamedetail">

                    <p><span>Developed by:</span> <?= $game['developer']; ?></p>
                    <p><span>Published by:</span> <?= $game['publisher']; ?></p>
                    <p><span>Release date:</span> <?= $release; ?></p>
                </div>
                <div class="description">
                    <h4>About:</h4>
                    <p>
                        <?= $game['description']; ?>
                    </p>
                </div>

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
    <?php include("includes/footer.inc.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>