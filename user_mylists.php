<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
include_once "includes/css_js.inc.php";
include "includes/db.inc.php";
include "includes/funcs.inc.php";

requiredLoggedIn();
$UUID = $_SESSION['UUID'];


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SavePoint - My Lists</title>
    <link rel="stylesheet" href="./dist/<?= $cssPath ?>" />
    <script type="module" src="./dist/<?= $jsPath ?>"></script>
</head>

<body>
    <?php include("includes/header.inc.php"); ?>
    <main>
        <div id="lists_container">

            <section class="list">
                <h2>List name</h2>
                <section class="list_container">
                    <a href="details.php?id=<?= $game["id"] ?>">
                        <div class="game_card">
                            <img src="<?= $game["image"]; ?>" alt="<?= "image for " . $name; ?>">
                            <div class="card_title"><?= $name; ?></div>
                            <div class="game_details">
                                <p>Release Year: <?= $releaseDate; ?></p>
                                <!-- <p>Platforms: <?= $game_platforms ?></p> -->
                                <div class="category_tags"><?= $game_categories ?></div>
                            </div>

                            <!-- <div class="list_icon"></div> -->

                        </div>
                    </a>
                    <a href="details.php?id=<?= $game["id"] ?>">
                        <div class="game_card">
                            <img src="<?= $game["image"]; ?>" alt="<?= "image for " . $name; ?>">
                            <div class="card_title"><?= $name; ?></div>
                            <div class="game_details">
                                <p>Release Year: <?= $releaseDate; ?></p>
                                <!-- <p>Platforms: <?= $game_platforms ?></p> -->
                                <div class="category_tags"><?= $game_categories ?></div>
                            </div>

                            <!-- <div class="list_icon"></div> -->

                        </div>
                    </a>
                </section>
            </section>
            <section class="list">
                <h2>List name</h2>
                <section class="list_container">
                    <a href="details.php?id=<?= $game["id"] ?>">
                        <div class="game_card">
                            <img src="<?= $game["image"]; ?>" alt="<?= "image for " . $name; ?>">
                            <div class="card_title"><?= $name; ?></div>
                            <div class="game_details">
                                <p>Release Year: <?= $releaseDate; ?></p>
                                <!-- <p>Platforms: <?= $game_platforms ?></p> -->
                                <div class="category_tags"><?= $game_categories ?></div>
                            </div>

                            <!-- <div class="list_icon"></div> -->

                        </div>
                    </a>
                </section>
            </section>
            <section class="addlist">
                <span>+</span>
            </section>
        </div>
    </main>
    <?php include("includes/footer.inc.php"); ?>
</body>

</html>