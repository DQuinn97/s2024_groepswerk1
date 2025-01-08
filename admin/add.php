<?php
require("../includes/db.inc.php");
include_once "../includes/css_js.inc.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$errors = [];
$success = false;

$name = "";
$developer = "";
$ageRestricted = null;
$status = 1;
$image = "";
$description = "";
$publisher = "";
$release_date = "";

if (isset($_POST['formSubmit'])) {

    $name = $_POST['inputName'];
    $developer = $_POST['inputDeveloper'];
    $ageRestricted = $_POST['inputAgeRestricted'];
    $status = 1;
    $image = $_POST['inputImage'];
    $description = $_POST['inputDescription'];
    $publisher = $_POST['inputPublisher'];
    $release_date = $_POST['inputReleaseDate'];

    if (strlen($name) == 0) {
        $errors[] = "Please enter a name for this game.";
    }

    if (strlen($name) > 63) {
        $errors[] = "Game name is too long.";
    }

    if (strlen($developer) == 0) {
        $errors[] = "Please enter the developer for this game.";
    }

    if (strlen($developer) > 63) {
        $errors[] = "Developer name is too long.";
    }

    if (strlen($image) > 150) {
        $errors[] = "Maximum length for image link is 150 characters.";
    }

    if (strlen($description) == 0) {
        $errors[] = "Please enter a description of this game.";
    }

    if (strlen($description) > 4000) {
        $errors[] = "Game description is too long.";
    }

    if (strlen($publisher) == 0) {
        $errors[] = "Please enter the publisher for this game.";
    }

    if (strlen($publisher) > 63) {
        $errors[] = "Publisher name is too long.";
    }

    if (strlen($release_date) == 0) {
        $errors[] = "Please enter the release date for this game: YYYY-MM-DD";
    }


    if (count($errors) == 0) {
        $success = insertGame(
            $name,
            $developer,
            $ageRestricted,
            $status,
            $image,
            $description,
            $publisher,
            $release_date
        );
        header("Location: games.php");
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

    <title>Add New Game - SavePoint</title>
</head>

<body>


    <div class="container">
        <main>
            <h2>Add new game</h2>
            <hr />

            <a href="games.php"><button type="button" class="btn btn-primary">Return</button></a>

            <?php if (count($errors) > 0): ?>
                <div class="alert alert-danger" role="alert">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif ?>

            <form method="post" action="add.php">

                <div class="form-group mt-3">
                    <label for="inputName" class="col-sm-2 col-form-label">Name: *</label>
                    <div>
                        <input type="text" class="form-control" id="inputName" name="inputName" placeholder="Name" value="<?php echo isset($name) ? $name : ''; ?>">
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label for="inputDeveloper" class="col-sm-2 col-form-label">Developer:</label>
                    <div>
                        <input type="text" class="form-control" id="inputDeveloper" name="inputDeveloper" placeholder="Developer" value="<?php echo isset($developer) ? $developer : ''; ?>">
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label for="inputImage" class="col-sm-2 col-form-label">Image Link: *</label>
                    <div>
                        <input type="text" class="form-control" id="inputImage" name="inputImage" placeholder="Image Link" value="<?php echo isset($image) ? $image : ''; ?>">
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label for="inputDescription" class="col-sm-2 col-form-label">Description:</label>
                    <div>
                        <textarea name="inputDescription" id="inputDescription" style="width: 100%"><?= @$description; ?></textarea>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label for="inputAgeRestricted" class="col-sm-2 col-form-label">Age Restricted: *</label>
                    <div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="inputAgeRestricted" id="inputAgeRestricted1" value="1" checked>
                            <label class="form-check-label" for="inputAgeRestricted1">
                                Yes
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="inputAgeRestricted" id="inputAgeRestricted2" value="0">
                            <label class="form-check-label" for="inputAgeRestricted2">
                                No
                            </label>
                        </div>

                    </div>

                </div>

                <div class="form-group mt-3">
                    <label for="inputPublisher" class="col-sm-2 col-form-label">Publisher: *</label>
                    <div>
                        <input type="text" class="form-control" id="inputPublisher" name="inputPublisher" placeholder="Publisher" value="<?php echo isset($publisher) ? $publisher : ''; ?>">
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label for="inputReleaseDate" class="col-sm-2 col-form-label">Release Date: *</label>
                    <div>
                        <input type="text" class="form-control" id="inputReleaseDate" name="inputReleaseDate" placeholder="Release Date" value="<?php echo isset($release_date) ? $release_date : ''; ?>">
                    </div>
                </div>

                <div class="form-group mt-5">
                    <div>
                        <button type="submit" class="btn btn-primary" name="formSubmit" style="width: 100%">Save</button>
                    </div>
                </div>
            </form>

        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>