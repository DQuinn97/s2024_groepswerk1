<?php
include_once "includes/css_js.inc.php";
include "includes/db.inc.php";
include "includes/funcs.inc.php";

requiredLoggedIn();
$UUID = $_SESSION['UUID'];
$errors = [];


if (isset($_POST['modal_input'])) {
    $name = '';
    if (strlen($_POST['modal_input']) > 32) $errors[] = "List name cant be longer than 32 characters...";
    else $name = $_POST['modal_input'];
    $newlist = createList($UUID, $name);
    if ($newlist) {
        header("Location: user_mylists.php?id=" . $newlist);
        exit;
    }
}

$userlists = getUserLists($UUID);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SavePoint - My Lists</title>
    <link rel="icon" src="images/logo70px.webp">
    <link rel="stylesheet" href="./dist/<?= $cssPath ?>" />
    <script type="module" src="./dist/<?= $jsPath ?>"></script>
</head>

<body>
    <?php include("includes/header.inc.php"); ?>
    <main>
        <?php if (isset($_GET['id'])):
            $id = $_GET['id'];
            $list = getListById($id);
            if ($list["user_id"] !== $UUID) {
                header("Location: user_mylists.php");
                exit;
            }
            $games = getGamesInList($id);

            if (isset($_POST['list_submit'])) {
                if (strlen($_POST['list_name']) > 32) $errors[] = "List name cant be longer than 32 characters...";
                if (strlen($_POST["list_desc"]) > 255) $errors[] = "Description cant be longer than 255 characters...";
                if (!count($errors)) {
                    $check = updateList($id, $_POST['list_name'], $_POST["list_desc"]);
                    if (!$check) $errors[] = "Something went wrong...";
                    $list = getListById($id);
                }
            }
            if (isset($_POST['list_delete'])) {
                deleteList($id);
                header("Location: user_mylists.php");
                exit;
            }

        ?>
            <section id="list">
                <form action="user_mylists.php?id=<?= $id ?>" method="POST">
                    <p>Warning: leaving the page without saving will discard any changes made!</p>
                    <ul id="error_messages"><?php foreach ($errors as $error): ?><li><?= $error ?></li><?php endforeach; ?></ul>

                    <h2><label for="list_name">List:</label></h2><input type="text" name="list_name" id="list_name" value="<?= $list["name"] ?>"><br>
                    <h2><label for="list_desc">Description:</label></h2><textarea name="list_desc" id="list_desc"><?= $list["description"] ?></textarea>
                    <input type="submit" value="save" id="list_submit" name="list_submit">

                    <section id="game_list">
                        <?php foreach ($games as $game):
                            $name = $game["name"];
                            $releaseDate = substr($game["release_date"], 0, 4);

                            $game_categories = array_map(function ($g) {
                                return $g["name"];
                            }, $game["categories"]);
                            $rdm_categories = [];
                            $rdm_categories_keys = array_rand($game_categories, min(5, count($game_categories)));
                            if (is_array($rdm_categories_keys)) {
                                foreach (
                                    $rdm_categories_keys as $key
                                ) {
                                    $rdm_categories[] = $game_categories[$key];
                                }
                            } else {
                                $rdm_categories = $game_categories;
                            }
                            $game_categories = array_map(function ($g) {
                                return "<span class='category_tag'> $g </span>";
                            }, $rdm_categories);
                            $game_categories = join('', $game_categories);


                        ?>
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
                        <?php endforeach; ?>

                    </section>
                    <input type="submit" value="delete" id="list_delete" name="list_delete">
                </form>
            </section>
        <?php else: ?>
            <div id="lists_container">
                <?php foreach ($userlists as $index => $list): ?>
                    <section class="list">
                        <a href="user_mylists.php?id=<?= $list["id"] ?>">
                            <h2><?= $list["name"] ?: "Unnamed list" ?><span> <?= $list["description"] ?></span></h2>
                        </a>
                        <section class="list_container">
                            <?php foreach ($list["games"] as $game):  $name = $game["name"]; ?>

                                <a href="details.php?id=<?= $game["id"] ?>">
                                    <div class="game_card">
                                        <img src="<?= $game["image"]; ?>" alt="<?= "image for " . $name; ?>">
                                        <div class="card_title"><?= $name; ?></div>
                                        <!-- <div class="list_icon"></div> -->

                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </section>
                    </section>
                <?php endforeach; ?>
                <section class="addlist">
                    <span id="open_modal">+</span>
                    <section id="modal" class="modal">
                        <form action="user_mylists.php" method="POST" class="modal-content">
                            <input type="hidden" name="UUID" value="<?= $UUID ?>">
                            <p>Choose name for new list: </p>
                            <input type="text" name="modal_input" id="modal_input" class="modal-input">
                        </form>
                    </section>
                </section>
            </div>
        <?php endif; ?>
    </main>
    <?php include("includes/footer.inc.php"); ?>
</body>

</html>