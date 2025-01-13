<?php
include "includes/db.inc.php";
include "includes/funcs.inc.php";
include_once "includes/css_js.inc.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$id = (int)@$_GET['id'];
$game = getGameById($id);
$release = formatDateTime($game['release_date']);
$ratings = getRatingsById($id);
$user_id = "";
$game_id = "";
$userRating = null;
$userReview = "";
$errors = [];
$success = false;

if ($id === NULL) {
    header("Location: index.php");
}

if (isset($id)) {
    if (is_string($id) || $id == 0) {
        header("Location: index.php");
    }
}



if (isset($_POST['reviewSubmit'])) {
    $user_id = 1; // TODO: Get user id
    $game_id = $id;
    $userRating = $_POST['inputRating'];
    $userReview = $_POST['inputReview'];

    if (strlen($userReview) < 5) {
        $errors[] = "Review needs to be longer.";
    }

    if (strlen($userReview) > 1000) {
        $errors[] = "Review is too long.";
    }

    if (count($errors) == 0) {
        $success = insertRating(
            $user_id,
            $game_id,
            $userRating,
            $userReview
        );
        header("Location: details.php?id=$id");
    }
}


?>
<html lang="en" data-lt-installed="true">

<head>
    <link rel="icon" href="https://via.placeholder.com/70x70">
    <link rel="stylesheet" href="./dist/<?= $cssPath ?>" />
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
                <tbody>
                    <?php foreach ($ratings as $rating) { ?>
                        <p>
                            <tr>
                                <td><?= $rating['displayname'] ?></td>
                                <td>gave this game a rating of <?= $rating['rating'] ?>:</td>
                                <td>"<?= $rating['review'] ?>"</td><br>
                            </tr>
                        </p>
                    <?php } ?>
                </tbody>
                <?php if (isLoggedIn()) { ?>
                    <?php if (count($errors) > 0): ?>
                        <div class="alert">
                            <ul>
                                <?php foreach ($errors as $error): ?>
                                    <li><?= $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif ?>
                    <form method="post" action="details.php?id=<?= $id ?>">
                        <div class="form" style="padding-top: 2rem;">
                            <label for="inputRating" class="col-sm-2 col-form-label">
                                <p>Recommend:</p>
                            </label>
                            <div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="inputRating" id="inputRating1" value="1" checked>
                                    <label class="form-check-label" for="inputRating1">
                                        Yes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="inputRating" id="inputRating2" value="0">
                                    <label class="form-check-label" for="inputRating2">
                                        No
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form">
                            <label for="inputReview">
                                <p>Review:</p>
                            </label>
                            <div>
                                <textarea name="inputReview" id="inputReview" rows="8" cols="70"></textarea>
                            </div>
                        </div>
                        <div class="form">
                            <div>
                                <button type="input" class="input" name="reviewSubmit" style="width: 5%">Submit</button>
                            </div>
                        </div>
                    </form>
                <?php } ?>
        </div>
    </main>
    <?php include("includes/footer.inc.php"); ?>
</body>