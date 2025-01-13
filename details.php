<?php

include "includes/db.inc.php";
include "includes/funcs.inc.php";
include_once "includes/css_js.inc.php";

$id = (int)@$_GET['id'];
$game = getGameById($id);
$release = formatDateTime($game['release_date']);
$ratings = getRatingsById($id);

session_start();
$UUID = @$_SESSION['UUID'];

if ($id === NULL) {
    header("Location: index.php");
    exit;
}

if (isset($id)) {
    if (is_string($id) || $id == 0) {
        header("Location: index.php");
        exit;
    }
}


if (isset($_POST['lists'])) {
    [$action, $list] = explode('_', $_POST['lists']);
    switch ($action) {
        case "add":
            addGameToList($id, $list);
            break;
        case "remove":
            removeGameFromList($id, $list);
            break;
    }
}

?>
<html lang="en" data-lt-installed="true">

<head>
    <link rel="icon" href="https://via.placeholder.com/70x70">
    <link rel="stylesheet" href="./dist/<?= $cssPath ?>" />
    <link rel="stylesheet" href="./dist/<?= $cssPath ?>" />

    <meta charset="utf-8">
    <meta name="description" content="SavePoint is a gaming database where you can save games in your own personalized lists. This page is a detail page for a specific game.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" src="images/logo70px.webp">
    <title><?= $game['name'] ?> - SavePoint</title>
</head>

<body>
    <?php include("includes/header.inc.php"); ?>
    <main>
        <div class="gamedetails">
            <h1><?= $game['name']; ?></h1>
            <form action="details.php?id=<?= $id ?>" method="POST">

                <label for="lists">Add/Remove from list</label>
                <?php
                $userlists = getUserLists($UUID);
                if (!count($userlists)):
                ?>
                    <span id="forlists">no lists currently available</span>
                <?php else: ?>
                    <select name="lists" id="lists" onchange="this.form.submit()">
                        <option disabled selected value>-- select list</option>
                        <?php foreach ($userlists as $list):
                            $action = !in_array($id, array_map(function ($g) {
                                return $g["id"];
                            }, $list["games"])) ? "add" : "remove"; ?>
                            <option class="<?= $action ?>" value="<?= $action ?>_<?= $list["id"] ?>"><?= $list["name"] ?: 'Unnamed list' ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>
            </form>
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
    </main>
    <?php include("includes/footer.inc.php"); ?>
</body>